<div>
    <x-header title="Record Payment" />

    @if (session()->has('message'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            <p>{{ session('message') }}</p>
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-6">
            <form wire:submit.prevent="store">
                <div class="mb-6">
                    <label for="sale_id" class="block text-sm font-medium text-gray-700 mb-2">Sale</label>
                    <x-select
                        label="Sale"
                        wire:model="sale_id"
                        :options="$sales->map(function($sale) {
                            return [
                                'id' => $sale->id,
                                'name' => 'Sale #' . $sale->id . ' - ' . 
                                          $sale->customer->name . ' - ' . 
                                          $sale->preorder->preorderItems->map(function($item) {
                                              return $item->product->product_name;
                                          })->implode(', ') .
                                          ' (Remaining: ₱' . number_format($sale->remaining_balance, 2) . ')'
                            ];
                        })"
                        placeholder="Select a sale"
                        class="w-full"
                    />
                    @error('sale_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="mb-6">
                    <label for="amount_paid" class="block text-sm font-medium text-gray-700 mb-2">Amount Paid</label>
                    <x-input type="number" id="amount_paid" wire:model.lazy="amount_paid" step="0.01" class="w-full" placeholder="Enter amount paid" />
                    @error('amount_paid') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="mb-6">
                    <label for="payment_date" class="block text-sm font-medium text-gray-700 mb-2">Payment Date</label>
                    <x-input type="date" id="payment_date" wire:model="payment_date" class="w-full" />
                    @error('payment_date') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="mb-6">
                    <label for="due_amount" class="block text-sm font-medium text-gray-700 mb-2">Due Amount</label>
                    <x-input type="number" id="due_amount" wire:model="due_amount" step="0.01" class="w-full" placeholder="Enter due amount" />
                    @error('due_amount') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end">
                    <x-button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white">
                        Record Payment
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</div>
