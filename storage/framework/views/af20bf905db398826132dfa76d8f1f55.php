<div class="relative z-10 bg-gradient-to-br from-[#F2F2EB] via-[#D2DCE6] to-[#9CABB4] min-h-screen">
    <?php echo $__env->make('livewire.ecommerce.components.nav-bar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <div class="p-4 sm:p-6 md:p-8">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white/40 backdrop-blur-md overflow-hidden shadow-2xl sm:rounded-3xl border border-[#AB644B]/20">
                <div class="p-8 sm:p-12">
                    <div class="flex flex-col md:flex-row gap-8">
                        <!-- Profile Sidebar -->
                        <div class="md:w-1/4">
                            <div class="bg-white/50 p-6 rounded-xl shadow-inner border border-[#AB644B]/10">
                                <div class="text-center mb-6">
                                    <div class="relative w-32 h-32 mx-auto mb-4">
                                        <!--[if BLOCK]><![endif]--><?php if($profileImage): ?>
                                            <img src="<?php echo e($profileImage->temporaryUrl()); ?>" 
                                                 alt="Profile Preview" 
                                                 class="rounded-full w-full h-full object-cover border-4 border-[#72383D]">
                                        <?php elseif($customer['profile_image']): ?>
                                            <img src="<?php echo e(Storage::url($customer['profile_image'])); ?>" 
                                                 alt="Profile" 
                                                 class="rounded-full w-full h-full object-cover border-4 border-[#72383D]">
                                        <?php else: ?>
                                            <div class="w-full h-full rounded-full bg-gradient-to-br from-[#72383D] to-[#AB644B] flex items-center justify-center border-4 border-[#72383D]">
                                                <?php if (isset($component)) { $__componentOriginalce0070e6ae017cca68172d0230e44821 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce0070e6ae017cca68172d0230e44821 = $attributes; } ?>
<?php $component = Mary\View\Components\Icon::resolve(['name' => 'o-user'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Icon::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-16 h-16 text-white']); ?>
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
                                            </div>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        
                                        <!--[if BLOCK]><![endif]--><?php if($profileProgress): ?>
                                            <div class="absolute inset-0 flex items-center justify-center bg-black/50 rounded-full">
                                                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-white"></div>
                                            </div>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                    <div class="relative group">
                                        <input type="file" 
                                               wire:model.live="profileImage" 
                                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" 
                                               accept="image/*">
                                        <button class="text-[#72383D] hover:text-[#401B1B] text-sm transition-all duration-300">
                                            Change Profile Picture
                                        </button>
                                    </div>
                                    <!--[if BLOCK]><![endif]--><?php if(session()->has('profile_message')): ?>
                                        <div class="mt-2 text-sm text-green-600">
                                            <?php echo e(session('profile_message')); ?>

                                        </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <h2 class="text-xl font-semibold text-[#401B1B] mt-4"><?php echo e($customer['name']); ?></h2>
                                    <p class="text-[#72383D]"><?php echo e($customer['email']); ?></p>
                                </div>

                                <nav class="space-y-2">
                                    <button wire:click="switchTab('profile')" 
                                            class="w-full text-left px-4 py-2 rounded-lg transition-all duration-300
                                            <?php echo e($currentTab === 'profile' 
                                                ? 'bg-gradient-to-r from-[#72383D] to-[#AB644B] text-white' 
                                                : 'text-[#401B1B] hover:bg-white/50'); ?>">
                                        Profile Information
                                    </button>
                                    <button wire:click="switchTab('orders')" 
                                            class="w-full text-left px-4 py-2 rounded-lg transition-all duration-300
                                            <?php echo e($currentTab === 'orders' 
                                                ? 'bg-gradient-to-r from-[#72383D] to-[#AB644B] text-white' 
                                                : 'text-[#401B1B] hover:bg-white/50'); ?>">
                                        Order History
                                    </button>
                                </nav>
                            </div>
                        </div>

                        <!-- Main Content -->
                        <div class="md:w-3/4">
                            <div class="bg-white/50 p-6 rounded-xl shadow-inner border border-[#AB644B]/10">
                                <!--[if BLOCK]><![endif]--><?php if($currentTab === 'profile'): ?>
                                    <form wire:submit.prevent="updateProfile">
                                        <div class="space-y-6">
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                <?php if (isset($component)) { $__componentOriginalf51438a7488970badd535e5f203e0c1b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf51438a7488970badd535e5f203e0c1b = $attributes; } ?>
<?php $component = Mary\View\Components\Input::resolve(['label' => 'Name'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'customer.name','class' => 'bg-white/50 border-[#AB644B]/20 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30']); ?>
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
                                                <?php if (isset($component)) { $__componentOriginalf51438a7488970badd535e5f203e0c1b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf51438a7488970badd535e5f203e0c1b = $attributes; } ?>
<?php $component = Mary\View\Components\Input::resolve(['label' => 'Email'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'email','wire:model' => 'customer.email','class' => 'bg-white/50 border-[#AB644B]/20 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30']); ?>
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
                                                <?php if (isset($component)) { $__componentOriginalf51438a7488970badd535e5f203e0c1b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf51438a7488970badd535e5f203e0c1b = $attributes; } ?>
<?php $component = Mary\View\Components\Input::resolve(['label' => 'Birthday'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'date','wire:model' => 'customer.birthday','class' => 'bg-white/50 border-[#AB644B]/20 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30']); ?>
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
                                                <?php if (isset($component)) { $__componentOriginalf51438a7488970badd535e5f203e0c1b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf51438a7488970badd535e5f203e0c1b = $attributes; } ?>
<?php $component = Mary\View\Components\Input::resolve(['label' => 'Phone Number'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'customer.phone_number','class' => 'bg-white/50 border-[#AB644B]/20 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30']); ?>
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

                                            <?php if (isset($component)) { $__componentOriginaleda28cbc945270b2059ee861cf34a6bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaleda28cbc945270b2059ee861cf34a6bc = $attributes; } ?>
<?php $component = Mary\View\Components\Textarea::resolve(['label' => 'Address'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('textarea'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Textarea::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'customer.address','class' => 'bg-white/50 border-[#AB644B]/20 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaleda28cbc945270b2059ee861cf34a6bc)): ?>
<?php $attributes = $__attributesOriginaleda28cbc945270b2059ee861cf34a6bc; ?>
<?php unset($__attributesOriginaleda28cbc945270b2059ee861cf34a6bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaleda28cbc945270b2059ee861cf34a6bc)): ?>
<?php $component = $__componentOriginaleda28cbc945270b2059ee861cf34a6bc; ?>
<?php unset($__componentOriginaleda28cbc945270b2059ee861cf34a6bc); ?>
<?php endif; ?>

                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                <?php if (isset($component)) { $__componentOriginalf51438a7488970badd535e5f203e0c1b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf51438a7488970badd535e5f203e0c1b = $attributes; } ?>
<?php $component = Mary\View\Components\Input::resolve(['label' => 'Reference Contact Person'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'customer.reference_contactperson','class' => 'bg-white/50 border-[#AB644B]/20 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30']); ?>
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
                                                <?php if (isset($component)) { $__componentOriginalf51438a7488970badd535e5f203e0c1b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf51438a7488970badd535e5f203e0c1b = $attributes; } ?>
<?php $component = Mary\View\Components\Input::resolve(['label' => 'Reference Contact Phone'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'customer.reference_contactperson_phonenumber','class' => 'bg-white/50 border-[#AB644B]/20 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30']); ?>
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
                                                <?php if (isset($component)) { $__componentOriginalf51438a7488970badd535e5f203e0c1b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf51438a7488970badd535e5f203e0c1b = $attributes; } ?>
<?php $component = Mary\View\Components\Input::resolve(['label' => 'Valid ID Number'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'customer.valid_id','class' => 'bg-white/50 border-[#AB644B]/20 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30']); ?>
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
                                                <div class="relative group">
                                                    <input type="file" 
                                                           wire:model.live="validIdImage" 
                                                           class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" 
                                                           accept="image/*">
                                                    <button type="button" 
                                                            class="w-full px-4 py-2 bg-gradient-to-r from-[#72383D] to-[#AB644B] text-white rounded-lg hover:from-[#401B1B] hover:to-[#72383D] transition-all duration-300">
                                                        Upload Valid ID
                                                    </button>
                                                </div>
                                            </div>

                                            <!--[if BLOCK]><![endif]--><?php if($validIdProgress): ?>
                                                <div class="mt-2 flex items-center justify-center">
                                                    <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-[#72383D]"></div>
                                                    <span class="ml-2 text-sm text-[#72383D]">Uploading...</span>
                                                </div>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                            <?php if(session()->has('valid_id_message')): ?>
                                                <div class="mt-2 text-sm text-green-600">
                                                    <?php echo e(session('valid_id_message')); ?>

                                                </div>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                            <!--[if BLOCK]><![endif]--><?php if($validIdImage): ?>
                                                <div class="mt-4">
                                                    <label class="block text-sm font-medium text-[#401B1B]">Valid ID Preview</label>
                                                    <img src="<?php echo e($validIdImage->temporaryUrl()); ?>" 
                                                         alt="Valid ID Preview" 
                                                         class="mt-2 max-w-md rounded-lg border border-[#AB644B]/20">
                                                </div>
                                            <?php elseif($customer['valid_id_image']): ?>
                                                <div class="mt-4">
                                                    <label class="block text-sm font-medium text-[#401B1B]">Current Valid ID</label>
                                                    <img src="<?php echo e(Storage::url($customer['valid_id_image'])); ?>" 
                                                         alt="Valid ID" 
                                                         class="mt-2 max-w-md rounded-lg border border-[#AB644B]/20">
                                                </div>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                            <div class="flex justify-end">
                                                <button type="submit" 
                                                        class="bg-gradient-to-r from-[#72383D] to-[#AB644B] hover:from-[#401B1B] hover:to-[#72383D] text-white px-6 py-3 rounded-lg transition duration-300 transform hover:scale-105">
                                                    Save Changes
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                <?php else: ?>
                                    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('customers.orders');

$__html = app('livewire')->mount($__name, $__params, 'lw-4030860312-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><?php /**PATH C:\laragon\www\inventorymanagement\resources\views/livewire/ecommerce/profile.blade.php ENDPATH**/ ?>