    <?php foreach ((['activateByRoute' => false, 'activeBgColor' => 'bg-base-300']) as $__key => $__value) {
    $__consumeVariable = is_string($__key) ? $__key : $__value;
    $$__consumeVariable = is_string($__key) ? $__env->getConsumableComponentData($__key, $__value) : $__env->getConsumableComponentData($__value);
} ?>

    <li>
        <a
            <?php echo e($attributes->class([
                    "my-0.5 hover:text-inherit rounded-md whitespace-nowrap ",
                    "mary-active-menu $activeBgColor" => ($active || ($activateByRoute && $routeMatches()))
                ])); ?>


            <?php if($link): ?>
                href="<?php echo e($link); ?>"

                <?php if($external): ?>
                    target="_blank"
                <?php endif; ?>

                <?php if(!$external && !$noWireNavigate): ?>
                    wire:navigate
                <?php endif; ?>
            <?php endif; ?>
        >
            <?php if($icon): ?>
                <?php if (isset($component)) { $__componentOriginalce0070e6ae017cca68172d0230e44821 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce0070e6ae017cca68172d0230e44821 = $attributes; } ?>
<?php $component = Mary\View\Components\Icon::resolve(['name' => $icon] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('mary-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Icon::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
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
            <?php endif; ?>

            <?php if($title || $slot->isNotEmpty()): ?>
            <span class="mary-hideable whitespace-nowrap truncate">
                <?php if($title): ?>
                    <?php echo e($title); ?>


                    <?php if($badge): ?>
                        <span class="badge badge-ghost badge-sm <?php echo e($badgeClasses); ?>"><?php echo e($badge); ?></span>
                    <?php endif; ?>
                <?php else: ?>
                    <?php echo e($slot); ?>

                <?php endif; ?>
            </span>
            <?php endif; ?>
        </a>
    </li><?php /**PATH C:\xampp\htdocs\inventorymanagement\storage\framework\views/45618d63fea7fa5d596d1301a4887a07.blade.php ENDPATH**/ ?>