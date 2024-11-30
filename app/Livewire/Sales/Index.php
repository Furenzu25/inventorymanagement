<?php

namespace App\Livewire\Sales;

use App\Models\Sale;
use App\Models\AccountReceivable;
use App\Models\Payment;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'completion_date';
    public $sortDirection = 'desc';

    public function createSaleFromAR(AccountReceivable $ar)
    {
        DB::transaction(function () use ($ar) {
            $totalInterest = $ar->total_paid - $ar->total_amount;
            
            // Create the main sale record
            Sale::create([
                'account_receivable_id' => $ar->id,
                'customer_id' => $ar->customer_id,
                'preorder_id' => $ar->preorder_id,
                'total_amount' => $ar->total_paid,
                'interest_earned' => $totalInterest,
                'completion_date' => now(),
                'payment_method' => 'Monthly Payment',
                'status' => 'completed',
                'notes' => 'Converted from Account Receivable #' . $ar->id
            ]);

            // Update AR status
            $ar->update(['status' => 'completed']);
        });
        
        session()->flash('message', 'Account Receivable successfully converted to Sale.');
    }

    public function recordCustomerPayment(Payment $payment)
    {
        DB::transaction(function () use ($payment) {
            // Create sale record for the payment
            Sale::create([
                'customer_id' => $payment->customer_id,
                'preorder_id' => $payment->preorder_id,
                'account_receivable_id' => $payment->account_receivable_id,
                'total_amount' => $payment->amount,
                'payment_method' => $payment->payment_method,
                'completion_date' => $payment->payment_date,
                'status' => 'completed',
                'payment_reference' => $payment->reference_number,
                'type' => 'customer_payment',
                'notes' => 'Payment made by customer'
            ]);

            // Update payment status if needed
            $payment->update(['recorded_in_sales' => true]);
        });
    }

    public function getSalesTrendData()
    {
        return Sale::selectRaw('DATE(completion_date) as date, SUM(total_amount) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(function ($sale) {
                return [
                    'date' => Carbon::parse($sale->date)->format('M d, Y'),
                    'total' => floatval($sale->total)
                ];
            });
    }

    public function render()
    {
        $salesTrend = $this->getSalesTrendData();

        return view('livewire.sales.index', [
            'sales' => Sale::query()
                ->when($this->search, function ($query) {
                    $query->whereHas('customer', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    });
                })
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate(10),
            'salesTrend' => $salesTrend
        ]);
    }
} 