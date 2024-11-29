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
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $pendingPreorders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $preorder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="border-b border-[#D2DCE6] hover:bg-[#F2F2EB] transition-colors duration-200">
                                <td class="px-4 py-3 text-[#401B1B]">#<?php echo e($preorder->id); ?></td>
                                <td class="px-4 py-3 text-[#401B1B]"><?php echo e($preorder->customer->name); ?></td>
                                <td class="px-4 py-3 text-[#401B1B]">
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $preorder->preorderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="mb-1">
                                            <?php echo e($item->product->product_name); ?> (<?php echo e($item->quantity); ?>)
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </td>
                                <td class="px-4 py-3 text-[#401B1B]">
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $preorder->inventoryItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="mb-1">
                                            <?php echo e($item->serial_number); ?>

                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </td>
                                <td class="px-4 py-3 text-[#401B1B]"><?php echo e($preorder->status); ?></td>
                                <td class="px-4 py-3">
                                    <!--[if BLOCK]><![endif]--><?php if($preorder->inventoryItems->isNotEmpty()): ?>
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
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </td>
                                <td class="px-4 py-3">
                                    <!--[if BLOCK]><![endif]--><?php if($preorder->status === 'approved'): ?>
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
                                    <?php elseif($preorder->status === 'in_stock' || $preorder->status === 'picked_up'): ?>
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $preorder->inventoryItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <!--[if BLOCK]><![endif]--><?php if(!$item->picked_up_at): ?>
                                                <?php if (isset($component)) { $__componentOriginal602b228a887fab12f0012a3179e5b533 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal602b228a887fab12f0012a3179e5b533 = $attributes; } ?>
<?php $component = Mary\View\Components\Button::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'openPickupModal('.e($item->id).')','class' => 'bg-[#72383D] hover:bg-[#401B1B] text-white transition duration-300 mb-2']); ?>
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
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                        
                                        <!--[if BLOCK]><![endif]--><?php if($preorder->inventoryItems->where('picked_up_at', '!=', null)->count() > 0): ?>
                                            <?php if (isset($component)) { $__componentOriginal602b228a887fab12f0012a3179e5b533 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal602b228a887fab12f0012a3179e5b533 = $attributes; } ?>
<?php $component = Mary\View\Components\Button::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'processLoan('.e($preorder->id).')','class' => 'bg-[#AB644B] hover:bg-[#72383D] text-white transition duration-300']); ?>
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
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <?php elseif($preorder->status === 'loaned'): ?>
                                        <span class="px-3 py-1 text-sm rounded-full bg-green-100 text-green-800">
                                            Loan Active
                                        </span>
                                    <?php elseif($preorder->status === 'arrived'): ?>
                                        <span class="px-3 py-1 text-sm rounded-full bg-yellow-100 text-yellow-800">
                                            Ready for Pickup
                                        </span>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
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
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $repossessedItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="border-b border-[#D2DCE6] hover:bg-[#F2F2EB] transition-colors duration-200">
                                <td class="px-4 py-3 text-[#401B1B]">#<?php echo e($item->preorder->id); ?></td>
                                <td class="px-4 py-3 text-[#401B1B]"><?php echo e($item->preorder->customer->name); ?></td>
                                <td class="px-4 py-3 text-[#401B1B]">
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $item->preorder->preorderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $preorderItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="mb-1">
                                            <?php echo e($preorderItem->product->product_name); ?> (<?php echo e($preorderItem->quantity); ?>)
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </td>
                                <td class="px-4 py-3 text-[#401B1B]">
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $item->preorder->inventoryItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inventoryItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="mb-1">
                                            <?php echo e($inventoryItem->serial_number); ?>

                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </td>
                                <td class="px-4 py-3 text-[#401B1B]"><?php echo e($item->repossession_date); ?></td>
                                <td class="px-4 py-3">
                                    <?php if (isset($component)) { $__componentOriginal602b228a887fab12f0012a3179e5b533 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal602b228a887fab12f0012a3179e5b533 = $attributes; } ?>
<?php $component = Mary\View\Components\Button::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'restore('.e($item->id).')','class' => 'bg-[#AB644B] hover:bg-[#72383D] text-white transition duration-300']); ?>
                                        Restore
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
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
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
                            <th class="px-4 py-3 text-left">Previous Customer</th>
                            <th class="px-4 py-3 text-left">Cancellation Date</th>
                            <th class="px-4 py-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $reassignableItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="border-b border-[#D2DCE6] hover:bg-[#F2F2EB] transition-colors duration-200">
                                <td class="px-4 py-3 text-[#401B1B]"><?php echo e($item->product->product_name); ?></td>
                                <td class="px-4 py-3 text-[#401B1B]"><?php echo e($item->serial_number); ?></td>
                                <td class="px-4 py-3 text-[#401B1B]"><?php echo e($item->preorder->customer->name); ?></td>
                                <td class="px-4 py-3 text-[#401B1B]"><?php echo e($item->cancellation_date->format('M d, Y')); ?></td>
                                <td class="px-4 py-3">
                                    <?php if (isset($component)) { $__componentOriginal602b228a887fab12f0012a3179e5b533 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal602b228a887fab12f0012a3179e5b533 = $attributes; } ?>
<?php $component = Mary\View\Components\Button::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'assignToNewCustomer('.e($item->id).')','class' => 'bg-[#72383D] hover:bg-[#401B1B] text-white transition duration-300']); ?>
                                        Assign to Customer
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
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
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
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $stockedOutItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pickup Modal -->
    <?php if (isset($component)) { $__componentOriginal89a573612f1f1cb2dd9fc072235d4356 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal89a573612f1f1cb2dd9fc072235d4356 = $attributes; } ?>
<?php $component = Mary\View\Components\Modal::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Modal::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'showPickupModal']); ?>
        <div class="bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] p-6 rounded-lg border-2 border-[#72383D]">
            <h2 class="text-[#401B1B] text-2xl font-bold mb-6">Stock-in Details</h2>
            
            <div class="space-y-4">
                <!-- Debug Info -->
                <!--[if BLOCK]><![endif]--><?php if($errors->any()): ?>
                    <div class="bg-red-50 text-red-500 p-4 rounded-lg mb-4">
                        <ul class="list-disc list-inside">
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </ul>
                    </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                <!-- Bought Location -->
                <div>
                    <label class="block text-[#401B1B] font-semibold mb-2">
                        Bought Location
                    </label>
                    <?php if (isset($component)) { $__componentOriginalf51438a7488970badd535e5f203e0c1b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf51438a7488970badd535e5f203e0c1b = $attributes; } ?>
<?php $component = Mary\View\Components\Input::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model.defer' => 'boughtLocation','class' => 'w-full bg-[#1F2937] text-white border-[#72383D] focus:border-[#401B1B] focus:ring focus:ring-[#401B1B]/20','placeholder' => 'Enter where the item was bought...']); ?>
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
                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['boughtLocation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="text-red-500 text-sm"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                </div>

                <!-- Bought Date -->
                <div>
                    <label class="block text-[#401B1B] font-semibold mb-2">
                        Bought Date
                    </label>
                    <?php if (isset($component)) { $__componentOriginalf51438a7488970badd535e5f203e0c1b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf51438a7488970badd535e5f203e0c1b = $attributes; } ?>
<?php $component = Mary\View\Components\Input::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'datetime-local','wire:model.defer' => 'boughtDate','class' => 'w-full bg-[#1F2937] text-white border-[#72383D] focus:border-[#401B1B] focus:ring focus:ring-[#401B1B]/20']); ?>
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
                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['boughtDate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="text-red-500 text-sm"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                </div>

                <!-- Pickup Notes -->
                <div>
                    <label class="block text-[#401B1B] font-semibold mb-2">
                        Pickup Notes
                    </label>
                    <textarea
                        wire:model.defer="pickupNotes"
                        class="w-full rounded-md bg-[#1F2937] text-white border-[#72383D] focus:border-[#401B1B] focus:ring focus:ring-[#401B1B]/20"
                        rows="3"
                        placeholder="Enter any additional notes about the pickup..."
                    ></textarea>
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <?php if (isset($component)) { $__componentOriginal602b228a887fab12f0012a3179e5b533 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal602b228a887fab12f0012a3179e5b533 = $attributes; } ?>
<?php $component = Mary\View\Components\Button::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => '$set(\'showPickupModal\', false)','class' => 'bg-[#9CABB4] hover:bg-[#72383D] text-white transition duration-300']); ?>
                        Cancel
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
<?php $component->withAttributes(['wire:click' => 'stockIn('.e($selectedPreorder?->id).')','class' => 'bg-[#72383D] hover:bg-[#401B1B] text-white transition duration-300']); ?>
                        <span wire:loading.remove wire:target="stockIn">Confirm Stock-in</span>
                        <span wire:loading wire:target="stockIn">Processing...</span>
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
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal89a573612f1f1cb2dd9fc072235d4356)): ?>
<?php $attributes = $__attributesOriginal89a573612f1f1cb2dd9fc072235d4356; ?>
<?php unset($__attributesOriginal89a573612f1f1cb2dd9fc072235d4356); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal89a573612f1f1cb2dd9fc072235d4356)): ?>
<?php $component = $__componentOriginal89a573612f1f1cb2dd9fc072235d4356; ?>
<?php unset($__componentOriginal89a573612f1f1cb2dd9fc072235d4356); ?>
<?php endif; ?>

    <!-- Record Pickup Modal -->
    <div x-data="{ show: <?php if ((object) ('showRecordPickupModal') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showRecordPickupModal'->value()); ?>')<?php echo e('showRecordPickupModal'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showRecordPickupModal'); ?>')<?php endif; ?> }" 
         x-show="show" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-black/30 backdrop-blur-md transition-opacity"
                 @click="show = false"></div>
            
            <!-- Modal Content -->
            <div class="relative z-[51] bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] rounded-lg max-w-lg w-full border-2 border-[#72383D]/20 shadow-xl">
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-[#401B1B] mb-6">Record Pickup Details</h2>
                    
                    <div class="space-y-4">
                        <!--[if BLOCK]><![endif]--><?php if($errors->any()): ?>
                            <div class="bg-[#AB644B]/10 text-[#AB644B] p-4 rounded-lg mb-4">
                                <ul class="list-disc list-inside">
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </ul>
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

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
    <?php if (isset($component)) { $__componentOriginal89a573612f1f1cb2dd9fc072235d4356 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal89a573612f1f1cb2dd9fc072235d4356 = $attributes; } ?>
<?php $component = Mary\View\Components\Modal::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Modal::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'showPickupDetailsModal']); ?>
        <div class="p-6 bg-white">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Pickup Details</h2>
            <!--[if BLOCK]><![endif]--><?php if($selectedPreorder): ?>
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $selectedPreorder->inventoryItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="space-y-3 mb-4">
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <p class="font-semibold text-gray-700">Product: <?php echo e($item->product->product_name); ?></p>
                            <p class="font-semibold text-gray-700">Serial Number: <?php echo e($item->serial_number); ?></p>
                            <p class="font-semibold text-gray-700">Verification: <?php echo e($item->pickup_verification); ?></p>
                            <p class="text-gray-600">Bought at: <?php echo e($item->bought_location); ?></p>
                            <p class="text-gray-600">Bought on: <?php echo e($item->bought_date?->format('M d, Y H:i')); ?></p>
                            <p class="text-gray-600">Picked up: <?php echo e($item->picked_up_at?->format('M d, Y H:i') ?? 'Not picked up'); ?></p>
                            <!--[if BLOCK]><![endif]--><?php if($item->picked_up_by): ?>
                                <p class="text-gray-600">By: <?php echo e(optional($item->pickedUpBy)->name); ?></p>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <!--[if BLOCK]><![endif]--><?php if($item->pickup_notes): ?>
                                <p class="text-gray-500 text-sm">Notes: <?php echo e($item->pickup_notes); ?></p>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal89a573612f1f1cb2dd9fc072235d4356)): ?>
<?php $attributes = $__attributesOriginal89a573612f1f1cb2dd9fc072235d4356; ?>
<?php unset($__attributesOriginal89a573612f1f1cb2dd9fc072235d4356); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal89a573612f1f1cb2dd9fc072235d4356)): ?>
<?php $component = $__componentOriginal89a573612f1f1cb2dd9fc072235d4356; ?>
<?php unset($__componentOriginal89a573612f1f1cb2dd9fc072235d4356); ?>
<?php endif; ?>
</div><?php /**PATH C:\laragon\www\inventorymanagement\resources\views/livewire/inventory/index.blade.php ENDPATH**/ ?>