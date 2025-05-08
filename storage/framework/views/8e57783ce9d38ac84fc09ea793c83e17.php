<span class="px-2 py-1 text-xs font-medium rounded-full <?php echo e($colors[$status]); ?>">
    <?php echo e($count); ?> units
    <?php if($status === 'low_stock'): ?>
        (Low Stock)
    <?php elseif($status === 'out_of_stock'): ?>
        (Out of Stock)
    <?php endif; ?>
</span> <?php /**PATH C:\laragon\www\inventorymanagement\resources\views\components\stock-indicator.blade.php ENDPATH**/ ?>