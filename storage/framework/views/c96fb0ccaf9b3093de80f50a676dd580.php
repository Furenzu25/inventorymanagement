<div class="bg-gradient-to-br from-[#F2F2EB] via-[#D2DCE6] to-[#9CABB4] min-h-screen" x-data="{ showReasonModal: false, currentReason: '' }">
    <?php echo $__env->make('livewire.ecommerce.components.nav-bar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <div class="p-8">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-[#401B1B]">Payment History</h1>
                <?php if (isset($component)) { $__componentOriginal602b228a887fab12f0012a3179e5b533 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal602b228a887fab12f0012a3179e5b533 = $attributes; } ?>
<?php $component = Mary\View\Components\Button::resolve(['label' => 'Submit New Payment'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => '$dispatch(\'openPaymentModal\')','class' => 'bg-gradient-to-r from-[#72383D] to-[#AB644B] text-white']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal602b228a887fab12f0012a3179e5b533)): ?>
<?php $attributes = $__attributesOriginal602b228a887fab12f0012a3179e5b533; ?>
<?php unset($__attributesOriginal602b228a887fab12f0012a3179e5b533); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal602b228a887fab12f0012a3179e5b533)): ?>
<?php $component = $__componentOriginal602b228a887fab12f0012a3179e5b533; ?>
<?php unset($__componentOriginal602b228a887fab12f0012a3179e5b533); ?>
<?php endif; ?>
            </div>

            <?php if(session()->has('message')): ?>
                <div class="mb-4 p-4 bg-[#72383D]/10 border-l-4 border-[#72383D] text-[#401B1B] rounded">
                    <?php echo e(session('message')); ?>

                </div>
            <?php endif; ?>

            <div class="bg-white/40 backdrop-blur-md overflow-hidden shadow-lg rounded-lg">
                <?php if($paymentSubmissions->isEmpty()): ?>
                    <div class="p-8 text-center text-[#72383D]">
                        <p>No payment submissions found.</p>
                    </div>
                <?php else: ?>
                    <table class="min-w-full divide-y divide-[#72383D]/10">
                        <thead class="bg-[#F2F2EB]/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-[#401B1B] uppercase">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-[#401B1B] uppercase">Product</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-[#401B1B] uppercase">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-[#401B1B] uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-[#401B1B] uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white/50 divide-y divide-[#72383D]/10">
                            <?php $__currentLoopData = $paymentSubmissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="hover:bg-[#F2F2EB]/50">
                                    <td class="px-6 py-4 whitespace-nowrap text-[#401B1B]">
                                        <?php echo e($submission->payment_date->format('M d, Y')); ?>

                                    </td>
                                    <td class="px-6 py-4 text-[#401B1B]">
                                        <?php echo e($submission->accountReceivable->preorder->preorderItems->first()->product->product_name); ?>

                                    </td>
                                    <td class="px-6 py-4 text-[#72383D] font-medium">
                                        ₱<?php echo e(number_format($submission->amount, 2)); ?>

                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 rounded-full text-xs font-medium
                                            <?php echo e($submission->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : ''); ?>

                                            <?php echo e($submission->status === 'approved' ? 'bg-green-100 text-green-800' : ''); ?>

                                            <?php echo e($submission->status === 'rejected' ? 'bg-red-100 text-red-800' : ''); ?>">
                                            <?php echo e(ucfirst($submission->status)); ?>

                                        </span>
                                    </td>
                                    <td class="px-6 py-4 flex space-x-4">
                                        <a href="<?php echo e(Storage::url($submission->payment_proof)); ?>" 
                                           target="_blank"
                                           class="text-[#72383D] hover:text-[#401B1B] underline">
                                            View Proof
                                        </a>

                                        <?php if($submission->status === 'rejected' && $submission->rejection_reason): ?>
                                            <button 
                                                type="button"
                                                @click="showReasonModal = true; currentReason = '<?php echo e(addslashes($submission->rejection_reason)); ?>'"
                                                class="text-red-600 hover:text-red-800 underline">
                                                View Reason
                                            </button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('customers.submit-payment', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-1634489894-1', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>

    <?php $__env->startPush('scripts'); ?>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <?php $__env->stopPush(); ?>

    <div x-show="showReasonModal"
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         @click.away="showReasonModal = false">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 backdrop-blur-sm bg-black/50 transition-opacity"></div>
            
            <div class="relative bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] rounded-lg max-w-lg w-full border-2 border-[#72383D]/20 shadow-xl">
                <div class="p-6">
                    <h3 class="text-2xl font-bold text-[#401B1B] mb-6">Rejection Reason</h3>
                    
                    <div class="bg-white/50 p-4 rounded-lg">
                        <p class="text-[#72383D]" x-text="currentReason"></p>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <?php if (isset($component)) { $__componentOriginal602b228a887fab12f0012a3179e5b533 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal602b228a887fab12f0012a3179e5b533 = $attributes; } ?>
<?php $component = Mary\View\Components\Button::resolve(['label' => 'Close'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['@click' => 'showReasonModal = false','class' => 'bg-[#72383D] hover:bg-[#401B1B] text-white']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal602b228a887fab12f0012a3179e5b533)): ?>
<?php $attributes = $__attributesOriginal602b228a887fab12f0012a3179e5b533; ?>
<?php unset($__attributesOriginal602b228a887fab12f0012a3179e5b533); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal602b228a887fab12f0012a3179e5b533)): ?>
<?php $component = $__componentOriginal602b228a887fab12f0012a3179e5b533; ?>
<?php unset($__componentOriginal602b228a887fab12f0012a3179e5b533); ?>
<?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><?php /**PATH C:\laragon\www\inventorymanagement\resources\views\livewire\customers\payment-history.blade.php ENDPATH**/ ?>