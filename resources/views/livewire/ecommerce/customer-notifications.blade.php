<div>
    @if($notifications->isNotEmpty())
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Notifications</h3>
            <button wire:click="markAllAsRead" class="text-sm text-[#AB644B] hover:text-[#72383D]">
                Mark all as read
            </button>
        </div>
        
        <div class="space-y-4">
            @foreach($notifications as $notification)
                @if($notification->type === 'App\\Notifications\\FirstMonthlyPaymentDue')
                    <div class="flex items-start p-3 {{ is_null($notification->read_at) ? 'bg-[#AB644B]/10' : 'bg-transparent' }} rounded-lg">
                        <div class="flex-1">
                            <h4 class="font-medium">{{ $notification->data['title'] }}</h4>
                            <p class="text-sm text-gray-600">{{ $notification->data['message'] }}</p>
                            <div class="mt-2">
                                <span class="text-sm font-semibold text-[#72383D]">
                                    Amount Due: ₱{{ number_format($notification->data['amount'], 2) }}
                                </span>
                                <br>
                                <span class="text-xs text-gray-500">
                                    Due Date: {{ \Carbon\Carbon::parse($notification->data['due_date'])->format('M d, Y') }}
                                </span>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="flex items-start p-3 {{ is_null($notification->read_at) ? 'bg-[#AB644B]/10' : 'bg-transparent' }} rounded-lg">
                        <div class="flex-1">
                            <h4 class="font-medium">{{ $notification->data['title'] }}</h4>
                            <p class="text-sm text-gray-600">{{ $notification->data['message'] }}</p>
                            @if(isset($notification->data['total_amount']))
                                <p class="text-sm font-semibold text-[#72383D]">
                                    Total Amount: ₱{{ number_format($notification->data['total_amount'], 2) }}
                                </p>
                            @endif
                            <span class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>
                        </div>
                        
                        @if(is_null($notification->read_at))
                            <button wire:click="markAsRead('{{ $notification->id }}')" class="text-sm text-[#AB644B] hover:text-[#72383D]">
                                Mark as read
                            </button>
                        @endif
                    </div>
                @endif
            @endforeach
        </div>
    @else
        <p class="text-center text-gray-500 py-4">No notifications</p>
    @endif
</div>
