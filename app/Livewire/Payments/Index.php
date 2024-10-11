<?php

namespace App\Livewire\Payments;

use Livewire\Component;
use App\Models\Payment;
use App\Models\Sale;
use App\Models\Preorder;
use App\Models\Customer;

class Index extends Component
{
    public $preorder_id;
    public $customer_id;
    public $sale_id;
    public $amount_paid;
    public $payment_date;
    public $due_amount;

    protected $rules = [
        'preorder_id' => 'required|exists:preorders,id',
        'customer_id' => 'required|exists:customers,id',
        'sale_id' => 'required|exists:sales,id',
        'amount_paid' => 'required|numeric|min:0',
        'payment_date' => 'required|date',
        'due_amount' => 'required|numeric|min:0',
    ];

    public function store()
    {
        $validatedData = $this->validate();

        $payment = Payment::create($validatedData);

        // Update the sale's total_paid and remaining_balance
        $sale = Sale::findOrFail($validatedData['sale_id']);
        $sale->total_paid += $payment->amount_paid;
        $sale->remaining_balance -= $payment->amount_paid;
        $sale->save();

        $this->reset(['preorder_id', 'customer_id', 'sale_id', 'amount_paid', 'payment_date', 'due_amount']);
        session()->flash('message', 'Payment recorded successfully.');
    }

    public function render()
    {
        return view('livewire.payments.index', [
            'preorders' => Preorder::with('preorderItems.product')->get(),
            'customers' => Customer::all(),
            'sales' => Sale::all(),
        ]);
    }
}
