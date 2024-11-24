<div class="flex items-center justify-center min-h-screen p-6 bg-gradient-to-br from-[#401B1B] from-20% via-[#72383D] via-40% via-[#AB644B] via-60% via-[#9CABB4] via-80% to-[#F2F2EB]">
    <div class="w-full max-w-md">
        <div class="auth-card bg-white/90 backdrop-blur-sm shadow-lg rounded-lg overflow-hidden">
            <div class="p-8">
                <div class="mb-8 text-center">
                    <h2 class="company-name text-3xl font-bold mb-2">Forgot Password</h2>
                    <p class="text-gray-600">Enter your email to reset your password</p>
                </div>

                <?php if(session('message')): ?>
                    <div class="mb-4 p-3 bg-[#72383D]/10 text-[#72383D] rounded-lg">
                        <?php echo e(session('message')); ?>

                    </div>
                <?php endif; ?>

                <form wire:submit.prevent="forgotPassword" class="space-y-6">
                    <div>
                        <?php if (isset($component)) { $__componentOriginalf51438a7488970badd535e5f203e0c1b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf51438a7488970badd535e5f203e0c1b = $attributes; } ?>
<?php $component = Mary\View\Components\Input::resolve(['label' => 'Email'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model.defer' => 'email','type' => 'email','placeholder' => 'Enter your email','class' => 'w-full border-[#72383D]/20 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30']); ?>
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

                    <div>
                        <?php if (isset($component)) { $__componentOriginal602b228a887fab12f0012a3179e5b533 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal602b228a887fab12f0012a3179e5b533 = $attributes; } ?>
<?php $component = Mary\View\Components\Button::resolve(['label' => 'Send Reset Link','spinner' => true] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','class' => 'w-full bg-gradient-to-r from-[#72383D] to-[#AB644B] hover:from-[#401B1B] hover:to-[#72383D] text-white transition duration-300 shadow-md']); ?>
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
                </form>
            </div>

            <div class="bg-[#F2F2EB]/50 px-8 py-4">
                <div class="text-center text-sm space-y-4">
                    <div>
                        <a href="<?php echo e(route('login')); ?>" class="text-[#72383D] hover:text-[#401B1B] transition-colors">
                            <i class="fas fa-arrow-left mr-1"></i> Back to Login
                        </a>
                    </div>
                    <div>
                        <a href="<?php echo e(route('landing')); ?>" class="text-[#72383D] hover:text-[#401B1B] transition-colors">
                            <i class="fas fa-home mr-1"></i> Back to Landing Page
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><?php /**PATH C:\laragon\www\inventorymanagement\resources\views\livewire\auth\forgot-password.blade.php ENDPATH**/ ?>