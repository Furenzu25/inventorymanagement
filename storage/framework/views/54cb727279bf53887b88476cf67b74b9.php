<div class="bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] min-h-screen p-6">
    <div class="flex flex-col md:flex-row justify-between items-center mb-6">
        <?php if (isset($component)) { $__componentOriginal6f99ffca722ef3c8789c4087c5ac9f0d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6f99ffca722ef3c8789c4087c5ac9f0d = $attributes; } ?>
<?php $component = Mary\View\Components\Header::resolve(['title' => 'Account Receivables Management'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Header::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'text-[#401B1B] text-3xl font-bold']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6f99ffca722ef3c8789c4087c5ac9f0d)): ?>
<?php $attributes = $__attributesOriginal6f99ffca722ef3c8789c4087c5ac9f0d; ?>
<?php unset($__attributesOriginal6f99ffca722ef3c8789c4087c5ac9f0d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6f99ffca722ef3c8789c4087c5ac9f0d)): ?>
<?php $component = $__componentOriginal6f99ffca722ef3c8789c4087c5ac9f0d; ?>
<?php unset($__componentOriginal6f99ffca722ef3c8789c4087c5ac9f0d); ?>
<?php endif; ?>
        <div class="flex space-x-2 mt-4 md:mt-0">
            <?php if (isset($component)) { $__componentOriginalf51438a7488970badd535e5f203e0c1b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf51438a7488970badd535e5f203e0c1b = $attributes; } ?>
<?php $component = Mary\View\Components\Input::resolve(['icon' => 'o-magnifying-glass'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['placeholder' => 'Search AR...','wire:model.live' => 'search','class' => 'pl-10 w-full bg-[#F2F2EB]/50 border-[#72383D]/20 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30 rounded-md shadow-sm']); ?>
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
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <?php if (isset($component)) { $__componentOriginal8fc4ad737f3c40ff5ac76f434f4104b5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8fc4ad737f3c40ff5ac76f434f4104b5 = $attributes; } ?>
<?php $component = Mary\View\Components\Stat::resolve(['value' => ''.e(number_format($totalAR, 2)).'','icon' => 'o-currency-dollar'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stat'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Stat::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'bg-gradient-to-br from-[#401B1B] to-[#72383D] text-white shadow-lg rounded-lg']); ?>
             <?php $__env->slot('title', null, []); ?> 
                <span class="text-[#F2F2EB] font-semibold">Total AR</span>
             <?php $__env->endSlot(); ?>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8fc4ad737f3c40ff5ac76f434f4104b5)): ?>
<?php $attributes = $__attributesOriginal8fc4ad737f3c40ff5ac76f434f4104b5; ?>
<?php unset($__attributesOriginal8fc4ad737f3c40ff5ac76f434f4104b5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8fc4ad737f3c40ff5ac76f434f4104b5)): ?>
<?php $component = $__componentOriginal8fc4ad737f3c40ff5ac76f434f4104b5; ?>
<?php unset($__componentOriginal8fc4ad737f3c40ff5ac76f434f4104b5); ?>
<?php endif; ?>

        <?php if (isset($component)) { $__componentOriginal8fc4ad737f3c40ff5ac76f434f4104b5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8fc4ad737f3c40ff5ac76f434f4104b5 = $attributes; } ?>
<?php $component = Mary\View\Components\Stat::resolve(['value' => ''.e(number_format($totalOutstanding, 2)).'','icon' => 'o-exclamation-circle'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stat'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Stat::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'bg-gradient-to-br from-[#72383D] to-[#AB644B] text-white shadow-lg rounded-lg']); ?>
             <?php $__env->slot('title', null, []); ?> 
                <span class="text-[#F2F2EB] font-semibold">Total Outstanding</span>
             <?php $__env->endSlot(); ?>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8fc4ad737f3c40ff5ac76f434f4104b5)): ?>
<?php $attributes = $__attributesOriginal8fc4ad737f3c40ff5ac76f434f4104b5; ?>
<?php unset($__attributesOriginal8fc4ad737f3c40ff5ac76f434f4104b5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8fc4ad737f3c40ff5ac76f434f4104b5)): ?>
<?php $component = $__componentOriginal8fc4ad737f3c40ff5ac76f434f4104b5; ?>
<?php unset($__componentOriginal8fc4ad737f3c40ff5ac76f434f4104b5); ?>
<?php endif; ?>
    </div>

    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-[#401B1B] to-[#72383D] text-white">
                            <th class="px-4 py-3 text-left">Customer</th>
                            <th class="px-4 py-3 text-left">Product</th>
                            <th class="px-4 py-3 text-left">Monthly Payment</th>
                            <th class="px-4 py-3 text-left">Total Paid</th>
                            <th class="px-4 py-3 text-left">Remaining Balance</th>
                            <th class="px-4 py-3 text-left">Loan Duration</th>
                            <th class="px-4 py-3 text-left">Next Payment Due</th>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $accountReceivables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ar): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="border-b border-[#D2DCE6] hover:bg-[#F2F2EB] transition-colors duration-200">
                                <td class="px-4 py-3 text-[#401B1B]"><?php echo e($ar->customer->name); ?></td>
                                <td class="px-4 py-3 text-[#401B1B]"><?php echo e($ar->preorder->preorderItems->map(function($item) { return $item->product->product_name; })->implode(', ')); ?></td>
                                <td class="px-4 py-3 text-[#401B1B]">₱<?php echo e(number_format($ar->monthly_payment, 2)); ?></td>
                                <td class="px-4 py-3 text-[#401B1B]">₱<?php echo e(number_format($ar->total_paid, 2)); ?></td>
                                <td class="px-4 py-3 text-[#401B1B]">₱<?php echo e(number_format($ar->remaining_balance, 2)); ?></td>
                                <td class="px-4 py-3 text-[#401B1B]">
                                    <!--[if BLOCK]><![endif]--><?php if($ar->loan_start_date && $ar->loan_end_date): ?>
                                        <div><?php echo e($ar->loan_start_date->format('M d, Y')); ?> -</div>
                                        <div><?php echo e($ar->loan_end_date->format('M d, Y')); ?></div>
                                        <div class="text-sm text-gray-600">
                                            (<?php echo e($ar->loan_start_date->diffInMonths($ar->loan_end_date)); ?> months)
                                        </div>
                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </td>
                                <td class="px-4 py-3">
                                    <!--[if BLOCK]><![endif]--><?php if($ar->status === 'ongoing'): ?>
                                        <?php
                                            $nextDueDate = $ar->getNextPaymentDueDate();
                                        ?>
                                        <!--[if BLOCK]><![endif]--><?php if($nextDueDate): ?>
                                            <div class="text-sm">
                                                <?php echo e($nextDueDate->format('M d, Y')); ?>

                                                <!--[if BLOCK]><![endif]--><?php if($nextDueDate->isPast()): ?>
                                                    <span class="text-red-500 text-xs">(Overdue)</span>
                                                <?php else: ?>
                                                    <span class="text-gray-500 text-xs">(<?php echo e($nextDueDate->diffForHumans()); ?>)</span>
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                        <?php else: ?>
                                            N/A
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <?php else: ?>
                                        -
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 text-sm rounded-full <?php echo e($ar->status === 'paid' ? 'bg-[#72383D] text-white' : 'bg-[#AB644B] text-white'); ?>">
                                        <?php echo e(ucfirst($ar->status)); ?>

                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <!--[if BLOCK]><![endif]--><?php if($ar->status === 'ongoing'): ?>
                                        <?php if (isset($component)) { $__componentOriginal602b228a887fab12f0012a3179e5b533 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal602b228a887fab12f0012a3179e5b533 = $attributes; } ?>
<?php $component = Mary\View\Components\Button::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'reassignProduct('.e($ar->id).')','class' => 'bg-[#9CABB4] hover:bg-[#72383D] text-white text-xs py-1 px-2 rounded transition duration-300','onclick' => 'confirm(\'Are you sure you want to repossess this product?\') || event.stopImmediatePropagation()']); ?>
                                            Repossess
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
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div><?php /**PATH C:\laragon\www\inventorymanagement\resources\views/livewire/AR/index.blade.php ENDPATH**/ ?>