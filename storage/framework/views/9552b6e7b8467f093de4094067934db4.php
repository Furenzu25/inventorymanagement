    <div>
         <?php
             // Wee need this extra step to support models arrays. Ex: wire:model="emails.0"  , wire:model="emails.1"
             $uuid = $uuid . $modelName()
         ?>

        <!-- STANDARD LABEL -->
        <!--[if BLOCK]><![endif]--><?php if($label && !$inline): ?>
            <label for="<?php echo e($uuid); ?>" class="pt-0 label label-text font-semibold">
                <span>
                    <?php echo e($label); ?>


                    <!--[if BLOCK]><![endif]--><?php if($attributes->get('required')): ?>
                        <span class="text-error">*</span>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </span>
            </label>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <!-- PREPEND/APPEND CONTAINER -->
        <!--[if BLOCK]><![endif]--><?php if($prepend || $append): ?>
            <div class="flex">
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <!-- PREPEND -->
        <!--[if BLOCK]><![endif]--><?php if($prepend): ?>
            <div class="rounded-s-lg flex items-center bg-base-200">
                <?php echo e($prepend); ?>

            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <div class="relative flex-1">
            <select
                id="<?php echo e($uuid); ?>"
                <?php echo e($attributes->whereDoesntStartWith('class')); ?>

                <?php echo e($attributes->class([
                            'select select-primary w-full font-normal',
                            'ps-10' => ($icon),
                            'h-14' => ($inline),
                            'pt-3' => ($inline && $label),
                            'rounded-s-none' => $prepend,
                            'rounded-e-none' => $append,
                            'border border-dashed' => $attributes->has('readonly') && $attributes->get('readonly') == true,
                            'select-error' => $errors->has($errorFieldName())
                        ])); ?>


            >
                <!--[if BLOCK]><![endif]--><?php if($placeholder): ?>
                    <option value="<?php echo e($placeholderValue); ?>"><?php echo e($placeholder); ?></option>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e(data_get($option, $optionValue)); ?>" <?php if(data_get($option, 'disabled')): ?> disabled <?php endif; ?>><?php echo e(data_get($option, $optionLabel)); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </select>

            <!-- ICON -->
            <!--[if BLOCK]><![endif]--><?php if($icon): ?>
                <?php if (isset($component)) { $__componentOriginalce0070e6ae017cca68172d0230e44821 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce0070e6ae017cca68172d0230e44821 = $attributes; } ?>
<?php $component = Mary\View\Components\Icon::resolve(['name' => $icon] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('mary-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Icon::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'absolute pointer-events-none top-1/2 -translate-y-1/2 start-3 text-gray-400']); ?>
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
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

            <!-- RIGHT ICON  -->
            <!--[if BLOCK]><![endif]--><?php if($iconRight): ?>
                <?php if (isset($component)) { $__componentOriginalce0070e6ae017cca68172d0230e44821 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce0070e6ae017cca68172d0230e44821 = $attributes; } ?>
<?php $component = Mary\View\Components\Icon::resolve(['name' => $iconRight] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('mary-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Icon::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'absolute pointer-events-none top-1/2 end-8 -translate-y-1/2 text-gray-400 ']); ?>
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
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

            <!-- INLINE LABEL -->
            <!--[if BLOCK]><![endif]--><?php if($label && $inline): ?>
                <label for="<?php echo e($uuid); ?>" class="absolute pointer-events-none text-gray-500 duration-300 transform -translate-y-1 scale-75 top-2 origin-left rtl:origin-right rounded px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-1 <?php if($inline && $icon): ?> start-9 <?php else: ?> start-3 <?php endif; ?>">
                    <?php echo e($label); ?>

                </label>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>

        <!-- APPEND -->
        <!--[if BLOCK]><![endif]--><?php if($append): ?>
            <div class="rounded-e-lg flex items-center bg-base-200">
                <?php echo e($append); ?>

            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <!-- END: APPEND/PREPEND CONTAINER  -->
        <!--[if BLOCK]><![endif]--><?php if($prepend || $append): ?>
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <!-- ERROR -->
        <!--[if BLOCK]><![endif]--><?php if(!$omitError && $errors->has($errorFieldName())): ?>
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $errors->get($errorFieldName()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = Arr::wrap($message); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $line): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="<?php echo e($errorClass); ?>" x-classes="text-red-500 label-text-alt p-1"><?php echo e($line); ?></div>
                    <?php if($firstErrorOnly) break; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                <?php if($firstErrorOnly) break; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <!-- HINT -->
        <!--[if BLOCK]><![endif]--><?php if($hint): ?>
            <div class="<?php echo e($hintClass); ?>" x-classes="label-text-alt text-gray-400 ps-1 mt-2"><?php echo e($hint); ?></div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div><?php /**PATH C:\laragon\www\inventorymanagement\storage\framework\views/fe7cd5a5c79bfcabd064bf9545cb248b.blade.php ENDPATH**/ ?>