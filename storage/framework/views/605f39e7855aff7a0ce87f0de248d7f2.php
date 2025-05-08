<div class="text-gray-200">
    <h3 class="text-lg font-semibold mb-4"><?php echo e($title); ?></h3>
    <table class="min-w-full divide-y divide-gray-700">
        <thead class="bg-gray-800">
            <tr>
                <?php if(!$sale): ?>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Sale ID</th>
                <?php endif; ?>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Date</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Amount Paid</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Due Amount</th>
            </tr>
        </thead>
        <tbody class="bg-gray-900 divide-y divide-gray-700">
            <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="hover:bg-gray-800 transition-colors duration-200">
                    <?php if(!$sale): ?>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="<?php echo e(route('payments.history', $payment->sale_id)); ?>" class="text-indigo-400 hover:text-indigo-300">
                                <?php echo e($payment->sale_id); ?>

                            </a>
                        </td>
                    <?php endif; ?>
                    <td class="px-6 py-4 whitespace-nowrap"><?php echo e($payment->payment_date->format('Y-m-d')); ?></td>
                    <td class="px-6 py-4 whitespace-nowrap"><?php echo e(number_format($payment->amount_paid, 2)); ?></td>
                    <td class="px-6 py-4 whitespace-nowrap"><?php echo e(number_format($payment->due_amount, 2)); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div><?php /**PATH C:\laragon\www\inventorymanagement\resources\views\livewire\payments\history.blade.php ENDPATH**/ ?>