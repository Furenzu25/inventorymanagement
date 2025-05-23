<?php

namespace App\Livewire\Payments;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Payment;
use App\Models\AccountReceivable;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use App\Models\Sale;
use App\Models\InventoryItem;
use App\Models\PaymentSubmission;
use App\Notifications\PaymentApproved;
use App\Notifications\PaymentRejected;
use App\Services\NotificationService;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $perPage = 10;
    public $search = '';
    public $paymentHistoryOpen = false;
    public $recordPaymentOpen = false;
    public $selectedCustomer = null;
    public $selectedCustomerPayments = [];
    public $payment = [
        'due_amount' => '',
        'amount_paid' => '',
        'payment_date' => ''
    ];
    public $selectedAR = null;
    public $editingPayment = null;
    public $isEditing = false;
    public $originalPayment = null;
    public $confirmingReverse = null;
    public $reversalModalOpen = false;
    public $reversalStage = 'confirm'; // 'confirm' or 'edit'
    public $paymentToReverse = null;
    public $newPaymentAmount = '';
    public $newPaymentDate = '';
    public $originalRemainingBalance = 0;
    public $paymentSubmissions = [];
    public $viewingSubmission = null;
    public $submissionModalOpen = false;
    public $showApprovalModal = false;
    public $showRejectionModal = false;
    public $rejectionReason = '';
    public $filterStatus = '';
    public $sortBy = 'latest';
    public $totalPayments = 0;
    public $pendingCount = 0;
    public $todayPayments = 0;
    public $customerSearch = '';
    public $accountReceivables = [];
  
    public $selectedARDetails = null;
    public $showVoidModal = false;
    public $selectedPayment = null;
    public $voidReason = '';

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function mount()
    {
        $this->loadAccountReceivables();
        $this->loadPaymentSubmissions();
        $this->refreshStats();

        // Check for pending submission to view
        if ($pendingSubmissionId = session('pending_payment_submission')) {
            try {
                // View the submission directly in mount
                $this->viewSubmission($pendingSubmissionId);
                
                // Clear the session immediately after processing
                session()->forget('pending_payment_submission');
            } catch (\Exception $e) {
                \Log::error('Error loading payment submission:', [
                    'submission_id' => $pendingSubmissionId,
                    'error' => $e->getMessage()
                ]);
                session()->flash('error', 'Unable to load payment submission.');
            }
        }
    }

    public function loadAccountReceivables()
    {
        $this->accountReceivables = AccountReceivable::with('customer')
            ->where('status', 'ongoing')
            ->get()
            ->map(function($ar) {
                // Add the total with interest to each AR
                $ar->display_amount = $ar->getTotalAmountWithInterest();
                return $ar;
            });
    }

    public function loadPaymentSubmissions()
    {
        $this->paymentSubmissions = PaymentSubmission::with(['customer', 'accountReceivable'])
            ->where('status', '=', 'pending')
            ->latest()
            ->get();
    }

    public function viewSubmission($submissionId)
    {
        try {
            $this->viewingSubmission = PaymentSubmission::with(['customer', 'accountReceivable'])
                ->findOrFail($submissionId);
            $this->submissionModalOpen = true;
        } catch (\Exception $e) {
            session()->flash('error', 'Payment submission not found.');
        }
    }

    public function approveSubmission()
    {
        DB::transaction(function () {
            // Calculate interest earned as 5% of payment amount
            $interestEarned = $this->viewingSubmission->amount * 0.05;

            // Create payment record
            $payment = Payment::create([
                'account_receivable_id' => $this->viewingSubmission->account_receivable_id,
                'amount_paid' => $this->viewingSubmission->amount,
                'payment_date' => $this->viewingSubmission->payment_date,
                'due_amount' => $this->viewingSubmission->due_amount,
                'remaining_balance' => $this->viewingSubmission->accountReceivable->remaining_balance - $this->viewingSubmission->amount,
                'status' => 'active'
            ]);

            // Update submission status
            $this->viewingSubmission->update(['status' => 'approved']);

            // Update account receivable
            $ar = $this->viewingSubmission->accountReceivable;
            $ar->total_paid += $this->viewingSubmission->amount;
            $ar->remaining_balance -= $this->viewingSubmission->amount;
            
            $wasCompleted = false;
            if ($ar->remaining_balance <= 0) {
                $ar->status = 'completed';
                $wasCompleted = true;
            }
            
            $ar->save();

            // If AR was completed, update inventory status
            if ($wasCompleted) {
                // Update inventory items
                InventoryItem::where('preorder_id', $ar->preorder_id)
                    ->update([
                        'status' => 'stocked_out',
                        'updated_at' => now()
                    ]);
                
                // Emit event for inventory component
                $this->dispatch('arCompleted', $ar->id);
            }

            // Create corresponding sale record with fixed 5% interest
            Sale::create([
                'account_receivable_id' => $ar->id,
                'customer_id' => $ar->customer_id,
                'preorder_id' => $ar->preorder_id,
                'total_amount' => $this->viewingSubmission->amount,
                'interest_earned' => round($interestEarned, 2), // 5% of payment amount
                'completion_date' => $this->viewingSubmission->payment_date,
                'payment_method' => 'Monthly Payment',
                'status' => $ar->remaining_balance <= 0 ? 'completed' : 'ongoing',
                'type' => 'customer_payment',
                'payment_reference' => $this->viewingSubmission->reference_number,
                'notes' => 'Payment made by customer'
            ]);
        });

        $this->showApprovalModal = false;
        $this->submissionModalOpen = false;
        $this->viewingSubmission = null;
        
        $this->loadPaymentSubmissions();
        $this->refreshStats();
        session()->flash('message', 'Payment has been approved successfully.');
    }

    public function rejectSubmission()
    {
        $this->validate([
            'rejectionReason' => 'required|min:10'
        ]);

        DB::transaction(function () {
            $this->viewingSubmission->update([
                'status' => 'rejected',
                'rejection_reason' => $this->rejectionReason
            ]);
            
            // Notify customer
            NotificationService::paymentRejected($this->viewingSubmission);
        });

        $this->showRejectionModal = false;
        $this->submissionModalOpen = false;
        $this->viewingSubmission = null;
        $this->rejectionReason = '';
        
        $this->loadPaymentSubmissions();
        session()->flash('message', 'Payment has been rejected.');
    }

    public function openApprovalModal()
    {
        $this->submissionModalOpen = false;
        $this->showApprovalModal = true;
    }

    public function openRejectionModal()
    {
        $this->submissionModalOpen = false;
        $this->showRejectionModal = true;
    }

    public function viewPaymentHistory($customerId)
    {
        $this->selectedCustomer = Customer::with([
            'accountReceivables.payments', 
            'accountReceivables.preorder.preorderItems.product'
        ])->find($customerId);
        $this->paymentHistoryOpen = true;
        $this->selectedAR = null;
        $this->selectedCustomerPayments = collect();
    }

    public function closePaymentHistory()
    {
        $this->paymentHistoryOpen = false;
        $this->selectedCustomer = null;
        $this->selectedCustomerPayments = [];
    }

    public function selectCustomer($customerId)
    {
        $this->selectedCustomer = Customer::findOrFail($customerId);
        $this->selectedCustomerPayments = Payment::whereHas('accountReceivable', function($query) use ($customerId) {
            $query->where('customer_id', $customerId);
        })->orderBy('payment_date', 'desc')->get();
        $this->paymentHistoryOpen = true;
    }

    public function selectAR($arId)
    {
        if ($arId) {
            $this->selectedAR = $arId;
            $ar = AccountReceivable::find($arId);
            
            // Load all payments for this AR
            $this->selectedCustomerPayments = Payment::where('account_receivable_id', $arId)
                ->orderBy('payment_date', 'desc')
                ->get();
            
            // Update the remaining balance to include interest
            if ($ar) {
                $this->payment['remaining_balance'] = $ar->getRemainingBalanceWithInterest();
            }
        } else {
            $this->selectedAR = null;
            $this->selectedCustomerPayments = collect();
        }
    }

    public function showRecordPayment()
    {
        if (!$this->selectedCustomer) {
            session()->flash('error', 'Please select a customer first.');
            return;
        }

        if (!$this->selectedAR) {
            session()->flash('error', 'Please select an Account Receivable first.');
            return;
        }

        if ($this->selectedAR->status === 'completed') {
            session()->flash('error', 'This Account Receivable is already fully paid.');
            return;
        }

        // Calculate total amount with interest
        $totalWithInterest = $this->selectedAR->total_amount * (1 + ($this->selectedAR->interest_rate / 100));
        
        $this->payment['due_amount'] = $this->selectedAR->monthly_payment;
        $this->payment['amount_paid'] = '';
        $this->payment['payment_date'] = date('Y-m-d');
        $this->payment['total_with_interest'] = $totalWithInterest;
        $this->payment['remaining_balance'] = $totalWithInterest - $this->selectedAR->total_paid;
        
        $this->recordPaymentOpen = true;
    }

    public function closeRecordPayment()
    {
        $this->recordPaymentOpen = false;
        $this->isEditing = false;
        $this->editingPayment = null;
        $this->reset('payment');
    }

    public function recordPayment()
    {
        $this->validate([
            'selectedAR' => 'required|exists:account_receivables,id',
            'payment.amount_paid' => 'required|numeric|min:0',
            'payment.payment_date' => 'required|date',
        ]);

        try {
            DB::transaction(function () {
                $ar = AccountReceivable::findOrFail($this->selectedAR);
                
                // Create the payment record
                $payment = Payment::create([
                    'account_receivable_id' => $ar->id,
                    'customer_id' => $ar->customer_id,
                    'amount_paid' => $this->payment['amount_paid'],
                    'payment_date' => $this->payment['payment_date'],
                    'status' => 'active',
                    // ... other payment fields ...
                ]);

                // Update AR balances
                $ar->total_paid += $this->payment['amount_paid'];
                $ar->remaining_balance -= $this->payment['amount_paid'];
                
                if ($ar->remaining_balance <= 0) {
                    $ar->status = 'paid';
                }
                
                $ar->save();

                // Create corresponding sale record
                Sale::create([
                    'customer_id' => $ar->customer_id,
                    'preorder_id' => $ar->preorder_id,
                    'account_receivable_id' => $ar->id,
                    'total_amount' => $this->payment['amount_paid'],
                    'interest_earned' => $this->calculateInterestEarned($ar, $this->payment['amount_paid']),
                    'completion_date' => $this->payment['payment_date'],
                    'payment_method' => 'Monthly Payment',
                    'status' => 'completed',
                    'type' => 'customer_payment',
                    'payment_reference' => $payment->reference_number ?? null,
                    'notes' => 'Monthly payment recorded'
                ]);
            });

            $this->reset(['payment']);
            $this->recordPaymentOpen = false;
            session()->flash('message', 'Payment recorded successfully.');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Error recording payment: ' . $e->getMessage());
        }
    }

    private function calculateInterestEarned($ar, $paymentAmount)
    {
        // Fixed 5% interest rate
        $interestRate = 0.05; // 5% as decimal
        $interestEarned = $paymentAmount * $interestRate;
        return round($interestEarned, 2);
    }

    public function render()
    {
        $customers = Customer::query()
            ->with(['accountReceivables.preorder.preorderItems.product', 'accountReceivables.payments'])
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);

        return view('livewire.payments.index', [
            'customers' => $customers
        ]);
    }

    public function getCalculatedRemainingBalanceProperty()
    {
        if (!$this->selectedAR) {
            return 0;
        }
        
        $amountPaid = floatval($this->payment['amount_paid'] ?? 0);
        return $this->selectedAR->remaining_balance - $amountPaid;
    }

    public function getListeners()
    {
        return [
            'refreshComponent' => '$refresh',
            'echo:payment-recorded,PaymentRecorded' => '$refresh',
            'openPaymentSubmission' => function($data) {
                if (isset($data['paymentId'])) {
                    $this->viewSubmission($data['paymentId']);
                }
            }
        ];
    }

    public function reversePayment($paymentId)
    {
        DB::transaction(function () use ($paymentId) {
            $payment = Payment::findOrFail($paymentId);
            $ar = $payment->accountReceivable;
            
            // Reverse the payment
            $payment->reverse();
            
            // Update the AR status
            $ar->updateStatus();
            
            // Find the related inventory item
            $inventoryItem = InventoryItem::where('preorder_id', $ar->preorder_id)->first();
            
            if ($inventoryItem) {
                // Update inventory item status to reflect the reversal
                $inventoryItem->update(['status' => 'available']);
            }
            
            session()->flash('message', 'Payment reversed successfully and inventory item status updated.');
        });
    }

    public function processPaymentReversion()
    {
        DB::transaction(function () {
            $payment = $this->editingPayment;
            $ar = $payment->accountReceivable;
            
            // Revert this payment and all subsequent payments
            $subsequentPayments = Payment::where('account_receivable_id', $ar->id)
                ->where('id', '>=', $payment->id)
                ->orderBy('id', 'asc')
                ->get();

            // First, revert AR balances
            $ar->total_paid -= $payment->amount_paid;
            $ar->remaining_balance += $payment->amount_paid;
            
            // Record the new payment
            $newPayment = Payment::create([
                'account_receivable_id' => $ar->id,
                'amount_paid' => $this->payment['amount_paid'],
                'payment_date' => $this->payment['payment_date'],
                'due_amount' => $this->payment['due_amount'],
                'remaining_balance' => $ar->remaining_balance - $this->payment['amount_paid']
            ]);

            // Update AR with new payment
            $ar->total_paid += $this->payment['amount_paid'];
            $ar->remaining_balance -= $this->payment['amount_paid'];
            
            // Update AR status
            if ($ar->remaining_balance <= 0) {
                $ar->status = 'paid';
            } else {
                $ar->status = 'partial';
            }
            
            $ar->save();

            // Delete the old payment and all subsequent payments
            foreach ($subsequentPayments as $subsequentPayment) {
                $subsequentPayment->delete();
            }
        });

        $this->recordPaymentOpen = false;
        $this->isEditing = false;
        $this->editingPayment = null;
        $this->reset('payment');
        session()->flash('message', 'Payment reversed and updated successfully.');
        
        $this->dispatch('payment-recorded')->to('payments.index');
    }

    public function deletePayment(Payment $payment)
    {
        DB::transaction(function () use ($payment) {
            $ar = $payment->accountReceivable;
            
            // Revert AR balances
            $ar->total_paid -= $payment->amount_paid;
            $ar->remaining_balance += $payment->amount_paid;
            $ar->status = 'partial';
            $ar->save();

            // Update subsequent payments' remaining balance
            $subsequentPayments = Payment::where('account_receivable_id', $ar->id)
                ->where('id', '>', $payment->id)
                ->get();

            foreach ($subsequentPayments as $subsequentPayment) {
                $subsequentPayment->remaining_balance += $payment->amount_paid;
                $subsequentPayment->save();
            }

            // Delete the payment
            $payment->delete();
        });

        session()->flash('message', 'Payment deleted successfully.');
        $this->dispatch('payment-recorded')->to('payments.index');
    }

    public function initiateReversal($paymentId)
    {
        $this->paymentToReverse = Payment::findOrFail($paymentId);
        $this->newPaymentAmount = $this->paymentToReverse->amount_paid;
        $this->newPaymentDate = $this->paymentToReverse->payment_date;
        
        // Store the original remaining balance before reversal
        $this->originalRemainingBalance = $this->paymentToReverse->accountReceivable->remaining_balance + $this->paymentToReverse->amount_paid;
        
        $this->reversalStage = 'confirm';
        $this->reversalModalOpen = true;
    }
    
    public function confirmReversal()
    {
        $this->reversalStage = 'edit';
    }
    
    public function cancelReversal()
    {
        $this->reversalModalOpen = false;
        $this->reset(['paymentToReverse', 'newPaymentAmount', 'newPaymentDate', 'reversalStage']);
    }
    
    public function getUpdatedRemainingBalanceProperty()
    {
        if (!$this->paymentToReverse || !is_numeric($this->newPaymentAmount)) {
            return 0;
        }
        
        // Calculate from the original remaining balance (before reversal)
        return $this->originalRemainingBalance - $this->newPaymentAmount;
    }
    
    public function processReversalWithNewPayment()
    {
        DB::transaction(function () {
            $payment = $this->paymentToReverse;
            $ar = $payment->accountReceivable;
            
            // Revert AR balances
            $ar->total_paid -= $payment->amount_paid;
            $ar->remaining_balance += $payment->amount_paid;
            
            // If this was a completed AR with a sale, find and delete the corresponding sale
            if ($ar->status === 'paid') {
                Sale::where('account_receivable_id', $ar->id)->delete();
                
                // Update preorder status
                if ($ar->preorder) {
                    $ar->preorder->update(['status' => 'converted']);                                                                      
                }
                
                // Update inventory items back to available
                InventoryItem::where('preorder_id', $ar->preorder_id)
                    ->update(['status' => 'available']);
            }
            
            // Update AR status
            $ar->status = 'partial';
            $ar->save();
            
            // Delete the payment
            $payment->delete();
            
            // Refresh the payment history
            $this->selectedCustomerPayments = Payment::where('account_receivable_id', $ar->id)
                ->orderBy('payment_date', 'desc')
                ->get();
        });
        
        session()->flash('message', 'Payment and associated records reversed successfully.');
        $this->reversalModalOpen = false;
        $this->reset(['paymentToReverse', 'newPaymentAmount', 'newPaymentDate', 'reversalStage']);
    }

    public function loadStats()
    {
        $this->totalPayments = Payment::sum('amount_paid');
        $this->pendingCount = PaymentSubmission::where('status', 'pending')->count();
        $this->todayPayments = Payment::whereDate('payment_date', today())->sum('amount_paid');
    }

    public function getPaymentsProperty()
    {
        return Payment::with(['accountReceivable.customer', 'accountReceivable.preorder.preorderItems.product'])
            ->when($this->search, function($query) {
                $query->whereHas('accountReceivable.customer', function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterStatus, function($query) {
                $query->where('status', $this->filterStatus);
            })
            ->when($this->sortBy, function($query) {
                switch($this->sortBy) {
                    case 'latest':
                        $query->latest('payment_date');
                        break;
                    case 'oldest':
                        $query->oldest('payment_date');
                        break;
                    case 'amount_high':
                        $query->orderByDesc('amount_paid');
                        break;
                    case 'amount_low':
                        $query->orderBy('amount_paid');
                        break;
                }
            })
            ->paginate($this->perPage);
    }

    public function updatedCustomerSearch()
    {
        if (strlen($this->customerSearch) >= 2) {
            $this->accountReceivables = AccountReceivable::with(['customer', 'preorder.preorderItems.product'])
                ->whereHas('customer', function($query) {
                    $query->where('name', 'like', '%' . $this->customerSearch . '%');
                })
                ->where('status', '!=', 'paid')
                ->get()
                ->map(function($ar) {
                    // Add the total with interest to each AR
                    $ar->display_amount = $ar->getTotalAmountWithInterest();
                    return $ar;
                });
        } else {
            $this->accountReceivables = [];
        }
    }

    public function updatedSelectedAR()
    {
        if ($this->selectedAR) {
            $this->selectedARDetails = AccountReceivable::with(['customer', 'preorder.preorderItems.product'])
                ->find($this->selectedAR);
            
            if ($this->selectedARDetails) {
                // Set default payment date to today
                $this->payment['payment_date'] = date('Y-m-d');
                
                // Set default amount to monthly payment
                $this->payment['amount_paid'] = $this->selectedARDetails->monthly_payment;
                
                // Update the remaining balance to include interest
                $this->payment['remaining_balance'] = $this->selectedARDetails->getRemainingBalanceWithInterest();
                
                // Ensure the selectedARDetails has the correct remaining balance
                $this->selectedARDetails->remaining_balance = $this->selectedARDetails->getRemainingBalanceWithInterest();
            }
        }
    }

    public function confirmVoid($paymentId)
    {
        $this->selectedPayment = Payment::find($paymentId);
        $this->showVoidModal = true;
    }

    public function voidPayment()
    {
        $this->validate([
            'voidReason' => 'required|min:3'
        ]);

        DB::transaction(function () {
            $payment = Payment::find($this->selectedPayment->id);
            if ($payment) {
                // Update payment status
                $payment->status = 'void';
                $payment->void_reason = $this->voidReason;
                $payment->save();

                // Update AR balances
                $ar = $payment->accountReceivable;
                $ar->total_paid -= $payment->amount_paid;
                $ar->remaining_balance += $payment->amount_paid;
                
                // If this was a completed AR, update its status
                if ($ar->status === 'completed') {
                    $ar->status = 'ongoing';
                }
                
                $ar->save();
            }
        });

        $this->showVoidModal = false;
        $this->selectedPayment = null;
        $this->voidReason = '';
        
        session()->flash('message', 'Payment has been voided successfully.');
    }

    private function refreshStats()
    {
        $this->todayPayments = Payment::whereDate('payment_date', today())
            ->where('status', 'active')
            ->sum('amount_paid');
        
        $this->totalPayments = Payment::where('status', 'active')
            ->sum('amount_paid');
            
        $this->pendingCount = PaymentSubmission::where('status', 'pending')->count();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function updatingSortBy()
    {
        $this->resetPage();
    }
}