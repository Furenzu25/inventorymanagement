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
                    <div class="flex items-start p-3 {{ !$notification->is_read ? 'bg-[#AB644B]/10' : 'bg-transparent' }} rounded-lg border border-[#72383D]/20 shadow-sm">
                        <div class="flex-1">
                            <h4 class="font-medium text-[#401B1B]">{{ $notification->title }}</h4>
                            <p class="text-sm text-gray-600">
                                {{ strstr($notification->message, '. Reason:', true) ?: $notification->message }}
                            </p>
                            
                            @if($notification->type === 'preorder_disapproval')
                                <button 
                                    wire:click="showDisapprovalReason('{{ str_replace('Reason: ', '', strstr($notification->message, 'Reason:')) }}')"
                                    class="mt-2 text-sm text-red-600 hover:text-red-800 font-medium underline"
                                >
                                    See Reason
                                </button>
                            @endif
                            
                            <span class="text-xs text-gray-500 block mt-2">{{ $notification->created_at->diffForHumans() }}</span>
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

    <!-- Portal for Modal -->
    @teleport('body')
        <div x-data="{ showReasonModal: @entangle('showReasonModal') }">
            <template x-if="showReasonModal">
                <div class="fixed inset-0" style="z-index: 9999;">
                    <!-- Backdrop with blur -->
                    <div class="fixed inset-0 bg-black/30 backdrop-blur-md transition-opacity"
                         @click="showReasonModal = false"></div>

                    <!-- Modal Content -->
                    <div class="fixed inset-0 flex items-center justify-center p-4">
                        <div class="relative bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] rounded-lg max-w-lg w-full border-2 border-[#72383D]/20 shadow-xl">
                            <div class="p-6">
                                <h3 class="text-2xl font-bold text-[#401B1B] mb-6">Disapproval Reason</h3>
                                
                                <div class="bg-red-50 p-4 rounded-lg">
                                    <p class="text-red-600">{{ $selectedReason }}</p>
                                </div>

                                <div class="flex justify-end mt-6">
                                    <button @click="showReasonModal = false" 
                                        class="bg-[#72383D] hover:bg-[#401B1B] text-white px-4 py-2 rounded-lg">
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
