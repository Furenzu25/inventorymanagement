<div wire:poll.30s class="relative" x-data="{ open: false, showReasonModal: false, currentReason: '' }">
    <button 
        class="relative p-2" 
        @click="open = !open"
    >
        <?php if (isset($component)) { $__componentOriginalce0070e6ae017cca68172d0230e44821 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce0070e6ae017cca68172d0230e44821 = $attributes; } ?>
<?php $component = Mary\View\Components\Icon::resolve(['name' => 'o-bell'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Icon::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-6 h-6 text-[#72383D]']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce0070e6ae017cca68172d0230e44821)): ?>
<?php $attributes = $__attributesOriginalce0070e6ae017cca68172d0230e44821; ?>
<?php unset($__attributesOriginalce0070e6ae017cca68172d0230e44821); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce0070e6ae017cca68172d0230e44821)): ?>
<?php $component = $__componentOriginalce0070e6ae017cca68172d0230e44821; ?>
<?php unset($__componentOriginalce0070e6ae017cca68172d0230e44821); ?>
<?php endif; ?>
        <!--[if BLOCK]><![endif]--><?php if($unreadCount > 0): ?>
            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-[#AB644B] rounded-full">
                <?php echo e($unreadCount); ?>

            </span>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </button>

    <div 
        x-show="open"
        x-transition
        @click.away="open = false"
        class="absolute right-0 mt-2 w-96 bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] rounded-lg shadow-lg overflow-hidden z-50 border border-[#72383D]/20"
        style="display: none;"
    >
        <div class="sticky top-0 bg-[#F2F2EB] p-4 border-b border-[#72383D]/10 z-10">
            <h3 class="text-lg font-semibold text-[#401B1B]">Notifications</h3>
        </div>

        <div class="max-h-[400px] overflow-y-auto">
            <div class="p-4">
                <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="mb-4 p-3 <?php echo e(is_null($notification->read_at) ? 'bg-white/50' : 'bg-white/30'); ?> rounded-lg border border-[#72383D]/10">
                        <h4 class="font-semibold text-[#401B1B]">
                            <?php echo e($notification->data['title'] ?? 'No Title'); ?>

                        </h4>
                        <p class="text-sm text-[#72383D]">
                            <?php echo e(strstr($notification->data['message'], '. Reason:', true) ?: $notification->data['message']); ?>

                        </p>
                        <div class="mt-2 flex justify-between items-center">
                            <span class="text-xs text-[#72383D]/70">
                                <?php echo e($notification->created_at->diffForHumans()); ?>

                            </span>
                            <!--[if BLOCK]><![endif]--><?php if($notification->type === 'App\\Notifications\\PreorderStatusNotification' && str_contains($notification->data['message'], 'Reason:')): ?>
                                <button 
                                    @click="currentReason = '<?php echo e(str_replace('Reason: ', '', strstr($notification->data['message'], 'Reason:'))); ?>'; showReasonModal = true"
                                    class="text-xs bg-[#72383D] text-white px-3 py-1 rounded-full hover:bg-[#401B1B] transition-colors duration-200"
                                >
                                    View Reason
                                </button>
                            <?php elseif($notification->type === 'App\\Notifications\\NewPaymentSubmission'): ?>
                                <button 
                                    wire:click.stop="viewPayment('<?php echo e($notification->data['payment_submission_id'] ?? ''); ?>')"
                                    class="text-xs bg-[#72383D] text-white px-3 py-1 rounded-full hover:bg-[#401B1B] transition-colors duration-200"
                                >
                                    Review Payment
                                </button>
                            <?php elseif($notification->type === 'App\\Notifications\\AdminPreorderNotification'): ?>
                                <button 
                                    wire:click.stop="viewPreorder('<?php echo e($notification->data['preorder_submission_id']); ?>')"
                                    class="text-xs bg-[#72383D] text-white px-3 py-1 rounded-full hover:bg-[#401B1B] transition-colors duration-200"
                                >
                                    View Preorder
                                </button>
                            <?php elseif($notification->type === 'App\\Notifications\\PreorderStatusNotification'): ?>
                                <button 
                                    wire:click.stop="viewPreorder('<?php echo e($notification->data['preorder_submission_id']); ?>')"
                                    class="text-xs bg-[#72383D] text-white px-3 py-1 rounded-full hover:bg-[#401B1B] transition-colors duration-200"
                                >
                                    View Order
                                </button>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <!--[if BLOCK]><![endif]--><?php if(is_null($notification->read_at)): ?>
                            <button 
                                wire:click.stop="markAsRead('<?php echo e($notification->id); ?>')"
                                class="text-xs text-[#72383D] hover:text-[#401B1B] mt-2"
                            >
                                Mark as read
                            </button>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-[#72383D]">No notifications</p>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>
    </div>

    <div x-show="showReasonModal" 
         class="fixed inset-0 z-50 overflow-y-auto backdrop-blur-sm" 
         style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-500/30" aria-hidden="true">
            </div>

            <div class="relative bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] rounded-lg max-w-lg w-full border-2 border-[#72383D]/20 shadow-xl">
                <div class="p-6">
                    <h3 class="text-2xl font-bold text-[#401B1B] mb-6">Cancellation Reason</h3>
                    
                    <div class="bg-[#AB644B]/10 p-4 rounded-lg">
                        <p class="text-[#72383D]" x-text="currentReason"></p>
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
</div>
<?php /**PATH C:\laragon\www\inventorymanagement\resources\views/livewire/admin/notification-bell.blade.php ENDPATH**/ ?>