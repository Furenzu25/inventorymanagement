<div class="bg-gradient-to-br from-[#F2F2EB] via-[#D2DCE6] to-[#9CABB4] min-h-screen" x-data="{ showReasonModal: false, currentReason: '' }">
    <?php echo $__env->make('livewire.ecommerce.components.nav-bar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <div class="p-8">
        <div class="max-w-7xl mx-auto">
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-[#401B1B]">Payment History</h1>
            </div>
            <!--[if BLOCK]><![endif]--><?php if(session()->has('message')): ?>
                <div class="mb-4 p-4 bg-[#72383D]/10 border-l-4 border-[#72383D] text-[#401B1B] rounded">
                    <?php echo e(session('message')); ?>

                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $accountReceivables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ar): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white/40 backdrop-blur-md rounded-lg shadow-lg p-6 border border-[#72383D]/10">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-bold text-[#401B1B]">
                                    <?php echo e($ar->preorder->preorderItems->first()->product->product_name); ?>

                                </h3>
                                <p class="text-sm text-[#72383D]">Account #<?php echo e($ar->id); ?></p>
                            </div>
                            <!--[if BLOCK]><![endif]--><?php if($ar->status !== 'paid'): ?>
                                <button 
                                    wire:click="$dispatch('open-payment-modal', [<?php echo e($ar->id); ?>])"
                                    class="text-sm px-3 py-1 bg-[#72383D] hover:bg-[#401B1B] text-white rounded-full transition-colors"
                                >
                                    Pay Now
                                </button>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-[#401B1B]">Total Amount:</span>
                                <span class="font-semibold text-[#72383D]">₱<?php echo e(number_format($ar->total_amount, 2)); ?></span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-[#401B1B]">Monthly Payment:</span>
                                <span class="font-semibold text-[#72383D]">₱<?php echo e(number_format($ar->monthly_payment, 2)); ?></span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-[#401B1B]">Remaining Balance:</span>
                                <span class="font-semibold text-[#72383D]">₱<?php echo e(number_format($ar->remaining_balance, 2)); ?></span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-[#401B1B]">Next Due Date:</span>
                                <span class="font-semibold text-[#72383D]"><?php echo e($ar->next_payment_date?->format('M d, Y') ?? 'N/A'); ?></span>
                            </div>
                            
                            <div class="mt-4">
                                <div class="w-full bg-[#D2DCE6] rounded-full h-2">
                                    <div class="bg-gradient-to-r from-[#72383D] to-[#AB644B] h-2 rounded-full"
                                         style="width: <?php echo e((($ar->total_amount - $ar->remaining_balance) / $ar->total_amount) * 100); ?>%">
                                    </div>
                                </div>
                                <p class="text-xs text-[#72383D] mt-1 text-center">
                                    <?php echo e(number_format((($ar->total_amount - $ar->remaining_balance) / $ar->total_amount) * 100, 1)); ?>% paid
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </div>
            <div class="bg-white/40 backdrop-blur-md overflow-hidden shadow-lg rounded-lg">
                <div class="px-6 py-4 border-b border-[#72383D]/10">
                    <h2 class="text-xl font-semibold text-[#401B1B]">Payment Submissions</h2>
                </div>
                
                <!--[if BLOCK]><![endif]--><?php if($paymentSubmissions->isEmpty()): ?>
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
                                <th class="px-6 py-3 text-left text-xs font-medium text-[#401B1B] uppercase">Due Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-[#401B1B] uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-[#401B1B] uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white/50 divide-y divide-[#72383D]/10">
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $paymentSubmissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                                    <td class="px-6 py-4 text-[#72383D]">
                                        ₱<?php echo e(number_format($submission->due_amount, 2)); ?>

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
                                        <!--[if BLOCK]><![endif]--><?php if($submission->status === 'rejected' && $submission->rejection_reason): ?>
                                            <button 
                                                type="button"
                                                @click="showReasonModal = true; currentReason = '<?php echo e(addslashes($submission->rejection_reason)); ?>'"
                                                class="text-red-600 hover:text-red-800 underline">
                                                View Reason
                                            </button>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </tbody>
                    </table>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>
    </div>
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
</div> <?php /**PATH C:\laragon\www\inventorymanagement\resources\views/livewire/customers/payment-history.blade.php ENDPATH**/ ?>