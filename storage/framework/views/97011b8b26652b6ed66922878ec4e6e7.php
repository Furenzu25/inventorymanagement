    <div x-data="{
                    selection: <?php if ((object) ($attributes->wire('model')) instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e($attributes->wire('model')->value()); ?>')<?php echo e($attributes->wire('model')->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e($attributes->wire('model')); ?>')<?php endif; ?>,
                    pageIds: <?php echo e(json_encode($getAllIds())); ?>,
                    isSelectable: <?php echo e(json_encode($selectable)); ?>,
                    colspanSize: 0,
                    init() {
                        this.colspanSize = $refs.headers.childElementCount

                        if (this.isSelectable) {
                            this.handleCheckAll()
                        }
                    },
                    isExpanded(key) {
                        return this.selection.includes(key)
                    },
                    isPageFullSelected() {
                        return [...this.selection]
                                    .sort((a, b) => b - a)
                                    .toString()
                                    .includes([...this.pageIds].sort((a, b) => b - a).toString())
                    },
                    toggleCheck(checked, content) {
                        this.$dispatch('row-selection', { row: content, selected: checked });
                        this.handleCheckAll()
                    },
                    toggleCheckAll(checked) {
                        checked ? this.pushIds() : this.removeIds()
                    },
                    toggleExpand(key) {
                         this.selection.includes(key)
                            ? this.selection = this.selection.filter(i => i !== key)
                            : this.selection.push(key)
                    },
                    pushIds() {
                        this.selection.push(...this.pageIds.filter(i => !this.selection.includes(i)))
                    },
                    removeIds() {
                        this.selection =  this.selection.filter(i => !this.pageIds.includes(i) )
                    },
                    handleCheckAll() {
                        this.$nextTick(() => {
                                this.isPageFullSelected()
                                    ? this.$refs.mainCheckbox.checked = true
                                    : this.$refs.mainCheckbox.checked = false
                            })
                    }
                 }"
    >
    <div class="overflow-x-auto">
    <table
            <?php echo e($attributes
                    ->except('wire:model')
                    ->class([
                        'table',
                        'table-zebra' => $striped,
                        'cursor-pointer' => $attributes->hasAny(['@row-click', 'link'])
                    ])); ?>

        >
            <!-- HEADERS -->
            <thead class="<?php echo \Illuminate\Support\Arr::toCssClasses(["text-black dark:text-gray-200", "hidden" => $noHeaders]); ?>">
                <tr x-ref="headers">
                    <!-- CHECKALL -->
                    <!--[if BLOCK]><![endif]--><?php if($selectable): ?>
                        <th class="w-1" wire:key="<?php echo e($uuid); ?>-checkall-<?php echo e(implode(',', $getAllIds())); ?>">
                            <input
                                id="checkAll-<?php echo e($uuid); ?>"
                                type="checkbox"
                                class="checkbox checkbox-sm"
                                x-ref="mainCheckbox"
                                @click="toggleCheckAll($el.checked)" />
                        </th>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                    <!-- EXPAND EXTRA HEADER -->
                    <!--[if BLOCK]><![endif]--><?php if($expandable): ?>
                        <th class="w-1"></th>
                     <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $headers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $header): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                         <?php
                            # SKIP THE HIDDEN COLUMN
                            if($isHidden($header)) continue;

                            # Scoped slot`s name like `user.city` are compiled to `user___city` through `@scope / @endscope`.
                            # So we use current `$header` key  to find that slot on context.
                            $temp_key = str_replace('.', '___', $header['key'])
                        ?>

                        <th
                            class="<?php if($isSortable($header)): ?> cursor-pointer hover:bg-base-200 <?php endif; ?> <?php echo e($header['class'] ?? ' '); ?>"

                            <?php if($sortBy && $isSortable($header)): ?>
                                @click="$wire.set('sortBy', {column: '<?php echo e($getSort($header)['column']); ?>', direction: '<?php echo e($getSort($header)['direction']); ?>' })"
                            <?php endif; ?>
                        >
                            <?php echo e(isset(${"header_".$temp_key}) ? ${"header_".$temp_key}($header) : $header['label']); ?>


                            <?php if($isSortable($header) && $isSortedBy($header)): ?>
                                <?php if (isset($component)) { $__componentOriginalce0070e6ae017cca68172d0230e44821 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce0070e6ae017cca68172d0230e44821 = $attributes; } ?>
<?php $component = Mary\View\Components\Icon::resolve(['name' => $getSort($header)['direction'] == 'asc' ? 'o-arrow-small-down' : 'o-arrow-small-up'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('mary-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Icon::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4 mb-1']); ?>
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
                        </th>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

                    <!-- ACTIONS (Just a empty column) -->
                    <!--[if BLOCK]><![endif]--><?php if($actions): ?>
                        <th class="w-1"></th>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </tr>
            </thead>

            <!-- ROWS -->
            <tbody>
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr
                        wire:key="<?php echo e($uuid); ?>-<?php echo e($k); ?>"
                        class="hover:bg-base-200/50 <?php echo e($rowClasses($row)); ?>"
                        <?php if($attributes->has('@row-click')): ?>
                            @click="$dispatch('row-click', <?php echo e(json_encode($row)); ?>);"
                        <?php endif; ?>
                    >
                        <!-- CHECKBOX -->
                        <!--[if BLOCK]><![endif]--><?php if($selectable): ?>
                            <td class="w-1">
                                <input
                                    id="checkbox-<?php echo e($uuid); ?>-<?php echo e($k); ?>"
                                    type="checkbox"
                                    class="checkbox checkbox-sm checkbox-primary"
                                    value="<?php echo e(data_get($row, $selectableKey)); ?>"
                                    x-model<?php echo e($selectableModifier()); ?>="selection"
                                    @click="toggleCheck($el.checked, <?php echo e(json_encode($row)); ?>)" />
                            </td>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                        <!-- EXPAND ICON -->
                        <!--[if BLOCK]><![endif]--><?php if($expandable): ?>
                            <td class="w-1 pe-0">
                                <?php if (isset($component)) { $__componentOriginalce0070e6ae017cca68172d0230e44821 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce0070e6ae017cca68172d0230e44821 = $attributes; } ?>
<?php $component = Mary\View\Components\Icon::resolve(['name' => 'o-chevron-down'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('mary-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Icon::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([':class' => 'isExpanded(\''.e(data_get($row, $expandableKey)).'\') || \'-rotate-90 !text-current !bg-base-200\'','class' => 'cursor-pointer p-2 w-8 h-8 bg-base-300 rounded-lg','@click' => 'toggleExpand(\''.e(data_get($row, $expandableKey)).'\');']); ?>
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
                            </td>
                         <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                        <!--  ROW VALUES -->
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $headers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $header): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                # SKIP THE HIDDEN COLUMN
                                if($isHidden($header)) continue;

                                # Scoped slot`s name like `user.city` are compiled to `user___city` through `@scope / @endscope`.
                                # So we use current `$header` key  to find that slot on context.
                                $temp_key = str_replace('.', '___', $header['key'])
                            ?>

                            <!--  HAS CUSTOM SLOT ? -->
                            <!--[if BLOCK]><![endif]--><?php if(isset(${"cell_".$temp_key})): ?>
                                <td class="<?php echo \Illuminate\Support\Arr::toCssClasses([$cellClasses($row, $header), "p-0" => $hasLink($header)]); ?>">
                                    <!--[if BLOCK]><![endif]--><?php if($hasLink($header)): ?>
                                        <a href="<?php echo e($redirectLink($row)); ?>" wire:navigate class="block py-3 px-4">
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                    <?php echo e(${"cell_".$temp_key}($row)); ?>


                                    <!--[if BLOCK]><![endif]--><?php if($hasLink($header)): ?>
                                        </a>
                                     <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </td>
                            <?php else: ?>
                                <td class="<?php echo \Illuminate\Support\Arr::toCssClasses([$cellClasses($row, $header), "p-0" => $hasLink($header)]); ?>">
                                    <!--[if BLOCK]><![endif]--><?php if($hasLink($header)): ?>
                                        <a href="<?php echo e($redirectLink($row)); ?>" wire:navigate class="block py-3 px-4">
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                    <?php echo e(data_get($row, $header['key'])); ?>


                                    <!--[if BLOCK]><![endif]--><?php if($hasLink($header)): ?>
                                        </a>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </td>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

                        <!-- ACTIONS -->
                        <!--[if BLOCK]><![endif]--><?php if($actions): ?>
                            <td class="text-right py-0"><?php echo e($actions($row)); ?></td>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </tr>

                    <!-- EXPANSION SLOT -->
                    <!--[if BLOCK]><![endif]--><?php if($expandable): ?>
                        <tr wire:key="<?php echo e($uuid); ?>-<?php echo e($k); ?>--expand" :class="isExpanded('<?php echo e(data_get($row, $expandableKey)); ?>') || 'hidden'">
                            <td :colspan="colspanSize">
                                <?php echo e($expansion($row)); ?>

                            </td>
                        </tr>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </tbody>
        </table>

        <!--[if BLOCK]><![endif]--><?php if(count($rows) === 0): ?>
            <!--[if BLOCK]><![endif]--><?php if($showEmptyText): ?>
                <div class="text-center py-4 text-gray-500 dark:text-gray-400">
                    <?php echo e($emptyText); ?>

                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <!--[if BLOCK]><![endif]--><?php if($empty): ?>
                <div class="text-center py-4 text-gray-500 dark:text-gray-400">
                    <?php echo e($empty); ?>

                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>
        <!-- Pagination -->
        <!--[if BLOCK]><![endif]--><?php if($withPagination): ?>
            <!--[if BLOCK]><![endif]--><?php if($perPage): ?>
                <?php if (isset($component)) { $__componentOriginal247295a014871d990428507521a0dcaf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal247295a014871d990428507521a0dcaf = $attributes; } ?>
<?php $component = Mary\View\Components\Pagination::resolve(['rows' => $rows,'perPageValues' => $perPageValues] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('mary-pagination'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Pagination::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model.live' => ''.e($perPage).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal247295a014871d990428507521a0dcaf)): ?>
<?php $attributes = $__attributesOriginal247295a014871d990428507521a0dcaf; ?>
<?php unset($__attributesOriginal247295a014871d990428507521a0dcaf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal247295a014871d990428507521a0dcaf)): ?>
<?php $component = $__componentOriginal247295a014871d990428507521a0dcaf; ?>
<?php unset($__componentOriginal247295a014871d990428507521a0dcaf); ?>
<?php endif; ?>
            <?php else: ?>
                <?php if (isset($component)) { $__componentOriginal247295a014871d990428507521a0dcaf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal247295a014871d990428507521a0dcaf = $attributes; } ?>
<?php $component = Mary\View\Components\Pagination::resolve(['rows' => $rows,'perPageValues' => $perPageValues] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('mary-pagination'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Pagination::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal247295a014871d990428507521a0dcaf)): ?>
<?php $attributes = $__attributesOriginal247295a014871d990428507521a0dcaf; ?>
<?php unset($__attributesOriginal247295a014871d990428507521a0dcaf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal247295a014871d990428507521a0dcaf)): ?>
<?php $component = $__componentOriginal247295a014871d990428507521a0dcaf; ?>
<?php unset($__componentOriginal247295a014871d990428507521a0dcaf); ?>
<?php endif; ?>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div><?php /**PATH A:\Xampp\htdocs\inventorymanagement\storage\framework\views/07297f270072f19421f7cbb7b9d95072.blade.php ENDPATH**/ ?>