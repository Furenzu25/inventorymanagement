<?php

namespace App\Livewire\Sales;

use App\Models\Sale;
use App\Models\AccountReceivable;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'completion_date';
    public $sortDirection = 'desc';

    public function createSaleFromAR(AccountReceivable $ar)
    {
        $totalInterest = $ar->total_paid - $ar->total_amount;
        
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

        $ar->update(['status' => 'completed']);
        
        session()->flash('message', 'Account Receivable successfully converted to Sale.');
    }

    public function render()
    {
        return view('livewire.sales.index', [
            'sales' => Sale::query()
                ->when($this->search, function ($query) {
                    $query->whereHas('customer', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    });
                })
                ->orderBy('type', 'desc')
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate(10)
        ]);
    }
} 