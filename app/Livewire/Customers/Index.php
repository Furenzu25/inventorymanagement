<?php

namespace App\Livewire\Customers;

use Livewire\Component;
use App\Models\Customer;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use App\Models\Payment;

class Index extends Component
{
    use WithPagination;
    use WithFileUploads;

    #[Rule('nullable|image|max:5120')] // 5MB Max
    public $validIdImage;

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
    public $imageUploaded = false;
    public $selectedImage = null;

    public function create()
    {
        $this->resetCustomer();
        $this->customerId = null;
        $this->validIdImage = null;
        $this->modalOpen = true;
        $this->imageUploaded = false;
    }

    public function edit($id)
    {
        $this->resetValidation();
        $customer = Customer::findOrFail($id);
        $this->customer = $customer->toArray();
        $this->customerId = $id;
        $this->modalOpen = true;
        $this->imageUploaded = false;
        session()->flash('info', 'Please provide a valid reason for editing.');
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

        if ($this->customerId) {
            $customer = Customer::findOrFail($this->customerId);
            $customer->update($this->customer);
            $message = 'Customer updated successfully.';
        } else {
            $customer = Customer::create($this->customer);
            $message = 'Customer created successfully.';
        }

        if ($this->validIdImage) {
            $imagePath = $this->validIdImage->store('valid_ids', 'public');
            $customer->valid_id_image = $imagePath;
            $customer->save();
        }

        $this->modalOpen = false;
        $this->resetCustomer();
        session()->flash('message', $message);
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
        $customers = Customer::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortBy['column'], $this->sortBy['direction'])
            ->paginate(10);
        return view('livewire.customers.index', [
            'customers' => $customers,
        ])->layout('components.layouts.app', ['title' => 'Customers']);
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
        $this->reset(['customer', 'customerId', 'validIdImage', 'editReason', 'imageUploaded']);
    }

    public function updatedValidIdImage()
    {
        $this->validate([
            'validIdImage' => 'image|max:5120', // 5MB Max
        ]);

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
        $this->selectedCustomerPayments = Payment::whereHas('sale', function ($query) use ($customerId) {
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
