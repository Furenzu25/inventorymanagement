<?php

namespace App\Livewire\Payments;

use Livewire\Component;
use App\Models\Sale;
use App\Models\Payment;

class History extends Component
{
    public $sale;

    public function mount($sale = null)
    {
        if ($sale instanceof Sale) {
            $this->sale = $sale;
        } elseif (is_numeric($sale)) {
            $this->sale = Sale::findOrFail($sale);
        } else {
            $this->sale = null;
        }
    }

    public function render()
    {
        if ($this->sale instanceof Sale) {
            $payments = $this->sale->payments()->orderBy('payment_date', 'desc')->get();
            $title = "Payment History for Sale #{$this->sale->id}";
        } else {
            $payments = Payment::with('sale')->orderBy('payment_date', 'desc')->get();
            $title = "All Payment History";
        }

        return view('livewire.payments.history', [
            'payments' => $payments,
            'title' => $title,
        ]);
    }
}
