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
                if (!empty($item['product_id'])) {
                    $preorder->preorderItems()->create([
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                    ]);
                }
            }
        });

        session()->flash('message', isset($this->preorder['id']) ? 'Preorder updated successfully.' : 'Preorder created successfully.');
        $this->reset(['preorder', 'preorderItems']);
        $this->modalOpen = false;
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
        $preorders = Preorder::with(['customer', 'preorderItems.product'])
            ->where(function ($query) {
                $query->whereHas('customer', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                })->orWhereHas('preorderItems.product', function ($q) {
                    $q->where('product_name', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy($this->sortBy['column'], $this->sortBy['direction'])
            ->paginate(10);

        return view('livewire.preorders.index', [
            'preorders' => $preorders,
            'customers' => Customer::all(),
            'products' => Product::all(),
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
        $this->loadCustomersAndProducts();
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
        $monthlyInterestRate = $interestRate / 12 / 100;
        $numberOfPayments = $loanDuration;
        
        $monthlyPayment = $totalAmount * ($monthlyInterestRate * pow(1 + $monthlyInterestRate, $numberOfPayments)) 
                        / (pow(1 + $monthlyInterestRate, $numberOfPayments) - 1);
        
        return round($monthlyPayment, 2);
    }
}
