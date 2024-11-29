<div class="relative z-10 bg-gradient-to-br from-[#F2F2EB] via-[#D2DCE6] to-[#9CABB4] min-h-screen">
    <?php echo $__env->make('livewire.ecommerce.components.nav-bar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <div wire:poll.5s="refreshCart" class="p-4 sm:p-6 md:p-8">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white/40 backdrop-blur-md overflow-hidden shadow-2xl sm:rounded-3xl border border-[#AB644B]/20">
                <div class="p-8 sm:p-12">
                    <h2 class="text-3xl font-bold text-[#401B1B] mb-8">Your Cart</h2>
                    
                    <!--[if BLOCK]><![endif]--><?php if(!empty($cartItems) && count($cartItems) > 0): ?>
                        <div class="space-y-6">
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="bg-white/50 p-6 rounded-xl shadow-inner border border-[#AB644B]/10">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <h3 class="text-xl font-semibold text-[#401B1B]"><?php echo e($item['name']); ?></h3>
                                            <p class="text-[#72383D]">Quantity: <?php echo e($item['quantity']); ?></p>
                                            <p class="text-[#72383D]">Price: ₱<?php echo e(number_format($item['price'], 2)); ?></p>
                                        </div>
                                        <button wire:click="removeItem(<?php echo e($index); ?>)" 
                                                class="text-[#AB644B] hover:text-[#401B1B] transition-all duration-300">
                                            Remove
                                        </button>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            
                            <div class="bg-white/50 p-6 rounded-xl shadow-inner border border-[#AB644B]/10">
                                <p class="text-2xl font-bold text-[#401B1B]">Total: ₱<?php echo e(number_format($this->getTotal(), 2)); ?></p>
                            </div>
                            
                            <div class="mt-8 space-y-4">
                                <div>
                                    <label for="loanDuration" class="block text-sm font-medium text-[#401B1B]">
                                        Loan Duration
                                    </label>
                                    <select wire:model="loanDuration" id="loanDuration" 
                                        class="mt-1 block w-full rounded-md border-[#72383D]/20 bg-white/50 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30">
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $loanDurationOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $months => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($months); ?>"><?php echo e($label); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    </select>
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['loanDuration'];
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

                                <div>
                                    <label for="paymentMethod" class="block text-sm font-medium text-[#401B1B]">
                                        Payment Method
                                    </label>
                                    <select wire:model="paymentMethod" id="paymentMethod" 
                                        class="mt-1 block w-full rounded-md border-[#72383D]/20 bg-white/50 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30">
                                        <option value="">Select payment method</option>
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $paymentMethods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($value); ?>"><?php echo e($label); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    </select>
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['paymentMethod'];
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

                                <button 
                                    wire:click="submitPreorder" 
                                    <?php if(empty($cartItems)): ?> disabled <?php endif; ?>
                                    class="w-full bg-gradient-to-r from-[#72383D] to-[#AB644B] text-white py-2 px-4 rounded-md 
                                        hover:from-[#401B1B] hover:to-[#72383D] transition-all duration-300
                                        <?php echo e(empty($cartItems) ? 'opacity-50 cursor-not-allowed' : ''); ?>">
                                    Submit Pre-order
                                </button>
                            </div>
                        </div>
                    <?php else: ?>
                        <p class="text-[#72383D] text-center text-lg">Your cart is empty.</p>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </div>
        </div>
    </div>
</div>

<!--[if BLOCK]><![endif]--><?php if(session()->has('error')): ?>
    <div class="mt-4 text-red-600 text-sm">
        <?php echo e(session('error')); ?>

    </div>
<?php endif; ?><!--[if ENDBLOCK]><![endif]-->
<?php /**PATH C:\laragon\www\inventorymanagement\resources\views/livewire/ecommerce/cart.blade.php ENDPATH**/ ?>