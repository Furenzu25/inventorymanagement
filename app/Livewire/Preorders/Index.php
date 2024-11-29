<?php

namespace App\Livewire\Preorders;

use Livewire\Component;
use App\Models\Preorder;
use App\Models\PreorderItem;
use App\Models\Customer;
use App\Models\Product;
use Livewire\WithPagination;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\InventoryItem;
use App\Models\AccountReceivable;
use App\Models\CustomerNotification;
use App\Services\NotificationService;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $sortBy = ['column' => 'order_date', 'direction' => 'desc'];
    public $modalOpen = false;
    public $preorderId;
    public $preorder = [
        'customer_id' => '',
        'loan_duration' => '',
        'bought_location' => '',
        'status' => '',
        'payment_method' => '',
        'order_date' => '',
    ];
    public $preorderItems = [];
    public $customers;
    public $products;
    public $showDisapprovalModal = false;
    public $disapprovalReason = '';
    public $selectedPreorderId;

    protected $rules = [
        'preorder.customer_id' => 'required|exists:customers,id',
        'preorder.loan_duration' => 'required|numeric|min:0',
        'preorder.bought_location' => 'required',
        'preorder.status' => 'required',
        'preorder.payment_method' => 'required',
        'preorder.order_date' => 'required|date',
        'preorderItems.*.product_id' => 'required|exists:products,id',
        'preorderItems.*.quantity' => 'required|numeric|min:1',
        'preorderItems.*.price' => 'required|numeric|min:0',
    ];

    public function create()
    {
        $this->resetPreorder();
        $this->preorderId = null;
        $this->modalOpen = true;
    }

    public function edit($id)
    {
        $this->preorder = Preorder::findOrFail($id)->toArray();
        $this->preorderItems = PreorderItem::where('preorder_id', $id)->get()->toArray();
        $this->preorderId = $id;
        $this->modalOpen = true;
    }

    public function store()
    {
        $this->validate();

        DB::transaction(function () {
            $totalAmount = 0;
            foreach ($this->preorderItems as $item) {
                $totalAmount += $item['quantity'] * $item['price'];
            }

            $interestRate = 5.00; // You might want to make this configurable
            $monthlyPayment = $this->calculateMonthlyPayment($totalAmount, $this->preorder['loan_duration'], $interestRate);

            $preorderData = array_merge($this->preorder, [
                'total_amount' => $totalAmount,
                'monthly_payment' => $monthlyPayment,
                'interest_rate' => $interestRate,
            ]);

            if (isset($this->preorder['id'])) {
                $preorder = Preorder::findOrFail($this->preorder['id']);
                $preorder->update($preorderData);
                $preorder->preorderItems()->delete();
            } else {
                $preorder = Preorder::create($preorderData);
            }

            foreach ($this->preorderItems as $item) {
                $preorder->products()->attach($item['product_id'], [
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }
        });

        $this->modalOpen = false;
        $this->reset(['preorder', 'preorderItems', 'preorderId']);
        session()->flash('message', isset($this->preorder['id']) ? 'Pre-order updated successfully.' : 'Pre-order created successfully.');
    }

    public function delete($id)
    {
        Preorder::findOrFail($id)->delete();
        session()->flash('message', 'Pre-order deleted successfully.');
    }

    public function resetPreorder()
    {
        $this->preorder = [
            'customer_id' => '',
            'loan_duration' => '',
            'bought_location' => '',
            'status' => '',
            'payment_method' => '',
            'order_date' => Carbon::now()->format('Y-m-d'),
        ];
        $this->preorderItems = [
            [
                'product_id' => '',
                'quantity' => 1,
                'price' => '',
            ]
        ];
    }

    public function addItem()
    {
        $this->preorderItems[] = [
            'product_id' => '',
            'quantity' => 1,
            'price' => '',
        ];
    }

    public function removeItem($index)
    {
        unset($this->preorderItems[$index]);
        $this->preorderItems = array_values($this->preorderItems);
    }

    public function render()
    {
        return view('livewire.preorders.index', [
            'preorders' => Preorder::with([
                'customer:id,name,email',
                'preorderItems.product:id,product_name,price'
            ])
            ->latest()
            ->paginate(10)
        ]);
    }

    public function headers(): array
    {
        return [
            ['key' => 'customer.name', 'label' => 'Customer', 'sortable' => true],
            ['key' => 'loan_duration', 'label' => 'Loan Duration', 'sortable' => true],
            ['key' => 'total_amount', 'label' => 'Total Amount', 'sortable' => true],
            ['key' => 'monthly_payment', 'label' => 'Monthly Payment', 'sortable' => true],
            ['key' => 'bought_location', 'label' => 'Bought Location', 'sortable' => true],
            ['key' => 'status', 'label' => 'Status', 'sortable' => true],
            ['key' => 'payment_method', 'label' => 'Payment Method', 'sortable' => true],
            ['key' => 'order_date', 'label' => 'Order Date', 'sortable' => true],
        ];
    }

    public function mount()
    {
        $this->preorders = Preorder::with('customer')->latest()->paginate(10);
    }

    public function loadCustomersAndProducts()
    {
        $this->customers = Customer::all();
        $this->products = Product::all();
    }

    public function updatedPreorderItems($value, $index)
    {
        if (str_contains($index, 'product_id')) {
            $itemIndex = explode('.', $index)[0];
            $product = Product::find($value);
            if ($product) {
                $this->preorderItems[$itemIndex]['price'] = $product->price;
            }
        }
    }

    private function calculateMonthlyPayment($totalAmount, $loanDuration, $interestRate)
    {
        // Calculate total interest amount
        $totalInterest = $totalAmount * ($interestRate / 100);
        
        // Calculate fixed monthly payment (principal + interest)
        $monthlyPayment = ($totalAmount + $totalInterest) / $loanDuration;
        
        return round($monthlyPayment, 2);
    }

    public function approvePreorder($id)
    {
        DB::transaction(function () use ($id) {
            $preorder = Preorder::findOrFail($id);
            $preorder->update(['status' => Preorder::STATUS_APPROVED]);

            // Create customer notification
            NotificationService::preorderApproved($preorder);

            // Rest of your approval logic...
        });
        
        session()->flash('message', 'Pre-order approved successfully.');
    }

    public function cancelPreorder($preorderId)
    {
        DB::transaction(function () use ($preorderId) {
            $preorder = Preorder::findOrFail($preorderId);
            
            // Get the inventory item associated with this preorder
            $inventoryItem = InventoryItem::where('preorder_id', $preorderId)->first();
            
            if ($inventoryItem) {
                // Free up the inventory item for reassignment
                $inventoryItem->update([
                    'status' => 'available',
                    'preorder_id' => null
                ]);
            }
            
            // Mark the preorder as cancelled
            $preorder->update(['status' => 'cancelled']);
            
            session()->flash('message', 'Pre-order cancelled successfully. Product is now available for reassignment.');
        });
    }

    public function openDisapprovalModal($id)
    {
        $this->selectedPreorderId = $id;
        $this->disapprovalReason = '';
        $this->showDisapprovalModal = true;
    }

    public function disapprovePreorder()
    {
        $this->validate([
            'disapprovalReason' => 'required|min:10',
        ], [
            'disapprovalReason.required' => 'Please provide a reason for disapproval.',
            'disapprovalReason.min' => 'The reason must be at least 10 characters.',
        ]);

        DB::transaction(function () {
            $preorder = Preorder::findOrFail($this->selectedPreorderId);
            
            $preorder->update([
                'status' => Preorder::STATUS_DISAPPROVED,
                'disapproval_reason' => $this->disapprovalReason
            ]);

            // Use NotificationService instead of direct creation
            NotificationService::preorderDisapproved($preorder, $this->disapprovalReason);
        });

        $this->showDisapprovalModal = false;
        $this->reset(['disapprovalReason', 'selectedPreorderId']);
        
        session()->flash('message', 'Pre-order has been disapproved.');
    }
}
