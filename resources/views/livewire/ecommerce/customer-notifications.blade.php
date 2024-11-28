<div>
    @if($notifications->isNotEmpty())
        <div class="flex justify-between items-center mb-4 border-b border-[#72383D]/20 pb-4">
            <h3 class="text-lg font-semibold text-[#401B1B]">Notifications</h3>
            <button wire:click="markAllAsRead" class="text-sm text-[#AB644B] hover:text-[#72383D]">
                Mark all as read
            </button>
        </div>
        
        <div class="space-y-4">
            @foreach($notifications as $notification)
                <div class="flex items-start p-3 {{ !$notification->is_read ? 'bg-[#AB644B]/10' : 'bg-transparent' }} rounded-lg border border-[#72383D]/20 shadow-sm">
                    <div class="flex-1">
                        <h4 class="font-medium text-[#401B1B]">{{ $notification->title }}</h4>
                        <p class="text-sm text-gray-600">{{ $notification->message }}</p>
                        <span class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>
                    </div>
                    
                    @if(!$notification->is_read)
                        <button wire:click="markAsRead({{ $notification->id }})" class="text-sm text-[#AB644B] hover:text-[#72383D] ml-2">
                            Mark as read
                        </button>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <p class="text-center text-gray-500 py-4 border border-[#72383D]/20 rounded-lg">No notifications</p>
    @endif
</div>
