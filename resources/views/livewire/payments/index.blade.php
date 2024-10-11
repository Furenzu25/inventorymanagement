<div>
    <h3 class="text-lg font-semibold mb-4">Record Payment</h3>
    @if (session()->has('message'))
        <div class="alert alert-success mb-4">
            {{ session('message') }}
        </div>
    @endif
    <form wire:submit.prevent="store">
        <div class="mb-4">
            <label for="preorder_id" class="block text-sm font-medium text-gray-700">Preorder</label>
            <x-select
                label="Preorder"
                wire:model="preorder_id"
                :options="$preorders->map(function($preorder) {
                    return [
                        'id' => $preorder->id,
                        'name' => 'Preorder #' . $preorder->id . ' - ' . 
                                  $preorder->customer->name . ' - ' . 
                                  $preorder->preorderItems->map(function($item) {
                                      return $item->product->product_name;
                                  })->implode(', ')
                    ];
                })"
                placeholder="Select a preorder"
            />
            @error('preorder_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="customer_id" class="block text-sm font-medium text-gray-700">Customer</label>
            <select id="customer_id" wire:model="customer_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <option value="">Select a customer</option>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                @endforeach
            </select>
            @error('customer_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="sale_id" class="block text-sm font-medium text-gray-700">Sale</label>
            <select id="sale_id" wire:model="sale_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <option value="">Select a sale</option>
                @foreach($sales as $sale)
                    <option value="{{ $sale->id }}">Sale #{{ $sale->id }}</option>
                @endforeach
            </select>
            @error('sale_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="amount_paid" class="block text-sm font-medium text-gray-700">Amount Paid</label>
            <input type="number" id="amount_paid" wire:model="amount_paid" step="0.01" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            @error('amount_paid') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="payment_date" class="block text-sm font-medium text-gray-700">Payment Date</label>
            <input type="date" id="payment_date" wire:model="payment_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            @error('payment_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="due_amount" class="block text-sm font-medium text-gray-700">Due Amount</label>
            <input type="number" id="due_amount" wire:model="due_amount" step="0.01" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            @error('due_amount') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
            Record Payment
        </button>
    </form>
</div>
