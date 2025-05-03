<div class="bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] min-h-screen p-6">
    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-[#401B1B] mb-2">Sales Management</h1>
        <p class="text-[#72383D] text-lg">Track and manage all sales transactions</p>
    </div>

    <!-- Search and Filter Section -->
    <div class="bg-white/80 rounded-xl shadow-lg p-6 mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-[#72383D]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                </div>
                <?php if (isset($component)) { $__componentOriginalf51438a7488970badd535e5f203e0c1b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf51438a7488970badd535e5f203e0c1b = $attributes; } ?>
<?php $component = Mary\View\Components\Input::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['placeholder' => 'Search sales...','wire:model.live.debounce.300ms' => 'search','class' => 'pl-10 w-full bg-[#F2F2EB]/50 border-[#72383D]/20 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30 rounded-lg']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf51438a7488970badd535e5f203e0c1b)): ?>
<?php $attributes = $__attributesOriginalf51438a7488970badd535e5f203e0c1b; ?>
<?php unset($__attributesOriginalf51438a7488970badd535e5f203e0c1b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf51438a7488970badd535e5f203e0c1b)): ?>
<?php $component = $__componentOriginalf51438a7488970badd535e5f203e0c1b; ?>
<?php unset($__componentOriginalf51438a7488970badd535e5f203e0c1b); ?>
<?php endif; ?>
            </div>
            
            <div class="flex gap-4">
                <select wire:model.live="filterType" class="rounded-lg border-[#72383D]/20 bg-[#F2F2EB]/50 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30">
                    <option value="">All Types</option>
                    <option value="customer_payment">Customer Payment</option>
                    <option value="full_payment">Full Payment</option>
                </select>
                
                <select wire:model.live="sortField" class="rounded-lg border-[#72383D]/20 bg-[#F2F2EB]/50 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30">
                    <option value="completion_date">Date</option>
                    <option value="total_amount">Amount</option>
                </select>
                
                <select wire:model.live="sortDirection" class="rounded-lg border-[#72383D]/20 bg-[#F2F2EB]/50 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30">
                    <option value="desc">Descending</option>
                    <option value="asc">Ascending</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Sales Table -->
    <div class="bg-white/80 rounded-xl shadow-lg p-6">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gradient-to-r from-[#72383D]/10 to-[#AB644B]/10">
                        <th class="px-6 py-3 text-left text-xs font-semibold text-[#401B1B] uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-[#401B1B] uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-[#401B1B] uppercase tracking-wider">Products</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-[#401B1B] uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-[#401B1B] uppercase tracking-wider">Interest Earned</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-[#401B1B] uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-[#401B1B] uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#72383D]/10">
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $sales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="hover:bg-[#F2F2EB]/50 transition-colors duration-200">
                            <td class="px-6 py-4 text-sm text-[#401B1B]">
                                <?php echo e($sale->completion_date->format('M d, Y')); ?>

                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-[#401B1B]"><?php echo e($sale->customer->name); ?></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-[#401B1B]">
                                    <!--[if BLOCK]><![endif]--><?php if($sale->accountReceivable && $sale->accountReceivable->preorder): ?>
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $sale->accountReceivable->preorder->preorderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php echo e($item->product->product_name); ?>

                                            <!--[if BLOCK]><![endif]--><?php if(!$loop->last): ?>, <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-[#401B1B]">₱<?php echo e(number_format($sale->total_amount, 2)); ?></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-[#401B1B]">₱<?php echo e(number_format($sale->interest_earned, 2)); ?></div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full
                                    <?php echo e($sale->type === 'customer_payment' ? 'bg-[#72383D]/10 text-[#72383D]' : 'bg-[#AB644B]/10 text-[#AB644B]'); ?>">
                                    <?php echo e(str_replace('_', ' ', ucfirst($sale->type))); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full
                                    <?php echo e($sale->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'); ?>">
                                    <?php echo e(ucfirst($sale->status)); ?>

                                </span>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </tbody>
            </table>
        </div>

        <!-- Pagination Controls -->
        <div class="mt-6">
            <?php echo e($sales->links()); ?>

        </div>

        <!-- Items Per Page Selector -->
        <div class="mt-4 flex items-center justify-end space-x-2">
            <span class="text-sm text-[#72383D]">Items per page:</span>
            <select wire:model.live="perPage" class="rounded-lg border-[#72383D]/20 bg-[#F2F2EB]/50 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30">
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="30">30</option>
                <option value="40">40</option>
                <option value="50">50</option>
            </select>
        </div>
    </div>
</div><?php /**PATH C:\laragon\www\inventorymanagement\resources\views/livewire/sales/index.blade.php ENDPATH**/ ?>