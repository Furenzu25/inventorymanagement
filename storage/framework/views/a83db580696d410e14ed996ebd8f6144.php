<div class="bg-white rounded-lg shadow-lg overflow-hidden">
    <div class="p-6">
        <h2 class="text-lg font-semibold mb-4">Customer Orders</h2>
        <table class="w-full">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 text-left">Order ID</th>
                    <th class="px-4 py-2 text-left">Customer</th>
                    <th class="px-4 py-2 text-left">Product</th>
                    <th class="px-4 py-2 text-left">Status</th>
                    <th class="px-4 py-2 text-left">Order Date</th>
                    <th class="px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="border-b">
                        <td class="px-4 py-2">#<?php echo e($order->id); ?></td>
                        <td class="px-4 py-2"><?php echo e($order->customer->name); ?></td>
                        <td class="px-4 py-2">
                            <?php $__currentLoopData = $order->preorderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php echo e($item->product->product_name); ?><br>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </td>
                        <td class="px-4 py-2"><?php echo e($order->status); ?></td>
                        <td class="px-4 py-2"><?php echo e($order->created_at->format('M d, Y')); ?></td>
                        <td class="px-4 py-2">
                            <button wire:click="show(<?php echo e($order->id); ?>)" 
                                    class="text-blue-600 hover:text-blue-800">
                                View Details
                            </button>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div><?php /**PATH C:\laragon\www\inventorymanagement\resources\views\livewire\admin\admin-orders.blade.php ENDPATH**/ ?>