<div>
    <!--[if BLOCK]><![endif]--><?php if($notifications->isNotEmpty()): ?>
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Notifications</h3>
            <button wire:click="markAllAsRead" class="text-sm text-[#AB644B] hover:text-[#72383D]">
                Mark all as read
            </button>
        </div>
        
        <div class="space-y-4">
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="flex items-start p-3 <?php echo e(is_null($notification->read_at) ? 'bg-[#AB644B]/10' : 'bg-transparent'); ?> rounded-lg">
                    <div class="flex-1">
                        <h4 class="font-medium"><?php echo e($notification->data['title']); ?></h4>
                        <p class="text-sm text-gray-600"><?php echo e($notification->data['message']); ?></p>
                        <!--[if BLOCK]><![endif]--><?php if(isset($notification->data['total_amount'])): ?>
                            <p class="text-sm font-semibold text-[#72383D]">
                                Total Amount: ₱<?php echo e(number_format($notification->data['total_amount'], 2)); ?>

                            </p>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <span class="text-xs text-gray-500"><?php echo e($notification->created_at->diffForHumans()); ?></span>
                    </div>
                    
                    <!--[if BLOCK]><![endif]--><?php if(is_null($notification->read_at)): ?>
                        <button wire:click="markAsRead('<?php echo e($notification->id); ?>')" class="text-sm text-[#AB644B] hover:text-[#72383D]">
                            Mark as read
                        </button>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    <?php else: ?>
        <p class="text-center text-gray-500 py-4">Nonotifications</p>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH C:\laragon\www\inventorymanagement\resources\views/livewire/ecommerce/customer-notifications.blade.php ENDPATH**/ ?>