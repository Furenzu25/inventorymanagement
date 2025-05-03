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
                    <div class="mb-4 p-3 <?php echo e(!$notification->is_read ? 'bg-white/50' : 'bg-white/30'); ?> rounded-lg border border-[#72383D]/10">
                        <h4 class="font-semibold text-[#401B1B]"><?php echo e($notification->title); ?></h4>
                        <p class="text-sm text-[#72383D]">
                            <?php echo e(strstr($notification->message, '. Reason:', true) ?: $notification->message); ?>

                        </p>
                        <div class="mt-2 flex justify-between items-center">
                            <span class="text-xs text-[#72383D]/70">
                                <?php echo e($notification->created_at->diffForHumans()); ?>

                            </span>
                            <!--[if BLOCK]><![endif]--><?php if($notification->type === 'preorder_disapproval' || $notification->type === 'order_cancelled'): ?>
                                <button 
                                    wire:click="showDisapprovalReason('<?php echo e(str_replace('Reason: ', '', strstr($notification->message, 'Reason:'))); ?>')"
                                    class="text-xs bg-[#72383D] text-white px-3 py-1 rounded-full hover:bg-[#401B1B] transition-colors duration-200"
                                >
                                    View Reason
                                </button>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <!--[if BLOCK]><![endif]--><?php if(!$notification->is_read): ?>
                            <button 
                                wire:click="markAsRead(<?php echo e($notification->id); ?>)" 
                                class="text-xs text-[#72383D] hover:text-[#401B1B] mt-2"
                            >
                                Mark as read
                            </button>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        <?php else: ?>
            <p class="text-center text-[#72383D] py-4 border border-[#72383D]/20 rounded-lg">No notifications</p>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>

    <!-- Portal for Modal -->
    <template x-teleport="<?php echo e('body'); ?>">
        <div x-data="{ showReasonModal: <?php if ((object) ('showReasonModal') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showReasonModal'->value()); ?>')<?php echo e('showReasonModal'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showReasonModal'); ?>')<?php endif; ?> }">
            <template x-if="showReasonModal">
                <div class="fixed inset-0 z-50 overflow-y-auto backdrop-blur-sm">
                    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                        <div class="fixed inset-0 transition-opacity bg-gray-500/30" aria-hidden="true">
                        </div>

                        <div class="relative bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] rounded-lg max-w-lg w-full border-2 border-[#72383D]/20 shadow-xl">
                            <div class="p-6">
                                <h3 class="text-2xl font-bold text-[#401B1B] mb-6">Cancellation Reason</h3>
                                
                                <div class="bg-[#AB644B]/10 p-4 rounded-lg">
                                    <p class="text-[#72383D]"><?php echo e($selectedReason); ?></p>
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
    </template>
</div>
<?php /**PATH C:\laragon\www\inventorymanagement\resources\views/livewire/ecommerce/customer-notifications.blade.php ENDPATH**/ ?>