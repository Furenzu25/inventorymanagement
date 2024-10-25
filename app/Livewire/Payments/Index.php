<?php

namespace App\Livewire\Payments;

use Livewire\Component;
use App\Models\Payment;
use App\Models\Sale;
use Illuminate\Validation\Rule;

class Index extends Component
{
    public $sale_id;
    public $amount_paid;
    public $payment_date;
    public $due_amount;

    public function rules()
    {
        return [
            'sale_id' => 'required|exists:sales,id',
            'amount_paid' => [
                'required',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) {
                    if ($this->sale_id) {
                        $sale = Sale::find($this->sale_id);
                        if ($value > $sale->remaining_balance) {
                            $fail("The payment amount cannot exceed the remaining balance of " . number_format($sale->remaining_balance, 2));
                        }
                    }
                },
            ],
            'payment_date' => 'required|date',
        ];
    }

    public function updated($propertyName)
    {
        if ($propertyName === 'sale_id') {
            $this->updateDueAmount();
        }
        $this->validateOnly($propertyName);
    }

    public function updateDueAmount()
    {
        if ($this->sale_id) {
            $sale = Sale::find($this->sale_id);
            $this->due_amount = $sale->remaining_balance;
        } else {
            $this->due_amount = null;
        }
    }

    public function store()
    {
        $validatedData = $this->validate();
        $validatedData['due_amount'] = $this->due_amount;

        $sale = Sale::findOrFail($validatedData['sale_id']);

        $payment = Payment::create($validatedData);

        $sale->updatePayment($payment->amount_paid);

        $this->reset(['sale_id', 'amount_paid', 'payment_date', 'due_amount']);
        
        $message = 'Payment recorded successfully.';
        if ($sale->status === 'paid') {
            $message .= ' The sale has been fully paid.';
        }
        session()->flash('message', $message);
    }

    public function render()
    {
        return view('livewire.payments.index', [
            'sales' => Sale::with(['customer', 'preorder.preorderItems.product'])->get(),
        ]);
    }
}
