<?php

namespace App\Livewire\Ecommerce;

use Livewire\Component;
use App\Traits\WithCartCount;
use App\Traits\WithNotificationCount;
use App\Models\Preorder;
use App\Models\PreorderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\InventoryItem;
use App\Notifications\PreorderStatusNotification;
use App\Models\User;
use App\Notifications\AdminPreorderNotification;
use App\Models\CustomerNotification;

class Cart extends Component
{
    use WithCartCount;
    use WithNotificationCount;

    public $cartItems = [];
    public $loanDuration = 12;
    public $paymentMethod = '';
    private $interestRate = 5.00;

    protected $rules = [
        'loanDuration' => 'required|integer|in:6,12,24,36',
        'paymentMethod' => 'required|string|in:Card,Cash,Bank Transfer',
    ];

    protected $messages = [
        'paymentMethod.required' => 'Please select a payment method.',
        'paymentMethod.in' => 'Please select a valid payment method.',
    ];

    public function mount()
    {
        $this->cartItems = session('cart', []);
    }

    public function removeItem($index)
    {
        unset($this->cartItems[$index]);
        $this->cartItems = array_values($this->cartItems);
        session(['cart' => $this->cartItems]);
    }

    public function submitPreorder()
    {
        $this->validate();

        if (empty($this->cartItems)) {
            session()->flash('error', 'Your cart is empty. Please add items before submitting a pre-order.');
            return;
        }

        $user = auth()->user();
        if (!$user->customer) {
            session()->flash('error', 'Please complete your customer profile before placing an order.');
            return;
        }

        $totalAmount = $this->getTotal();

        DB::transaction(function () use ($user, $totalAmount, &$preorder) {
            $preorder = Preorder::create([
                'customer_id' => $user->customer->id,
                'loan_duration' => $this->loanDuration,
                'total_amount' => $totalAmount,
                'status' => 'Pending',
                'order_date' => now(),
                'monthly_payment' => $this->calculateMonthlyPayment($totalAmount, $this->loanDuration, $this->interestRate),
                'interest_rate' => $this->interestRate,
                'payment_method' => $this->paymentMethod,
                'bought_location' => 'Online',
            ]);
            
            foreach ($this->cartItems as $item) {
                $preorder->products()->attach($item['id'], [
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'variant_id' => $item['variant_id'] ?? null,
                ]);
            }
        });

        // Send notification to customer
        CustomerNotification::create([
            'customer_id' => $user->customer->id,
            'title' => 'Pre-order Submitted',
            'message' => "Your pre-order #{$preorder->id} has been submitted successfully. Total amount: ₱" . number_format($totalAmount, 2),
            'type' => 'preorder_status'
        ]);

        // Send notification to admin users
        $adminUsers = User::where('is_admin', true)->get();
        foreach ($adminUsers as $admin) {
            $admin->notify(new AdminPreorderNotification($preorder));
        }

        session()->forget('cart');
        $this->cartItems = [];

        session()->flash('message', 'Pre-order submitted successfully.');
        return redirect()->route('home');
    }

    private function calculateMonthlyPayment($totalAmount, $loanDuration, $interestRate)
    {
        // Calculate total interest amount
        $totalInterest = $totalAmount * ($interestRate / 100);
        
        // Calculate fixed monthly payment
        $monthlyPayment = ($totalAmount + $totalInterest) / $loanDuration;
        
        return round($monthlyPayment, 2);
    }
    public function getTotal()
    {
        return collect($this->cartItems)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
    }

    public function render()
    {
        return view('livewire.ecommerce.cart', [
            'paymentMethods' => Preorder::getPaymentMethods(),
            'loanDurationOptions' => $this->getLoanDurationOptions()
        ])->layout('components.layouts.guest');
    }

    public function refreshCart()
    {
        $this->cartItems = session('cart', []);
    }

    public function getTotalItemsCount()
    {
        return array_sum(array_column($this->cartItems, 'quantity'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function cancelPreorder($preorderId)
    {
        DB::transaction(function () use ($preorderId) {
            $preorder = Preorder::where('id', $preorderId)
                               ->where('customer_id', Auth::user()->customer->id)
                               ->firstOrFail();
            
            // If there's an inventory item assigned, mark it as available
            $inventoryItem = InventoryItem::where('preorder_id', $preorder->id)->first();
            if ($inventoryItem) {
                $inventoryItem->update([
                    'status' => 'in_stock',
                    'preorder_id' => null
                ]);
            }
            
            $preorder->update(['status' => 'Cancelled']);
        });
        
        session()->flash('message', 'Your pre-order has been cancelled successfully.');
        return redirect()->route('home');
    }

    public function getLoanDurationOptions()
    {
        return [
            6 => '6 months',
            12 => '12 months',
            24 => '24 months',
            36 => '36 months'
        ];
    }
}
