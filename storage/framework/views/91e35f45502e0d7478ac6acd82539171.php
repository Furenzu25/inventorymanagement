<div class="relative" x-data="{ open: false }" @click.away="open = false">
    <div @click="open = !open">
        <?php echo e($trigger); ?>

    </div>

    <div x-show="open" 
         class="absolute z-50 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
        <div class="py-1">
            <?php echo e($slot); ?>

        </div>
    </div>
</div><?php /**PATH C:\laragon\www\inventorymanagement\resources\views\components\dropdown.blade.php ENDPATH**/ ?>