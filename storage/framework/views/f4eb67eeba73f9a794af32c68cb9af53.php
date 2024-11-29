<div id="<?php echo e($anchor); ?>" <?php echo e($attributes->class(["mb-10", "mary-header-anchor" => $withAnchor])); ?>>
    <div class="flex flex-wrap gap-5 justify-between items-center">
        <div>
            <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(["$size font-extrabold", is_string($title) ? '' : $title?->attributes->get('class') ]); ?>" >
                <!--[if BLOCK]><![endif]--><?php if($withAnchor): ?>
                    <a href="#<?php echo e($anchor); ?>">
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                <?php echo e($title); ?>


                <!--[if BLOCK]><![endif]--><?php if($withAnchor): ?>
                    </a>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>

            <!--[if BLOCK]><![endif]--><?php if($subtitle): ?>
                <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(["text-gray-500 text-sm mt-1", is_string($subtitle) ? '' : $subtitle?->attributes->get('class') ]); ?>" >
                    <?php echo e($subtitle); ?>

                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>

        <!--[if BLOCK]><![endif]--><?php if($middle): ?>
            <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(["flex items-center justify-center gap-3 grow order-last sm:order-none", is_string($middle) ? '' : $middle?->attributes->get('class')]); ?>">
                <div class="w-full lg:w-auto">
                    <?php echo e($middle); ?>

                </div>
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        
        <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(["flex items-center gap-3", is_string($actions) ? '' : $actions?->attributes->get('class') ]); ?>" >
            <?php echo e($actions); ?>

        </div>
    </div>

    <!--[if BLOCK]><![endif]--><?php if($separator): ?>
        <hr class="my-5" />

        <!--[if BLOCK]><![endif]--><?php if($progressIndicator): ?>
            <div class="h-0.5 -mt-9 mb-9">
                <progress
                    class="progress progress-primary w-full h-0.5 dark:h-1"
                    wire:loading

                    <?php if($progressTarget()): ?>
                        wire:target="<?php echo e($progressTarget()); ?>"
                     <?php endif; ?>></progress>
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div><?php /**PATH C:\laragon\www\inventorymanagement\storage\framework\views/a5cb39161fd2e2bc0d04c5477e34f944.blade.php ENDPATH**/ ?>