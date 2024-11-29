<div>
    <!-- Regular notifications content -->
    <div x-data="{ showReasonModal: <?php if ((object) ('showReasonModal') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showReasonModal'->value()); ?>')<?php echo e('showReasonModal'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showReasonModal'); ?>')<?php endif; ?> }">
        <!--[if BLOCK]><![endif]--><?php if($notifications->isNotEmpty()): ?>
            <div class="flex justify-between items-center mb-4 border-b border-[#72383D]/20 pb-4">
                <h3 class="text-lg font-semibold text-[#401B1B]">Notifications</h3>
                <button wire:click="markAllAsRead" class="text-sm text-[#AB644B] hover:text-[#72383D]">
                    Mark all as read
                </button>
            </div>
            
            <div class="space-y-4">
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex items-start p-3 <?php echo e(!$notification->is_read ? 'bg-[#AB644B]/10' : 'bg-transparent'); ?> rounded-lg border border-[#72383D]/20 shadow-sm">
                        <div class="flex-1">
                            <h4 class="font-medium text-[#401B1B]"><?php echo e($notification->title); ?></h4>
                            <p class="text-sm text-gray-600">
                                <?php echo e(strstr($notification->message, '. Reason:', true) ?: $notification->message); ?>

                            </p>
                            
                            <!--[if BLOCK]><![endif]--><?php if($notification->type === 'preorder_disapproval'): ?>
                                <button 
                                    wire:click="showDisapprovalReason('<?php echo e(str_replace('Reason: ', '', strstr($notification->message, 'Reason:'))); ?>')"
                                    class="mt-2 text-sm text-red-600 hover:text-red-800 font-medium underline"
                                >
                                    See Reason
                                </button>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            
                            <span class="text-xs text-gray-500 block mt-2"><?php echo e($notification->created_at->diffForHumans()); ?></span>
                        </div>
                        
                        <!--[if BLOCK]><![endif]--><?php if(!$notification->is_read): ?>
                            <button wire:click="markAsRead(<?php echo e($notification->id); ?>)" class="text-sm text-[#AB644B] hover:text-[#72383D] ml-2">
                                Mark as read
                            </button>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        <?php else: ?>
            <p class="text-center text-gray-500 py-4 border border-[#72383D]/20 rounded-lg">No notifications</p>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>

    <!-- Portal for Modal -->
    <template x-teleport="<?php echo e('body'); ?>">
        <div x-data="{ showReasonModal: <?php if ((object) ('showReasonModal') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showReasonModal'->value()); ?>')<?php echo e('showReasonModal'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showReasonModal'); ?>')<?php endif; ?> }">
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
                                    <p class="text-red-600"><?php echo e($selectedReason); ?></p>
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
    </template>
</div>
<?php /**PATH C:\laragon\www\inventorymanagement\resources\views/livewire/ecommerce/customer-notifications.blade.php ENDPATH**/ ?>