<div>
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
                        <p class="text-sm text-gray-600"><?php echo e($notification->message); ?></p>
                        <span class="text-xs text-gray-500"><?php echo e($notification->created_at->diffForHumans()); ?></span>
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
<?php /**PATH C:\laragon\www\inventorymanagement\resources\views/livewire/ecommerce/customer-notifications.blade.php ENDPATH**/ ?>