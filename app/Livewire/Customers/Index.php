<?php

namespace App\Livewire\Customers;

use Livewire\Component;
use App\Models\Customer;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use App\Models\Sale;

class Index extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $validIdImage;
    public $oldImage;
    public $existingImage;
    public $imageUploaded = false;

    public $search = '';
    public $drawer = false;
    public $sortBy = ['column' => 'name', 'direction' => 'asc'];
    public $modalOpen = false;
    public $customerId;
    public $customerDetailsOpen = false;
    public $selectedCustomer = null;
    public $paymentHistoryOpen = false;
    public $selectedCustomerPayments = [];

    public $customer = [
        'name' => '',
        'birthday' => '',
        'address' => '',
        'phone_number' => '',
        'reference_contactperson' => '',
        'reference_contactperson_phonenumber' => '',
        'email' => '',
        'valid_id' => '',
        'valid_id_image' => '',
    ];

    public $editReason = '';
    public $selectedImage = null;

    public $deleteModalOpen = false;
    public $customerToDelete = null;

    public function edit($customerId)
    {
        $customer = Customer::findOrFail($customerId);
        $this->customerId = $customerId;
        $this->customer = $customer->toArray();
        $this->existingImage = $customer->valid_id_image;
        $this->oldImage = $customer->valid_id_image;
        $this->modalOpen = true;
    }

    public function delete($id)
    {
        $this->customerToDelete = $id;
        $this->deleteModalOpen = true;
    }

    public function confirmDelete()
    {
        try {
            $customer = Customer::findOrFail($this->customerToDelete);
            
            DB::beginTransaction();
            
            // Delete all related inventory items first
            foreach ($customer->preorders as $preorder) {
                // Delete inventory items
                $preorder->inventoryItems()->delete();
                
                // Delete preorder items
                $preorder->preorderItems()->delete();
                
                // Delete related sales
                if ($preorder->accountReceivable) {
                    $preorder->accountReceivable->sales()->delete();
                }
            }
            
            // Delete all related payments and account receivables
            foreach ($customer->accountReceivables as $ar) {
                // Delete payments
                $ar->payments()->delete();
                
                // Delete the account receivable
                $ar->delete();
            }
            
            // Delete all preorders
            $customer->preorders()->delete();
            
            // Delete customer images
            if ($customer->valid_id_image) {
                Storage::disk('public')->delete($customer->valid_id_image);
            }
            if ($customer->profile_image) {
                Storage::disk('public')->delete($customer->profile_image);
            }
            
            // Finally delete the customer
            $customer->delete();
            
            DB::commit();
            
            session()->flash('message', 'Customer and all related records deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'An error occurred while deleting the customer: ' . $e->getMessage());
        }

        $this->deleteModalOpen = false;
        $this->customerToDelete = null;
    }

    public function cancelDelete()
    {
        $this->deleteModalOpen = false;
        $this->customerToDelete = null;
    }

    public function showCustomerDetails($customerId)
    {
        $this->selectedCustomer = Customer::findOrFail($customerId)->toArray();
        $this->customerDetailsOpen = true;
    }

    public function closeCustomerDetails()
    {
        $this->customerDetailsOpen = false;
        $this->selectedCustomer = null;
    }

    public function render()
    {
        return view('livewire.customers.index', [
            'customers' => Customer::query()
                ->when($this->search, function($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('phone_number', 'like', '%' . $this->search . '%');
                })
                ->paginate(10)
        ]);
    }

    public function closeModal()
    {
        $this->modalOpen = false;
        $this->resetCustomer();
    }

    protected function rules()
    {
        return [
            'customer.name' => 'required|string|max:255',
            'customer.birthday' => 'required|date',
            'customer.address' => 'required|string',
            'customer.phone_number' => 'required|string|max:20',
            'customer.reference_contactperson' => 'required|string|max:255',
            'customer.reference_contactperson_phonenumber' => 'required|string|max:20',
            'customer.email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('customers', 'email')->ignore($this->customerId)
            ],
            'customer.valid_id' => 'required|string|max:255',
            'validIdImage' => 'nullable|image|max:5120', // Only for updates
        ];
    }

    private function resetCustomer()
    {
        $this->customer = [
            'name' => '',
            'birthday' => '',
            'address' => '',
            'phone_number' => '',
            'reference_contactperson' => '',
            'reference_contactperson_phonenumber' => '',
            'email' => '',
            'valid_id' => '',
            'valid_id_image' => '',
        ];
        $this->validIdImage = null;
        $this->oldImage = null;
        $this->existingImage = null;
        $this->imageUploaded = false;
        $this->customerId = null;
    }

    public function updatedValidIdImage()
    {
        $this->imageUploaded = true;
    }

    public function removeImage()
    {
        $this->validIdImage = null;
        $this->customer['valid_id_image'] = null;
        $this->imageUploaded = false;
    }

    public function showExpandedImage($imagePath)
    {
        $this->selectedImage = Storage::disk('public')->url($imagePath);
    }

    public function closeExpandedImage()
    {
        $this->selectedImage = null;
    }

    public function viewPayment($customerId)
    {
        $customer = Customer::findOrFail($customerId);
        $this->selectedCustomerPayments = Payment::whereHas('accountReceivable', function ($query) use ($customerId) {
            $query->where('customer_id', $customerId);
        })->latest()->get()->map(function ($payment) {
            return [
                'payment_date' => $payment->payment_date,
                'amount_paid' => $payment->amount_paid,
                'due_amount' => $payment->due_amount,
            ];
        })->toArray();
        $this->paymentHistoryOpen = true;
    }

    public function closePaymentHistory()
    {
        $this->paymentHistoryOpen = false;
        $this->selectedCustomerPayments = [];
    }
}
