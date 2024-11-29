<div class="relative z-10 bg-gradient-to-br from-[#F2F2EB] via-[#D2DCE6] to-[#9CABB4] min-h-screen">
    <?php echo $__env->make('livewire.ecommerce.components.nav-bar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <div class="p-4 sm:p-6 md:p-8">
        <div class="max-w-7xl mx-auto">
            <!-- Back Button -->
            <a href="<?php echo e(route('home')); ?>" 
               class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-[#72383D] to-[#AB644B] text-white rounded-lg hover:from-[#401B1B] hover:to-[#72383D] transition duration-300 mb-6">
                <?php if (isset($component)) { $__componentOriginalce0070e6ae017cca68172d0230e44821 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce0070e6ae017cca68172d0230e44821 = $attributes; } ?>
<?php $component = Mary\View\Components\Icon::resolve(['name' => 'o-arrow-left'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Icon::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5 mr-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce0070e6ae017cca68172d0230e44821)): ?>
<?php $attributes = $__attributesOriginalce0070e6ae017cca68172d0230e44821; ?>
<?php unset($__attributesOriginalce0070e6ae017cca68172d0230e44821); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce0070e6ae017cca68172d0230e44821)): ?>
<?php $component = $__componentOriginalce0070e6ae017cca68172d0230e44821; ?>
<?php unset($__componentOriginalce0070e6ae017cca68172d0230e44821); ?>
<?php endif; ?>
                Back to Home
            </a>

            <div class="bg-white/40 backdrop-blur-md overflow-hidden shadow-2xl sm:rounded-3xl border border-[#AB644B]/20">
                <div class="p-8 sm:p-12">
                    <h1 class="text-3xl font-bold text-[#401B1B] mb-8">My Orders</h1>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-[#AB644B]/10">
                            <thead class="bg-white/50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-[#401B1B] uppercase tracking-wider">Order ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-[#401B1B] uppercase tracking-wider">Product</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-[#401B1B] uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-[#401B1B] uppercase tracking-wider">Order Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-[#401B1B] uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white/30 divide-y divide-[#AB644B]/10">
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="hover:bg-white/50 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap text-[#401B1B]">
                                            #<?php echo e($order->id); ?>

                                        </td>
                                        <td class="px-6 py-4 text-[#72383D]">
                                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $order->preorderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="mb-1"><?php echo e($item->product->product_name); ?></div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-3 py-1 rounded-full text-sm
                                                <?php if($order->status === 'Pending'): ?>
                                                    bg-yellow-500/20 text-yellow-700
                                                <?php elseif($order->status === 'loaned'): ?>
                                                    bg-blue-500/20 text-blue-700
                                                <?php elseif($order->status === 'converted'): ?>
                                                    bg-green-500/20 text-green-700
                                                <?php elseif($order->status === 'Cancelled'): ?>
                                                    bg-red-500/20 text-red-700
                                                <?php else: ?>
                                                    bg-gray-500/20 text-gray-700
                                                <?php endif; ?>">
                                                <?php echo e($order->status); ?>

                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-[#72383D]">
                                            <?php echo e($order->created_at->format('M d, Y')); ?>

                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex space-x-3">
                                                <button wire:click="viewOrderDetails(<?php echo e($order->id); ?>)"
                                                        class="text-[#72383D] hover:text-[#401B1B] transition-colors duration-200">
                                                    View Details
                                                </button>
                                                
                                                <!--[if BLOCK]><![endif]--><?php if($order->status === 'Pending'): ?>
                                                    <button wire:click="cancelPreorder(<?php echo e($order->id); ?>)"
                                                            onclick="return confirm('Are you sure you want to cancel this order?')"
                                                            class="text-red-600 hover:text-red-800 transition-colors duration-200">
                                                        Cancel Order
                                                    </button>
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Details Modal -->
    <div x-show="$wire.showOrderDetails" 
         x-transition
         class="fixed inset-0 z-50 overflow-y-auto" 
         aria-labelledby="modal-title" 
         role="dialog" 
         aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
                 aria-hidden="true"
                 wire:click="$set('showOrderDetails', false)"></div>

            <div class="inline-block align-bottom bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <!--[if BLOCK]><![endif]--><?php if($orderDetails): ?>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-6">
                            <h3 class="text-2xl font-bold text-[#401B1B]">Order Details #<?php echo e($orderDetails->id); ?></h3>
                            <button wire:click="$set('showOrderDetails', false)" class="text-[#72383D] hover:text-[#401B1B]">
                                <?php if (isset($component)) { $__componentOriginalce0070e6ae017cca68172d0230e44821 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce0070e6ae017cca68172d0230e44821 = $attributes; } ?>
<?php $component = Mary\View\Components\Icon::resolve(['name' => 'o-x-mark'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Icon::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-6 h-6']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce0070e6ae017cca68172d0230e44821)): ?>
<?php $attributes = $__attributesOriginalce0070e6ae017cca68172d0230e44821; ?>
<?php unset($__attributesOriginalce0070e6ae017cca68172d0230e44821); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce0070e6ae017cca68172d0230e44821)): ?>
<?php $component = $__componentOriginalce0070e6ae017cca68172d0230e44821; ?>
<?php unset($__componentOriginalce0070e6ae017cca68172d0230e44821); ?>
<?php endif; ?>
                            </button>
                        </div>

                        <!-- Order Status -->
                        <div class="mb-6">
                            <div class="flex items-center space-x-2">
                                <span class="font-semibold text-[#401B1B]">Status:</span>
                                <span class="px-3 py-1 rounded-full text-sm
                                    <?php if($orderDetails->status === 'Pending'): ?>
                                        bg-yellow-500/20 text-yellow-700
                                    <?php elseif($orderDetails->status === 'loaned'): ?>
                                        bg-blue-500/20 text-blue-700
                                    <?php elseif($orderDetails->status === 'converted'): ?>
                                        bg-green-500/20 text-green-700
                                    <?php elseif($orderDetails->status === 'Cancelled'): ?>
                                        bg-red-500/20 text-red-700
                                    <?php else: ?>
                                        bg-gray-500/20 text-gray-700
                                    <?php endif; ?>">
                                    <?php echo e($orderDetails->status); ?>

                                </span>
                            </div>
                            
                            <!--[if BLOCK]><![endif]--><?php if($orderDetails->status === 'disapproved' && $orderDetails->disapproval_reason): ?>
                                <div class="mt-2 p-3 bg-red-50 rounded-lg">
                                    <p class="text-sm font-semibold text-red-700">Disapproval Reason:</p>
                                    <p class="text-sm text-red-600"><?php echo e($orderDetails->disapproval_reason); ?></p>
                                </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <!-- Order Information -->
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div>
                                <p class="text-sm text-[#72383D]">Order Date</p>
                                <p class="font-semibold text-[#401B1B]"><?php echo e($orderDetails->created_at->format('M d, Y')); ?></p>
                            </div>
                            <div>
                                <p class="text-sm text-[#72383D]">Payment Method</p>
                                <p class="font-semibold text-[#401B1B]"><?php echo e($orderDetails->payment_method); ?></p>
                            </div>
                            <div>
                                <p class="text-sm text-[#72383D]">Loan Duration</p>
                                <p class="font-semibold text-[#401B1B]"><?php echo e($orderDetails->loan_duration); ?> months</p>
                            </div>
                            <div>
                                <p class="text-sm text-[#72383D]">Interest Rate</p>
                                <p class="font-semibold text-[#401B1B]"><?php echo e($orderDetails->interest_rate); ?>%</p>
                            </div>
                        </div>

                        <!-- Products -->
                        <div class="mb-6">
                            <h4 class="font-semibold text-[#401B1B] mb-3">Ordered Products</h4>
                            <div class="space-y-3">
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $orderDetails->preorderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="flex justify-between items-center p-3 bg-white/50 rounded-lg">
                                        <div>
                                            <p class="font-medium text-[#401B1B]"><?php echo e($item->product->product_name); ?></p>
                                            <p class="text-sm text-[#72383D]">Quantity: <?php echo e($item->quantity); ?></p>
                                        </div>
                                        <p class="font-semibold text-[#401B1B]">₱<?php echo e(number_format($item->price, 2)); ?></p>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </div>

                        <!-- Payment Details -->
                        <div class="border-t border-[#AB644B]/20 pt-4">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-[#72383D]">Total Amount:</span>
                                <span class="font-bold text-xl text-[#401B1B]">₱<?php echo e(number_format($orderDetails->total_amount, 2)); ?></span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-[#72383D]">Monthly Payment:</span>
                                <span class="font-semibold text-[#401B1B]">₱<?php echo e(number_format($orderDetails->monthly_payment, 2)); ?></span>
                            </div>
                        </div>
                    </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>
    </div>
</div><?php /**PATH C:\laragon\www\inventorymanagement\resources\views/livewire/ecommerce/customer-orders.blade.php ENDPATH**/ ?>