<dialog
    <?php echo e($attributes->except('wire:model')->class(["modal"])); ?>


    <?php if($id): ?>
        id="<?php echo e($id); ?>"
    <?php else: ?>
        x-data="{open: <?php if ((object) ($attributes->wire('model')) instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e($attributes->wire('model')->value()); ?>')<?php echo e($attributes->wire('model')->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e($attributes->wire('model')); ?>')<?php endif; ?>.live }"
        :class="{'modal-open !animate-none': open}"
        :open="open"
        <?php if(!$persistent): ?>
            @keydown.escape.window = "$wire.<?php echo e($attributes->wire('model')->value()); ?> = false"
        <?php endif; ?>
    <?php endif; ?>
>
    <div class="modal-box <?php echo e($boxClass); ?>">
        <!--[if BLOCK]><![endif]--><?php if($title): ?>
            <?php if (isset($component)) { $__componentOriginal6f99ffca722ef3c8789c4087c5ac9f0d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6f99ffca722ef3c8789c4087c5ac9f0d = $attributes; } ?>
<?php $component = Mary\View\Components\Header::resolve(['title' => $title,'subtitle' => $subtitle,'size' => 'text-2xl','separator' => $separator] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('mary-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Header::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mb-5']); ?>
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
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <p class="">
            <?php echo e($slot); ?>

        </p>

        <!--[if BLOCK]><![endif]--><?php if($separator): ?>
            <hr class="mt-5" />
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <!--[if BLOCK]><![endif]--><?php if($actions): ?>
            <div class="modal-action">
                <?php echo e($actions); ?>

            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>

    <!--[if BLOCK]><![endif]--><?php if(!$persistent): ?>
        <form class="modal-backdrop" method="dialog">
            <!--[if BLOCK]><![endif]--><?php if($id): ?>
                <button type="submit">close</button>
            <?php else: ?>
                <button @click="$wire.<?php echo e($attributes->wire('model')->value()); ?> = false" type="button">close</button>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </form>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</dialog><?php /**PATH C:\laragon\www\inventorymanagement\storage\framework\views/66b1d55ca7ae6c91c490b85f8474bab3.blade.php ENDPATH**/ ?>