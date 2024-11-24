<div wire:poll.30s class="relative" x-data="{ open: @entangle('showNotifications') }">
    <button 
        class="relative p-2" 
        @click="open = !open"
    >
        <x-icon name="o-bell" class="w-6 h-6 text-[#72383D]" />
        @if($unreadCount > 0)
            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-[#AB644B] rounded-full">
                {{ $unreadCount }}
            </span>
        @endif
    </button>

    <div 
        x-show="open"
        x-transition
        @click.away="open = false"
        class="absolute right-0 mt-2 w-96 bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] rounded-lg shadow-lg overflow-hidden z-50 border border-[#72383D]/20"
    >
        <div class="sticky top-0 bg-[#F2F2EB] p-4 border-b border-[#72383D]/10 z-10">
            <h3 class="text-lg font-semibold text-[#401B1B]">Notifications</h3>
        </div>

        <div class="max-h-[400px] overflow-y-auto">
            <div class="p-4">
                @forelse($notifications as $notification)
                    <div class="mb-4 p-3 {{ is_null($notification->read_at) ? 'bg-white/50' : 'bg-white/30' }} rounded-lg border border-[#72383D]/10">
                        <h4 class="font-semibold text-[#401B1B]">
                            {{ $notification->data['title'] }}
                        </h4>
                        <p class="text-sm text-[#72383D]">
                            {{ $notification->data['message'] }}
                        </p>
                        <div class="mt-2 flex justify-between items-center">
                            <span class="text-xs text-[#72383D]/70">
                                {{ $notification->created_at->diffForHumans() }}
                            </span>
                            @if($notification->type === 'App\\Notifications\\NewPaymentSubmission')
                                <button 
                                    wire:click.stop="viewPayment('{{ $notification->data['payment_submission_id'] ?? '' }}')"
                                    class="text-xs bg-[#72383D] text-white px-3 py-1 rounded-full hover:bg-[#401B1B] transition-colors duration-200"
                                >
                                    Review Payment
                                </button>
                            @elseif($notification->type === 'App\\Notifications\\AdminPreorderNotification')
                                <button 
                                    wire:click.stop="viewPreorder('{{ $notification->data['preorder_submission_id'] }}')"
                                    class="text-xs bg-[#72383D] text-white px-3 py-1 rounded-full hover:bg-[#401B1B] transition-colors duration-200"
                                >
                                    View Preorder
                                </button>
                            @endif
                        </div>
                        @if(is_null($notification->read_at))
                            <button 
                                wire:click.stop="markAsRead('{{ $notification->id }}')"
                                class="text-xs text-[#72383D] hover:text-[#401B1B] mt-2"
                            >
                                Mark as read
                            </button>
                        @endif
                    </div>
                @empty
                    <p class="text-[#72383D]">No notifications</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
