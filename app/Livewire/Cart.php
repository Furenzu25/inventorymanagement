<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Preorder;
use App\Models\PreorderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Cart extends Component
{
    public $cartItems = [];
    public $loanDuration = 12; // Default to 12 months, you can make this adjustable
    private $interestRate = 5.00; // You can make this configurable
    public $cartCount = 0;

    public function mount()
    {
        $this->cartItems = session('cart', []);
        $this->cartCount = count($this->cartItems);
    }

    public function removeItem($index)
    {
        unset($this->cartItems[$index]);
        $this->cartItems = array_values($this->cartItems);
        session(['cart' => $this->cartItems]);
        $this->cartCount = count($this->cartItems);
    }

    public function submitPreorder()
    {
        $user = Auth::user();
        
        if (!$user->customer) {
            session()->flash('error', 'You need to be associated with a customer account to submit a preorder.');
            return redirect()->route('home');
        }

        $totalAmount = collect($this->cartItems)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        Log::info('Submitting preorder for user: ' . $user->id);
        Log::info('Cart items: ' . json_encode($this->cartItems));
        Log::info('Total amount: ' . $totalAmount);

        Log::info('Transaction started');
        DB::transaction(function () use ($user, $totalAmount) {
            Log::info('Creating preorder for user: ' . $user->id);

            $preorder = Preorder::create([
                'customer_id' => $user->customer->id,
                'loan_duration' => $this->loanDuration,
                'total_amount' => $totalAmount,
                'status' => 'Pending',
                'order_date' => now(),
                'monthly_payment' => $this->calculateMonthlyPayment($totalAmount, $this->loanDuration, $this->interestRate),
                'interest_rate' => $this->interestRate,
                'payment_method' => 'Card',
                'bought_location' => 'Online', // Set a default value instead of null
            ]);

            Log::info('Preorder created successfully');
            
            foreach ($this->cartItems as $item) {
                Log::info('Adding item to preorder: ' . json_encode($item));
                $preorder->products()->attach($item['id'], [
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }
            Log::info('All items added to preorder');
        });
        Log::info('Transaction completed');

        session()->forget('cart');
        $this->cartItems = [];
        $this->cartCount = 0;

        session()->flash('message', 'Pre-order submitted successfully.');
        return redirect()->route('home');
    }

    private function calculateMonthlyPayment($totalAmount, $loanDuration, $interestRate)
    {
        $monthlyInterestRate = $interestRate / 12 / 100;
        $numberOfPayments = $loanDuration;
        
        $monthlyPayment = $totalAmount * ($monthlyInterestRate * pow(1 + $monthlyInterestRate, $numberOfPayments)) 
                        / (pow(1 + $monthlyInterestRate, $numberOfPayments) - 1);
        
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
        $this->refreshCart();
        return view('livewire.cart')->layout('components.layouts.guest');
    }

    public function refreshCart()
    {
        $this->cartItems = session('cart', []);
        $this->cartCount = count($this->cartItems);
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
}
