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
        'created_at' => '',
    ];

    public $editReason = '';
    public $selectedImage = null;

    public function create()
    {
        $this->resetCustomer();
        $this->customerId = null;
        $this->validIdImage = null;
        $this->modalOpen = true;
        $this->imageUploaded = false;
    }

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
        $customer = Customer::findOrFail($id);
        $customer->delete();
        session()->flash('message', 'Customer deleted successfully.');
    }

    public function store()
    {
        $this->validate();

        try {
            DB::transaction(function () {
                if ($this->customerId) {
                    $customer = Customer::findOrFail($this->customerId);
                    
                    // Handle image update
                    if ($this->validIdImage) {
                        // Delete old image if it exists
                        if ($this->oldImage) {
                            Storage::disk('public')->delete($this->oldImage);
                        }
                        $imagePath = $this->validIdImage->store('customers', 'public');
                        $this->customer['valid_id_image'] = $imagePath;
                    }
                    
                    $customer->update($this->customer);
                } else {
                    // Handle new image upload
                    if ($this->validIdImage) {
                        $imagePath = $this->validIdImage->store('customers', 'public');
                        $this->customer['valid_id_image'] = $imagePath;
                    }
                    
                    Customer::create($this->customer);
                }
            });

            session()->flash('message', $this->customerId ? 'Customer updated successfully.' : 'Customer created successfully.');
            $this->modalOpen = false;
            $this->resetCustomer();
        } catch (\Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
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
            'customer.email' => 'required|email|max:255',
            'customer.valid_id' => 'required|string|max:255',
            'validIdImage' => 'nullable|image|max:5120', // 5MB Max
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
