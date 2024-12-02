<div>
    <!-- Regular notifications content -->
    <div x-data="{ showReasonModal: @entangle('showReasonModal') }">
        @if($notifications->isNotEmpty())
            <div class="flex justify-between items-center mb-4 border-b border-[#72383D]/20 pb-4">
                <h3 class="text-lg font-semibold text-[#401B1B]">Notifications</h3>
                <button wire:click="markAllAsRead" class="text-sm text-[#AB644B] hover:text-[#72383D]">
                    Mark all as read
                </button>
            </div>
            
            <div class="space-y-4">
                @foreach($notifications as $notification)
                    <div class="mb-4 p-3 {{ !$notification->is_read ? 'bg-white/50' : 'bg-white/30' }} rounded-lg border border-[#72383D]/10">
                        <h4 class="font-semibold text-[#401B1B]">{{ $notification->title }}</h4>
                        <p class="text-sm text-[#72383D]">
                            {{ strstr($notification->message, '. Reason:', true) ?: $notification->message }}
                        </p>
                        <div class="mt-2 flex justify-between items-center">
                            <span class="text-xs text-[#72383D]/70">
                                {{ $notification->created_at->diffForHumans() }}
                            </span>
                            @if($notification->type === 'preorder_disapproval' || $notification->type === 'order_cancelled')
                                <button 
                                    wire:click="showDisapprovalReason('{{ str_replace('Reason: ', '', strstr($notification->message, 'Reason:')) }}')"
                                    class="text-xs bg-[#72383D] text-white px-3 py-1 rounded-full hover:bg-[#401B1B] transition-colors duration-200"
                                >
                                    View Reason
                                </button>
                            @endif
                        </div>
                        @if(!$notification->is_read)
                            <button 
                                wire:click="markAsRead({{ $notification->id }})" 
                                class="text-xs text-[#72383D] hover:text-[#401B1B] mt-2"
                            >
                                Mark as read
                            </button>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-center text-[#72383D] py-4 border border-[#72383D]/20 rounded-lg">No notifications</p>
        @endif
    </div>

    <!-- Portal for Modal -->
    @teleport('body')
        <div x-data="{ showReasonModal: @entangle('showReasonModal') }">
            <template x-if="showReasonModal">
                <div class="fixed inset-0 z-50 overflow-y-auto backdrop-blur-sm">
                    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                        <div class="fixed inset-0 transition-opacity bg-gray-500/30" aria-hidden="true">
                        </div>

                        <div class="relative bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] rounded-lg max-w-lg w-full border-2 border-[#72383D]/20 shadow-xl">
                            <div class="p-6">
                                <h3 class="text-2xl font-bold text-[#401B1B] mb-6">Cancellation Reason</h3>
                                
                                <div class="bg-[#AB644B]/10 p-4 rounded-lg">
                                    <p class="text-[#72383D]">{{ $selectedReason }}</p>
                                </div>
                                
                                <div class="mt-6 flex justify-end">
                                    <button 
                                        @click="showReasonModal = false"
                                        class="px-4 py-2 bg-[#72383D] text-white rounded-lg hover:bg-[#401B1B] transition-colors duration-200"
                                    >
                                        Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    @endteleport
</div>
