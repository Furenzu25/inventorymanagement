    <div
        <?php echo e($attributes
                ->merge(['wire:key' => $uuid ])
                ->class(['card bg-base-100 rounded-lg p-5', 'shadow-sm' => $shadow])); ?>

    >
        <?php if($figure): ?>
            <figure <?php echo e($figure->attributes->class(["mb-5 -m-5"])); ?>>
                <?php echo e($figure); ?>

            </figure>
        <?php endif; ?>

        <?php if($title || $subtitle): ?>
            <div class="pb-5">
                <div class="flex justify-between items-center">
                    <div>
                        <?php if($title): ?>
                            <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(["text-2xl font-bold", is_string($title) ? '' : $title?->attributes->get('class') ]); ?>" >
                                <?php echo e($title); ?>

                            </div>
                        <?php endif; ?>
                        <?php if($subtitle): ?>
                        <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(["text-gray-500 text-sm mt-1", is_string($subtitle) ? '' : $subtitle?->attributes->get('class') ]); ?>" >
                                <?php echo e($subtitle); ?>

                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if($menu): ?>
                        <div <?php echo e($menu->attributes->class(["flex items-center gap-2"])); ?>> <?php echo e($menu); ?> </div>
                    <?php endif; ?>
                </div>

                <?php if($separator): ?>
                    <hr class="mt-3" />

                    <?php if($progressIndicator): ?>
                        <div class="h-0.5 -mt-4 mb-4">
                            <progress
                                class="progress progress-primary w-full h-0.5 dark:h-1"
                                wire:loading

                                <?php if($progressTarget()): ?>
                                    wire:target="<?php echo e($progressTarget()); ?>"
                                 <?php endif; ?>></progress>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div>
            <?php echo e($slot); ?>

        </div>

        <?php if($actions): ?>
            <?php if($separator): ?>
                <hr class="mt-5" />
            <?php endif; ?>

            <div class="flex justify-end gap-3 p-3">
                <?php echo e($actions); ?>

            </div>
        <?php endif; ?>
    </div><?php /**PATH C:\laragon\www\inventorymanagement\storage\framework\views/7c9aecec09171b6cc21b7d0e97cf7deb.blade.php ENDPATH**/ ?>