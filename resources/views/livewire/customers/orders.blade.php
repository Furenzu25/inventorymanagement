<div class="bg-gray-100 min-h-screen p-6">
    @if (session()->has('message'))
        <div class="alert alert-success mb-4">
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="p-6">
            <h2 class="text-lg font-semibold mb-4">My Orders</h2>
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 text-left">Order ID</th>
                        <th class="px-4 py-2 text-left">Product</th>
                        <th class="px-4 py-2 text-left">Status</th>
                        <th class="px-4 py-2 text-left">Order Date</th>
                        <th class="px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr class="border-b">
                            <td class="px-4 py-2">#{{ $order->id }}</td>
                            <td class="px-4 py-2">
                                @foreach($order->preorderItems as $item)
                                    {{ $item->product->product_name }}<br>
                                @endforeach
                            </td>
                            <td class="px-4 py-2">
                                <span class="px-2 py-1 text-sm rounded-full 
                                    {{ $order->status === 'Pending' ? 'bg-yellow-200 text-yellow-800' : 
                                       ($order->status === 'Completed' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800') }}">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="px-4 py-2">{{ $order->created_at->format('d/m/Y') }}</td>
                            <td class="px-4 py-2">
                                <a href="{{ route('customers.orders.show', $order->id) }}" class="text-blue-500">View</a>
                                @if ($order->status === 'Pending')
                                    <x-button 
                                        wire:click="editProfile"
                                        class="bg-blue-500 hover:bg-blue-600 text-white"
                                    >
                                        Edit Profile
                                    </x-button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <livewire:customers.edit-profile-modal />
</div> 