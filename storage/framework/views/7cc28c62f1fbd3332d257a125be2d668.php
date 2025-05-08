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
                                <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="hover:bg-white/50 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap text-[#401B1B]">
                                            #<?php echo e($order->id); ?>

                                        </td>
                                        <td class="px-6 py-4 text-[#72383D]">
                                            <?php $__currentLoopData = $order->preorderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="mb-1"><?php echo e($item->product->product_name); ?></div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-3 py-1 rounded-full text-sm
                                                <?php if($order->status === 'Pending'): ?>
                                                    bg-yellow-100 text-yellow-800
                                                <?php elseif($order->status === 'approved'): ?>
                                                    bg-blue-100 text-blue-800
                                                <?php elseif($order->status === 'in_stock'): ?>
                                                    bg-indigo-100 text-indigo-800
                                                <?php elseif($order->status === 'picked_up'): ?>
                                                    bg-purple-100 text-purple-800
                                                <?php elseif($order->status === 'loaned'): ?>
                                                    bg-green-100 text-green-800
                                                <?php elseif($order->status === 'arrived'): ?>
                                                    bg-cyan-100 text-cyan-800
                                                <?php elseif($order->status === 'Cancelled'): ?>
                                                    bg-red-100 text-red-800
                                                <?php elseif($order->status === 'disapproved'): ?>
                                                    bg-rose-100 text-rose-800
                                                <?php elseif($order->status === 'repossessed'): ?>
                                                    bg-orange-100 text-orange-800
                                                <?php elseif($order->status === 'completed'): ?>
                                                    bg-emerald-100 text-emerald-800
                                                <?php else: ?>
                                                    bg-gray-100 text-gray-800
                                                <?php endif; ?>">
                                                <?php echo e(ucfirst($order->status)); ?>

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
                                                
                                                <?php if($order->status === 'Cancelled' || $order->status === 'disapproved'): ?>
                                                    <button 
                                                        wire:click="showDisapprovalReason('<?php echo e($order->status === 'Cancelled' ? $order->cancellation_reason : $order->disapproval_reason); ?>')"
                                                        class="text-xs bg-[#72383D] text-white px-3 py-1 rounded-full hover:bg-[#401B1B] transition-colors duration-200"
                                                    >
                                                        View Reason
                                                    </button>
                                                <?php endif; ?>
                                                
                                                <?php if(in_array($order->status, ['Pending', 'approved'])): ?>
                                                    <button 
                                                        wire:click="openCancellationModal(<?php echo e($order->id); ?>)"
                                                        class="text-[#72383D] hover:text-[#401B1B] transition-colors duration-200">
                                                        Cancel Order
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Details Modal -->
    <div x-show="$wire.showOrderDetails" 

         class="fixed inset-0 z-50 overflow-y-auto" 
         aria-labelledby="modal-title" 
         role="dialog" 
         aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-black/30 backdrop-blur-sm " 
                 aria-hidden="true"
                 x-show="$wire.showOrderDetails"
                
                 wire:click="$set('showOrderDetails', false)"></div>

            <div class="inline-block align-bottom bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <?php if($orderDetails): ?>
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
                                        bg-yellow-100 text-yellow-800
                                    <?php elseif($orderDetails->status === 'approved'): ?>
                                        bg-blue-100 text-blue-800
                                    <?php elseif($orderDetails->status === 'in_stock'): ?>
                                        bg-indigo-100 text-indigo-800
                                    <?php elseif($orderDetails->status === 'picked_up'): ?>
                                        bg-purple-100 text-purple-800
                                    <?php elseif($orderDetails->status === 'loaned'): ?>
                                        bg-green-100 text-green-800
                                    <?php elseif($orderDetails->status === 'arrived'): ?>
                                        bg-cyan-100 text-cyan-800
                                    <?php elseif($orderDetails->status === 'Cancelled'): ?>
                                        bg-red-100 text-red-800
                                    <?php elseif($orderDetails->status === 'disapproved'): ?>
                                        bg-rose-100 text-rose-800
                                    <?php elseif($orderDetails->status === 'repossessed'): ?>
                                        bg-orange-100 text-orange-800
                                    <?php elseif($orderDetails->status === 'completed'): ?>
                                        bg-emerald-100 text-emerald-800
                                    <?php else: ?>
                                        bg-gray-100 text-gray-800
                                    <?php endif; ?>">
                                    <?php echo e(ucfirst($orderDetails->status)); ?>

                                </span>
                            </div>
                            
                            <?php if($orderDetails->status === 'disapproved' && $orderDetails->disapproval_reason): ?>
                                <div class="mt-2 p-3 bg-red-50 rounded-lg">
                                    <p class="text-sm font-semibold text-red-700">Disapproval Reason:</p>
                                    <p class="text-sm text-red-600"><?php echo e($orderDetails->disapproval_reason); ?></p>
                                </div>
                            <?php endif; ?>
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
                                <?php $__currentLoopData = $orderDetails->preorderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="flex justify-between items-center p-3 bg-white/50 rounded-lg">
                                        <div>
                                            <p class="font-medium text-[#401B1B]"><?php echo e($item->product->product_name); ?></p>
                                            <p class="text-sm text-[#72383D]">Quantity: <?php echo e($item->quantity); ?></p>
                                        </div>
                                        <p class="font-semibold text-[#401B1B]">₱<?php echo e(number_format($item->price, 2)); ?></p>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Reason Modal -->
    <template x-teleport="<?php echo e('body'); ?>">
        <div x-data="{ showReasonModal: <?php if ((object) ('showReasonModal') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showReasonModal'->value()); ?>')<?php echo e('showReasonModal'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showReasonModal'); ?>')<?php endif; ?> }">
            <template x-if="showReasonModal">
                <div class="fixed inset-0 z-50 overflow-y-auto backdrop-blur-sm">
                    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                        <div class="fixed inset-0 transition-opacity bg-gray-500/30" aria-hidden="true">
                        </div>

                        <div class="relative bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] rounded-lg max-w-lg w-full border-2 border-[#72383D]/20 shadow-xl">
                            <div class="p-6">
                                <h3 class="text-2xl font-bold text-[#401B1B] mb-6">Cancellation Reason</h3>
                                
                                <div class="bg-[#AB644B]/10 p-4 rounded-lg">
                                    <p class="text-[#72383D]"><?php echo e($selectedReason); ?></p>
                                </div>
                                
                                <div class="mt-6 flex justify-end">
                                    <button 
                                        @click="showReasonModal = false"
                                        class="px-4 py-2 bg-[#72383D] text-white rounded-lg hover:bg-[#401B1B] transition-colors duration-200"
                                    >
                                        Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </template>

    <!-- Cancellation Modal -->
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
            <div class="relative z-[51] bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] rounded-lg max-w-2xl w-full border-2 border-[#72383D]/20 shadow-xl">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-6">
                        <h2 class="text-2xl font-bold text-[#401B1B]">Cancel Order</h2>
                        <button @click="show = false" class="text-[#72383D] hover:text-[#401B1B] transition-colors duration-300">
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

                    <div class="space-y-4">
                        <div>
                            <label class="block text-[#401B1B] font-medium mb-2">Reason for Cancellation</label>
                            <textarea
                                wire:model="cancellationReason"
                                class="w-full rounded-lg border-[#AB644B]/20 bg-white/50 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30 shadow-inner resize-none"
                                rows="4"
                                placeholder="Please provide a reason for cancellation..."
                            ></textarea>
                            <?php $__errorArgs = ['cancellationReason'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-red-500 text-sm mt-1"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="flex justify-end gap-3 mt-6">
                            <button 
                                wire:click="$set('showCancellationModal', false)"
                                class="px-4 py-2 bg-[#9CABB4] hover:bg-[#72383D] text-white rounded-lg transition duration-300"
                            >
                                Cancel
                            </button>
                            <button 
                                wire:click="cancelPreorder"
                                class="px-4 py-2 bg-gradient-to-r from-[#72383D] to-[#AB644B] hover:from-[#401B1B] hover:to-[#72383D] text-white rounded-lg transition duration-300"
                            >
                                Confirm Cancellation
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><?php /**PATH C:\laragon\www\inventorymanagement\resources\views\livewire\ecommerce\customer-orders.blade.php ENDPATH**/ ?>