<div class="bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] min-h-screen p-6">
    <?php if (isset($component)) { $__componentOriginal6f99ffca722ef3c8789c4087c5ac9f0d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6f99ffca722ef3c8789c4087c5ac9f0d = $attributes; } ?>
<?php $component = Mary\View\Components\Header::resolve(['title' => 'Inventory Management'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Header::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'text-[#401B1B] text-3xl font-bold mb-6']); ?>
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

    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="p-6">
            <!-- Pending Orders Section -->
            <h2 class="text-xl font-semibold mb-4 text-[#401B1B]">Orders to Process</h2>
            <div class="overflow-x-auto">
                <table class="w-full mb-8">
                    <thead>
                        <tr class="bg-gradient-to-r from-[#401B1B] to-[#72383D] text-white">
                            <th class="px-4 py-3 text-left">Order ID</th>
                            <th class="px-4 py-3 text-left">Customer</th>
                            <th class="px-4 py-3 text-left">Product</th>
                            <th class="px-4 py-3 text-left">Serial Number</th>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3 text-left">Pickup Details</th>
                            <th class="px-4 py-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $pendingPreorders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $preorder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="border-b border-[#D2DCE6] hover:bg-[#F2F2EB] transition-colors duration-200">
                                <td class="px-4 py-3 text-[#401B1B]">#<?php echo e($preorder->id); ?></td>
                                <td class="px-4 py-3 text-[#401B1B]"><?php echo e($preorder->customer->name); ?></td>
                                <td class="px-4 py-3 text-[#401B1B]">
                                    <?php $__currentLoopData = $preorder->preorderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="mb-1">
                                            <?php echo e($item->product->product_name); ?> (<?php echo e($item->quantity); ?>)
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </td>
                                <td class="px-4 py-3 text-[#401B1B]">
                                    <?php $__currentLoopData = $preorder->inventoryItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="mb-1">
                                            <?php echo e($item->serial_number); ?>

                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </td>
                                <td class="px-4 py-3 text-[#401B1B]"><?php echo e($preorder->status); ?></td>
                                <td class="px-4 py-3">
                                    <?php if($preorder->inventoryItems->isNotEmpty()): ?>
                                        <?php if (isset($component)) { $__componentOriginal602b228a887fab12f0012a3179e5b533 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal602b228a887fab12f0012a3179e5b533 = $attributes; } ?>
<?php $component = Mary\View\Components\Button::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'showPickupDetails('.e($preorder->id).')','class' => 'bg-[#AB644B] hover:bg-[#72383D] text-white text-xs py-1 px-2 rounded transition duration-300 shadow-sm']); ?>
                                            View Details
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
                                    <?php else: ?>
                                        <span class="text-gray-500">No pickup details</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-4 py-2">
                                    <?php if($preorder->status === 'approved'): ?>
                                        <?php if (isset($component)) { $__componentOriginal602b228a887fab12f0012a3179e5b533 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal602b228a887fab12f0012a3179e5b533 = $attributes; } ?>
<?php $component = Mary\View\Components\Button::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'openStockInModal('.e($preorder->id).')','class' => 'bg-[#72383D] hover:bg-[#401B1B] text-white transition duration-300']); ?>
                                            Stock In
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
                                        <?php if (isset($component)) { $__componentOriginal602b228a887fab12f0012a3179e5b533 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal602b228a887fab12f0012a3179e5b533 = $attributes; } ?>
<?php $component = Mary\View\Components\Button::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'openCancellationModal('.e($preorder->id).')','class' => 'bg-gradient-to-r from-[#72383D] to-[#9CABB4] hover:from-[#9CABB4] hover:to-[#72383D] text-white text-xs px-2 py-1 ml-2']); ?>
                                            Cancel Order
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
                                    <?php elseif($preorder->status === 'in_stock' || $preorder->status === 'picked_up'): ?>
                                        <div class="space-y-2">
                                            <?php $__currentLoopData = $preorder->inventoryItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="flex items-center justify-between bg-white/50 p-2 rounded-lg">
                                                    <div class="text-sm text-[#401B1B] mr-2">
                                                        <span class="font-semibold"><?php echo e($item->product->product_name); ?></span>
                                                        <br>
                                                        <span class="text-xs text-[#72383D]">SN: <?php echo e($item->serial_number); ?></span>
                                                    </div>
                                                    <?php if(!$item->picked_up_at): ?>
                                                        <?php if (isset($component)) { $__componentOriginal602b228a887fab12f0012a3179e5b533 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal602b228a887fab12f0012a3179e5b533 = $attributes; } ?>
<?php $component = Mary\View\Components\Button::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'openPickupModal('.e($item->id).')','class' => 'bg-[#72383D] hover:bg-[#401B1B] text-white text-xs transition duration-300']); ?>
                                                            Record Pickup
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
                                                    <?php else: ?>
                                                        <span class="text-xs text-green-600 bg-green-100 px-2 py-1 rounded-full">
                                                            Picked Up
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>

                                        <?php if($preorder->inventoryItems->where('picked_up_at', '!=', null)->count() > 0): ?>
                                            <div class="mt-3 pt-3 border-t border-[#72383D]/10">
                                                <?php if (isset($component)) { $__componentOriginal602b228a887fab12f0012a3179e5b533 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal602b228a887fab12f0012a3179e5b533 = $attributes; } ?>
<?php $component = Mary\View\Components\Button::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'processLoan('.e($preorder->id).')','class' => 'bg-[#AB644B] hover:bg-[#72383D] text-white w-full transition duration-300']); ?>
                                                    Process Loan
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
                                        <?php endif; ?>

                                        <!-- Cancel button for in_stock and picked_up stages -->
                                        <div class="mt-2">
                                            <?php if (isset($component)) { $__componentOriginal602b228a887fab12f0012a3179e5b533 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal602b228a887fab12f0012a3179e5b533 = $attributes; } ?>
<?php $component = Mary\View\Components\Button::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'openCancellationModal('.e($preorder->id).')','class' => 'bg-gradient-to-r from-[#72383D] to-[#9CABB4] hover:from-[#9CABB4] hover:to-[#72383D] text-white text-xs px-2 py-1 w-full']); ?>
                                                Cancel Order
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
                                    <?php elseif($preorder->status === 'loaned'): ?>
                                        <span class="px-3 py-1 text-sm rounded-full bg-green-100 text-green-800">
                                            Loan Active
                                        </span>
                                    <?php elseif($preorder->status === 'arrived'): ?>
                                        <span class="px-3 py-1 text-sm rounded-full bg-yellow-100 text-yellow-800">
                                            Ready for Pickup
                                        </span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            <!-- Repossessed Items Section -->
            <h2 class="text-xl font-semibold mb-4 mt-8 text-[#401B1B]">Repossessed Items</h2>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-[#72383D] to-[#AB644B] text-white">
                            <th class="px-4 py-3 text-left">Order ID</th>
                            <th class="px-4 py-3 text-left">Previous Customer</th>
                            <th class="px-4 py-3 text-left">Product</th>
                            <th class="px-4 py-3 text-left">Serial Number</th>
                            <th class="px-4 py-3 text-left">Repossession Date</th>
                            <th class="px-4 py-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $repossessedItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="border-b border-[#D2DCE6] hover:bg-[#F2F2EB] transition-colors duration-200">
                                <td class="px-4 py-3 text-[#401B1B]">#<?php echo e($item->preorder->id); ?></td>
                                <td class="px-4 py-3 text-[#401B1B]"><?php echo e($item->preorder->customer->name); ?></td>
                                <td class="px-4 py-3 text-[#401B1B]">
                                    <?php $__currentLoopData = $item->preorder->preorderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $preorderItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="mb-1">
                                            <?php echo e($preorderItem->product->product_name); ?> (<?php echo e($preorderItem->quantity); ?>)
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </td>
                                <td class="px-4 py-3 text-[#401B1B]">
                                    <?php $__currentLoopData = $item->preorder->inventoryItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inventoryItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="mb-1">
                                            <?php echo e($inventoryItem->serial_number); ?>

                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </td>
                                <td class="px-4 py-3 text-[#401B1B]"><?php echo e($item->repossession_date); ?></td>
                                <td class="px-4 py-3">
                                    <div class="flex justify-start space-x-2">
                                        <button 
                                            wire:click="viewRepossessedDetails(<?php echo e($item->id); ?>)"
                                            class="px-4 py-2 bg-[#72383D] hover:bg-[#401B1B] text-white text-sm rounded-lg transition duration-300 min-w-[100px]"
                                        >
                                            View Details
                                        </button>
                                        <button 
                                            wire:click="openAssignModal(<?php echo e($item->id); ?>)"
                                            type="button"
                                            class="px-4 py-2 bg-gradient-to-r from-[#72383D] to-[#AB644B] hover:from-[#401B1B] hover:to-[#72383D] text-white text-sm rounded-lg transition duration-300 min-w-[100px]"
                                        >
                                            Assign to New Customer
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            <!-- Available for Reassignment Section -->
            <h2 class="text-xl font-semibold mb-4 mt-8 text-[#401B1B]">Available for Reassignment</h2>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-[#AB644B] to-[#9CABB4] text-white">
                            <th class="px-4 py-3 text-left">Product</th>
                            <th class="px-4 py-3 text-left">Serial Number</th>
                            <th class="px-4 py-3 text-left">Price</th>
                            <th class="px-4 py-3 text-left">Cancellation Date</th>
                            <th class="px-4 py-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $reassignableItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="border-b border-[#D2DCE6] hover:bg-[#F2F2EB] transition-colors duration-200">
                                <td class="px-4 py-3 text-[#401B1B]"><?php echo e($item->product->product_name); ?></td>
                                <td class="px-4 py-3 text-[#401B1B]"><?php echo e($item->serial_number); ?></td>
                                <td class="px-4 py-3 text-[#401B1B]">₱<?php echo e(number_format($item->product->price, 2)); ?></td>
                                <td class="px-4 py-3 text-[#401B1B]">
                                    <?php if($item->cancellation_date): ?>
                                        <?php echo e(\Carbon\Carbon::parse($item->cancellation_date)->format('M d, Y')); ?>

                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?>
                                </td>
                                <td class="px-4 py-3 space-x-2">
                                    <button wire:click="viewItemDetails(<?php echo e($item->id); ?>)"
                                            class="px-3 py-1 bg-[#72383D] hover:bg-[#401B1B] text-white rounded-lg transition duration-300">
                                        View Details
                                    </button>
                                    <button 
                                        wire:click="openAssignModal(<?php echo e($item->id); ?>)"
                                        type="button"
                                        class="px-4 py-2 bg-gradient-to-r from-[#72383D] to-[#AB644B] hover:from-[#401B1B] hover:to-[#72383D] text-white text-sm rounded-lg transition duration-300 min-w-[100px]"
                                    >
                                        Assign to New Customer
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            <!-- Stocked Out Items Section -->
            <h2 class="text-xl font-semibold mb-4 mt-8 text-[#401B1B]">Stocked Out Items</h2>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-[#72383D] to-[#AB644B] text-white">
                            <th class="px-4 py-3 text-left">Order ID</th>
                            <th class="px-4 py-3 text-left">Customer</th>
                            <th class="px-4 py-3 text-left">Product</th>
                            <th class="px-4 py-3 text-left">Serial Number</th>
                            <th class="px-4 py-3 text-left">Stocked Out Date</th>
                            <th class="px-4 py-3 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $stockedOutItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="border-b border-[#D2DCE6] hover:bg-[#F2F2EB] transition-colors duration-200">
                                <td class="px-4 py-3 text-[#401B1B]">#<?php echo e($item->preorder->id); ?></td>
                                <td class="px-4 py-3 text-[#401B1B]"><?php echo e($item->preorder->customer->name); ?></td>
                                <td class="px-4 py-3 text-[#401B1B]"><?php echo e($item->product->product_name); ?></td>
                                <td class="px-4 py-3 text-[#401B1B]"><?php echo e($item->serial_number); ?></td>
                                <td class="px-4 py-3 text-[#401B1B]"><?php echo e($item->updated_at->format('M d, Y')); ?></td>
                                <td class="px-4 py-3">
                                    <span class="px-3 py-1 text-sm rounded-full bg-gray-100 text-gray-800">
                                        Stocked Out
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Stock-in Details Modal -->
    <div wire:model="showPickupModal" class="fixed inset-0 z-50 overflow-y-auto" <?php if(!$showPickupModal): ?> style="display: none" <?php endif; ?>>
        <div class="flex items-center justify-center min-h-screen px-4">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-black/30 backdrop-blur-sm" wire:click="$set('showPickupModal', false)"></div>
            
            <!-- Modal Content -->
            <div class="relative z-[51] bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] rounded-lg max-w-lg w-full border-2 border-[#72383D]/20 shadow-xl">
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-[#401B1B] mb-6">Stock-in Details</h2>
                    
                    <div class="space-y-4">
                        <?php if($errors->any()): ?>
                            <div class="bg-[#AB644B]/10 text-[#AB644B] p-4 rounded-lg mb-4">
                                <ul class="list-disc list-inside">
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <!-- Bought Location -->
                        <div>
                            <label class="block text-[#401B1B] font-semibold mb-2">Bought Location</label>
                            <input
                                type="text"
                                wire:model.defer="boughtLocation"
                                class="w-full rounded-lg border-[#72383D]/20 bg-white/50 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30"
                                placeholder="Enter where the item was bought..."
                            />
                            <?php $__errorArgs = ['boughtLocation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-red-500 text-sm"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Bought Date -->
                        <div>
                            <label class="block text-[#401B1B] font-semibold mb-2">Bought Date</label>
                            <input
                                type="datetime-local"
                                wire:model.defer="boughtDate"
                                class="w-full rounded-lg border-[#72383D]/20 bg-white/50 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30"
                            />
                            <?php $__errorArgs = ['boughtDate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-red-500 text-sm"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Pickup Notes -->
                        <div>
                            <label class="block text-[#401B1B] font-semibold mb-2">Pickup Notes</label>
                            <textarea
                                wire:model.defer="pickupNotes"
                                rows="3"
                                class="w-full rounded-lg border-[#72383D]/20 bg-white/50 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30"
                                placeholder="Enter any additional notes about the pickup..."
                            ></textarea>
                        </div>

                        <div class="flex justify-end gap-3 mt-6">
                            <button 
                                wire:click="$set('showPickupModal', false)" 
                                class="px-4 py-2 bg-[#9CABB4] hover:bg-[#72383D] text-white rounded-lg transition duration-300"
                            >
                                Cancel
                            </button>
                            <button 
                                wire:click="stockIn(<?php echo e($selectedPreorder?->id); ?>)"
                                class="px-4 py-2 bg-gradient-to-r from-[#72383D] to-[#AB644B] hover:from-[#401B1B] hover:to-[#72383D] text-white rounded-lg transition duration-300"
                            >
                                <span wire:loading.remove wire:target="stockIn">Confirm Stock-in</span>
                                <span wire:loading wire:target="stockIn">Processing...</span>
                            </button>
                        </div>
                    </div>

                    <!-- Close Button -->
                    <button 
                        wire:click="$set('showPickupModal', false)"
                        class="absolute top-4 right-4 text-[#72383D] hover:text-[#401B1B] transition-colors duration-200"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Record Pickup Modal -->
    <div x-data="{ show: <?php if ((object) ('showRecordPickupModal') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showRecordPickupModal'->value()); ?>')<?php echo e('showRecordPickupModal'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showRecordPickupModal'); ?>')<?php endif; ?> }" 
         x-show="show" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-black/30 backdrop-blur-md"
                 x-show="show"
                 @click="show = false"></div>
            
            <!-- Modal Content -->
            <div class="relative z-[51] bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] rounded-lg max-w-lg w-full border-2 border-[#72383D]/20 shadow-xl">
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-[#401B1B] mb-6">Record Pickup Details</h2>
                    
                    <div class="space-y-4">
                        <?php if($errors->any()): ?>
                            <div class="bg-[#AB644B]/10 text-[#AB644B] p-4 rounded-lg mb-4">
                                <ul class="list-disc list-inside">
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <!-- Pickup Notes -->
                        <div>
                            <label class="block text-[#401B1B] font-semibold mb-2">Pickup Notes</label>
                            <textarea
                                wire:model.defer="pickupNotes"
                                class="w-full rounded-lg border-[#72383D]/20 bg-white/50 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30"
                                rows="3"
                                placeholder="Enter any additional notes about the pickup..."
                            ></textarea>
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-end space-x-3 mt-6">
                            <button 
                                wire:click="$set('showRecordPickupModal', false)"
                                class="px-4 py-2 bg-[#9CABB4] hover:bg-[#72383D] text-white rounded-lg transition duration-300"
                            >
                                Cancel
                            </button>
                            <button 
                                wire:click="recordPickup(<?php echo e($selectedInventoryItem?->id); ?>)"
                                class="px-4 py-2 bg-gradient-to-r from-[#72383D] to-[#AB644B] hover:from-[#401B1B] hover:to-[#72383D] text-white rounded-lg transition duration-300"
                            >
                                <span wire:loading.remove wire:target="recordPickup">Confirm Pickup</span>
                                <span wire:loading wire:target="recordPickup">Processing...</span>
                            </button>
                        </div>
                    </div>

                    <!-- Close Button -->
                    <button 
                        type="button"
                        wire:click="$set('showRecordPickupModal', false)"
                        class="absolute top-4 right-4 text-[#72383D] hover:text-[#401B1B] transition-colors duration-300"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Pickup Details Modal -->
    <div x-data="{ show: <?php if ((object) ('showPickupDetailsModal') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showPickupDetailsModal'->value()); ?>')<?php echo e('showPickupDetailsModal'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showPickupDetailsModal'); ?>')<?php endif; ?> }"
         x-show="show"
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto">
        
        <div class="flex items-center justify-center min-h-screen px-4">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-black/30 backdrop-blur-sm"
                 x-show="show"
                 @click="show = false"></div>
            
            <!-- Modal Content -->
            <div class="relative z-[51] bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] rounded-lg max-w-2xl w-full border-2 border-[#72383D]/20 shadow-xl">
                
                <div class="p-6">
                    <div class="flex justify-between items-start mb-6">
                        <h2 class="text-2xl font-bold text-[#401B1B]">Pickup Details</h2>
                        <button @click="show = false" class="text-[#72383D] hover:text-[#401B1B] transition-colors duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <?php if($selectedPreorder): ?>
                        <div class="space-y-4">
                            <?php $__currentLoopData = $selectedPreorder->inventoryItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="bg-white/50 rounded-lg p-4 border border-[#72383D]/20">
                                    <div class="grid grid-cols-2 gap-4 mb-3">
                                        <div>
                                            <p class="text-sm text-[#72383D]">Product</p>
                                            <p class="font-semibold text-[#401B1B]"><?php echo e($item->product->product_name); ?></p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-[#72383D]">Serial Number</p>
                                            <p class="font-semibold text-[#401B1B]"><?php echo e($item->serial_number); ?></p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-[#72383D]">Verification</p>
                                            <p class="font-semibold text-[#401B1B]"><?php echo e($item->pickup_verification); ?></p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-[#72383D]">Location</p>
                                            <p class="font-semibold text-[#401B1B]"><?php echo e($item->bought_location); ?></p>
                                        </div>
                                    </div>

                                    <div class="space-y-2 mt-4 pt-4 border-t border-[#72383D]/10">
                                        <div>
                                            <p class="text-sm text-[#72383D]">Purchase Date</p>
                                            <p class="font-semibold text-[#401B1B]">
                                                <?php echo e($item->bought_date?->format('M d, Y H:i') ?? 'Not recorded'); ?>

                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-[#72383D]">Pickup Date</p>
                                            <p class="font-semibold text-[#401B1B]">
                                                <?php echo e($item->picked_up_at?->format('M d, Y H:i') ?? 'Not picked up'); ?>

                                            </p>
                                        </div>
                                        <?php if($item->picked_up_by): ?>
                                            <div>
                                                <p class="text-sm text-[#72383D]">Picked Up By</p>
                                                <p class="font-semibold text-[#401B1B]"><?php echo e(optional($item->pickedUpBy)->name); ?></p>
                                            </div>
                                        <?php endif; ?>
                                        <?php if($item->pickup_notes): ?>
                                            <div>
                                                <p class="text-sm text-[#72383D]">Notes</p>
                                                <p class="text-[#401B1B]"><?php echo e($item->pickup_notes); ?></p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Item Details Modal -->
    <div x-data="{ show: <?php if ((object) ('showItemDetails') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showItemDetails'->value()); ?>')<?php echo e('showItemDetails'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showItemDetails'); ?>')<?php endif; ?> }"
         x-show="show"
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto">
        
        <div class="flex items-center justify-center min-h-screen px-4">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-black/30 backdrop-blur-sm"
                 x-show="show"
                 @click="show = false"></div>
            
            <!-- Modal Content -->
            <div class="relative z-[51] bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] rounded-lg max-w-2xl w-full border-2 border-[#72383D]/20 shadow-xl">
                
                <div class="p-6">
                    <?php if($selectedItem): ?>
                        <div class="flex justify-between items-start mb-6">
                            <h2 class="text-2xl font-bold text-[#401B1B]">Item Details</h2>
                            <button @click="show = false" class="text-[#72383D] hover:text-[#401B1B] transition-colors duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <div class="space-y-6">
                            <!-- Product Information -->
                            <div class="bg-white/50 rounded-lg p-4 border border-[#72383D]/20">
                                <h3 class="text-lg font-semibold text-[#401B1B] mb-3">Product Information</h3>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-[#72383D]">Product Name</p>
                                        <p class="font-semibold text-[#401B1B]"><?php echo e($selectedItem->product->product_name); ?></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-[#72383D]">Serial Number</p>
                                        <p class="font-semibold text-[#401B1B]"><?php echo e($selectedItem->serial_number); ?></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-[#72383D]">Price</p>
                                        <p class="font-semibold text-[#401B1B]">₱<?php echo e(number_format($selectedItem->product->price, 2)); ?></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Cancellation Details -->
                            <div class="bg-white/50 rounded-lg p-4 border border-[#72383D]/20">
                                <h3 class="text-lg font-semibold text-[#401B1B] mb-3">Cancellation Details</h3>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-[#72383D]">Cancellation Date</p>
                                        <p class="font-semibold text-[#401B1B]">
                                            <?php echo e($selectedItem->cancellation_date ? Carbon\Carbon::parse($selectedItem->cancellation_date)->format('M d, Y') : 'N/A'); ?>

                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-[#72383D]">Status</p>
                                        <p class="font-semibold text-[#401B1B]">Available for Reassignment</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button wire:click="openAssignModal(<?php echo e($selectedItem->id); ?>)"
                                    class="px-4 py-2 bg-gradient-to-r from-[#72383D] to-[#AB644B] hover:from-[#401B1B] hover:to-[#72383D] text-white rounded-lg transition duration-300">
                                Assign to New Customer
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Assign Customer Modal -->
    <div x-data="{ show: <?php if ((object) ('showAssignCustomerModal') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showAssignCustomerModal'->value()); ?>')<?php echo e('showAssignCustomerModal'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showAssignCustomerModal'); ?>')<?php endif; ?> }"
         x-show="show"
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto">
        
        <div class="flex items-center justify-center min-h-screen px-4">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-black/30 backdrop-blur-sm"
                 x-show="show"
                 @click="show = false"></div>
            
            <!-- Modal Content -->
            <div class="relative z-[51] bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] rounded-lg max-w-2xl w-full border-2 border-[#72383D]/20 shadow-xl">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-6">
                        <h2 class="text-2xl font-bold text-[#401B1B]">Assign Item to Customer</h2>
                        <button @click="show = false" class="text-[#72383D] hover:text-[#401B1B]">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <?php if($selectedItem): ?>
                        <!-- Item Details -->
                        <div class="bg-white/50 rounded-lg p-4 mb-6 border border-[#72383D]/20">
                            <h3 class="font-semibold text-[#401B1B] mb-2">Selected Item</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-[#72383D]">Product</p>
                                    <p class="font-semibold text-[#401B1B]"><?php echo e($selectedItem->product->product_name); ?></p>
                                </div>
                                <div>
                                    <p class="text-sm text-[#72383D]">Serial Number</p>
                                    <p class="font-semibold text-[#401B1B]"><?php echo e($selectedItem->serial_number); ?></p>
                                </div>
                            </div>
                        </div>

                        <!-- Price Adjustment -->
                        <div class="bg-white/50 rounded-lg p-4 mb-6 border border-[#72383D]/20">
                            <h3 class="font-semibold text-[#401B1B] mb-2">Price Adjustment</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-[#72383D]">Original Price</p>
                                    <p class="font-semibold text-[#401B1B]">₱<?php echo e(number_format($originalPrice, 2)); ?></p>
                                </div>
                                <div>
                                    <label class="text-sm text-[#72383D]">New Price</label>
                                    <input
                                        type="number"
                                        wire:model="newPrice"
                                        step="0.01"
                                        class="w-full rounded-lg border-[#72383D]/20 bg-white/50 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30"
                                        placeholder="Enter new price..."
                                    />
                                    <?php $__errorArgs = ['newPrice'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="text-red-500 text-xs"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>

                        <!-- Available Preorders -->
                        <div class="space-y-4">
                            <h3 class="font-semibold text-[#401B1B]">Available Preorders</h3>
                            <?php if($availablePreorders->isEmpty()): ?>
                                <p class="text-[#72383D] text-center py-4">No pending preorders found for this product.</p>
                            <?php else: ?>
                                <?php $__currentLoopData = $availablePreorders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $preorder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="p-4 bg-white/50 rounded-lg hover:bg-white/70 transition-colors border border-[#72383D]/20">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <p class="font-semibold text-[#401B1B]"><?php echo e($preorder->customer->name); ?></p>
                                                <p class="text-sm text-[#72383D]">Order #<?php echo e($preorder->id); ?></p>
                                                <p class="text-sm text-[#72383D] mt-1">
                                                    Ordered: <?php echo e($preorder->created_at->format('M d, Y')); ?>

                                                </p>
                                            </div>
                                            <button 
                                                wire:click="assignToCustomer(<?php echo e($preorder->id); ?>)"
                                                class="px-4 py-2 bg-gradient-to-r from-[#72383D] to-[#AB644B] hover:from-[#401B1B] hover:to-[#72383D] text-white rounded-lg transition duration-300"
                                            >
                                                Assign
                                            </button>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Repossessed Item Details Modal -->
    <div x-data="{ show: <?php if ((object) ('showRepossessedDetailsModal') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showRepossessedDetailsModal'->value()); ?>')<?php echo e('showRepossessedDetailsModal'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showRepossessedDetailsModal'); ?>')<?php endif; ?> }"
         x-show="show"
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto">
        
        <div class="flex items-center justify-center min-h-screen px-4">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-black/30 backdrop-blur-sm"
                 x-show="show"
                 @click="show = false"></div>
            
            <!-- Modal Content -->
            <div class="relative z-[51] bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] rounded-lg max-w-2xl w-full border-2 border-[#72383D]/20 shadow-xl">
                <div class="p-6">
                    <?php if($selectedRepossessedItem): ?>
                        <div class="flex justify-between items-start mb-6">
                            <h2 class="text-2xl font-bold text-[#401B1B]">Repossessed Item Details</h2>
                            <button @click="show = false" class="text-[#72383D] hover:text-[#401B1B] transition-colors duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <div class="space-y-6">
                            <!-- Product Information -->
                            <div class="bg-white/50 rounded-lg p-4 border border-[#72383D]/20">
                                <h3 class="text-lg font-semibold text-[#401B1B] mb-3">Product Information</h3>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-[#72383D]">Product Name</p>
                                        <p class="font-semibold text-[#401B1B]"><?php echo e($selectedRepossessedItem->product->product_name); ?></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-[#72383D]">Serial Number</p>
                                        <p class="font-semibold text-[#401B1B]"><?php echo e($selectedRepossessedItem->serial_number); ?></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-[#72383D]">Original Price</p>
                                        <p class="font-semibold text-[#401B1B]">₱<?php echo e(number_format($selectedRepossessedItem->product->price, 2)); ?></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Previous Customer Information -->
                            <div class="bg-white/50 rounded-lg p-4 border border-[#72383D]/20">
                                <h3 class="text-lg font-semibold text-[#401B1B] mb-3">Previous Customer Information</h3>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-[#72383D]">Customer Name</p>
                                        <p class="font-semibold text-[#401B1B]"><?php echo e($selectedRepossessedItem->preorder->customer->name); ?></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-[#72383D]">Repossession Date</p>
                                        <p class="font-semibold text-[#401B1B]">
                                            <?php echo e($selectedRepossessedItem->repossessed_at ? Carbon\Carbon::parse($selectedRepossessedItem->repossessed_at)->format('M d, Y') : 'N/A'); ?>

                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button 
                                wire:click="openAssignModal(<?php echo e($selectedRepossessedItem->id); ?>)"
                                class="px-4 py-2 bg-gradient-to-r from-[#72383D] to-[#AB644B] hover:from-[#401B1B] hover:to-[#72383D] text-white rounded-lg transition duration-300"
                            >
                                Assign to New Customer
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Add the Cancellation Modal -->
    <div x-data="{ show: <?php if ((object) ('showCancellationModal') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showCancellationModal'->value()); ?>')<?php echo e('showCancellationModal'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showCancellationModal'); ?>')<?php endif; ?> }"
         x-show="show"
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto">
        
        <div class="flex items-center justify-center min-h-screen px-4">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-black/30 backdrop-blur-sm"
                 x-show="show"
                 @click="show = false"></div>
            
            <!-- Modal Content -->
            <div class="relative z-[51] bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] rounded-lg max-w-md w-full border-2 border-[#72383D]/20 shadow-xl">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-6">
                        <h2 class="text-2xl font-bold text-[#401B1B]">Cancel Order</h2>
                        <button @click="show = false" class="text-[#72383D] hover:text-[#401B1B] transition-colors duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="mb-6">
                        <label class="block text-[#401B1B] font-medium mb-2">Reason for Cancellation</label>
                        <textarea
                            wire:model="cancellationReason"
                            class="w-full rounded-lg border-[#AB644B]/20 bg-white/50 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30"
                            rows="4"
                            placeholder="Please provide a reason for cancellation..."
                        ></textarea>
                        <?php $__errorArgs = ['cancellationReason'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="text-red-600 text-sm"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="flex justify-end gap-3">
                        <button 
                            wire:click="$set('showCancellationModal', false)"
                            class="px-4 py-2 bg-[#9CABB4] hover:bg-[#72383D] text-white rounded-lg transition duration-300"
                        >
                            Cancel
                        </button>
                        <button 
                            wire:click="cancelOrder"
                            class="px-4 py-2 bg-gradient-to-r from-[#72383D] to-[#AB644B] hover:from-[#401B1B] hover:to-[#72383D] text-white rounded-lg transition duration-300"
                        >
                            Confirm Cancellation
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><?php /**PATH C:\laragon\www\inventorymanagement\resources\views\livewire\inventory\index.blade.php ENDPATH**/ ?>