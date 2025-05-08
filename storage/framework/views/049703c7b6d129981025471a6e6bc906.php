<div class="space-y-6">
    <!-- Stats Overview Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <?php if (isset($component)) { $__componentOriginal8fc4ad737f3c40ff5ac76f434f4104b5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8fc4ad737f3c40ff5ac76f434f4104b5 = $attributes; } ?>
<?php $component = Mary\View\Components\Stat::resolve(['value' => ''.e($customerCount).'','icon' => 'o-users'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stat'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Stat::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'bg-gradient-to-br from-[#401B1B] to-[#72383D] text-white shadow-lg rounded-lg','growth' => ''.e($newCustomersThisMonth).'']); ?>
             <?php $__env->slot('title', null, []); ?> 
                <span class="text-[#F2F2EB] font-semibold">Total Customers</span>
             <?php $__env->endSlot(); ?>
             <?php $__env->slot('subtitle', null, []); ?> 
                <span class="text-[#F2F2EB]/80 text-sm">+<?php echo e($newCustomersThisMonth); ?> this month</span>
             <?php $__env->endSlot(); ?>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8fc4ad737f3c40ff5ac76f434f4104b5)): ?>
<?php $attributes = $__attributesOriginal8fc4ad737f3c40ff5ac76f434f4104b5; ?>
<?php unset($__attributesOriginal8fc4ad737f3c40ff5ac76f434f4104b5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8fc4ad737f3c40ff5ac76f434f4104b5)): ?>
<?php $component = $__componentOriginal8fc4ad737f3c40ff5ac76f434f4104b5; ?>
<?php unset($__componentOriginal8fc4ad737f3c40ff5ac76f434f4104b5); ?>
<?php endif; ?>

        <?php if (isset($component)) { $__componentOriginal8fc4ad737f3c40ff5ac76f434f4104b5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8fc4ad737f3c40ff5ac76f434f4104b5 = $attributes; } ?>
<?php $component = Mary\View\Components\Stat::resolve(['value' => ''.e($preorderCount).'','icon' => 'o-clipboard-document-list'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stat'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Stat::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'bg-gradient-to-br from-[#72383D] to-[#AB644B] text-white shadow-lg rounded-lg','growth' => ''.e($preordersThisMonth).'']); ?>
             <?php $__env->slot('title', null, []); ?> 
                <span class="text-[#F2F2EB] font-semibold">Total Pre-orders</span>
             <?php $__env->endSlot(); ?>
             <?php $__env->slot('subtitle', null, []); ?> 
                <span class="text-[#F2F2EB]/80 text-sm">+<?php echo e($preordersThisMonth); ?> this month</span>
             <?php $__env->endSlot(); ?>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8fc4ad737f3c40ff5ac76f434f4104b5)): ?>
<?php $attributes = $__attributesOriginal8fc4ad737f3c40ff5ac76f434f4104b5; ?>
<?php unset($__attributesOriginal8fc4ad737f3c40ff5ac76f434f4104b5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8fc4ad737f3c40ff5ac76f434f4104b5)): ?>
<?php $component = $__componentOriginal8fc4ad737f3c40ff5ac76f434f4104b5; ?>
<?php unset($__componentOriginal8fc4ad737f3c40ff5ac76f434f4104b5); ?>
<?php endif; ?>

        <?php if (isset($component)) { $__componentOriginal8fc4ad737f3c40ff5ac76f434f4104b5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8fc4ad737f3c40ff5ac76f434f4104b5 = $attributes; } ?>
<?php $component = Mary\View\Components\Stat::resolve(['value' => ''.e($productCount).'','icon' => 'o-cube'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stat'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Stat::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'bg-gradient-to-br from-[#AB644B] to-[#9CABB4] text-white shadow-lg rounded-lg','growth' => ''.e($newProductsThisMonth).'']); ?>
             <?php $__env->slot('title', null, []); ?> 
                <span class="text-[#F2F2EB] font-semibold">Total Products</span>
             <?php $__env->endSlot(); ?>
             <?php $__env->slot('subtitle', null, []); ?> 
                <span class="text-[#F2F2EB]/80 text-sm">+<?php echo e($newProductsThisMonth); ?> this month</span>
             <?php $__env->endSlot(); ?>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8fc4ad737f3c40ff5ac76f434f4104b5)): ?>
<?php $attributes = $__attributesOriginal8fc4ad737f3c40ff5ac76f434f4104b5; ?>
<?php unset($__attributesOriginal8fc4ad737f3c40ff5ac76f434f4104b5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8fc4ad737f3c40ff5ac76f434f4104b5)): ?>
<?php $component = $__componentOriginal8fc4ad737f3c40ff5ac76f434f4104b5; ?>
<?php unset($__componentOriginal8fc4ad737f3c40ff5ac76f434f4104b5); ?>
<?php endif; ?>

        <?php if (isset($component)) { $__componentOriginal8fc4ad737f3c40ff5ac76f434f4104b5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8fc4ad737f3c40ff5ac76f434f4104b5 = $attributes; } ?>
<?php $component = Mary\View\Components\Stat::resolve(['value' => '₱'.e(number_format($totalSales, 2)).'','icon' => 'o-currency-dollar'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stat'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Stat::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'bg-gradient-to-br from-[#9CABB4] to-[#D2DCE6] text-[#401B1B] shadow-lg rounded-lg','growth' => ''.e(number_format($salesGrowthRate, 1)).'%']); ?>
             <?php $__env->slot('title', null, []); ?> 
                <span class="text-[#401B1B] font-semibold">Total Sales</span>
             <?php $__env->endSlot(); ?>
             <?php $__env->slot('subtitle', null, []); ?> 
                <span class="text-[#401B1B]/80 text-sm"><?php echo e($salesGrowthRate >= 0 ? '+' : ''); ?><?php echo e(number_format($salesGrowthRate, 1)); ?>% from last month</span>
             <?php $__env->endSlot(); ?>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8fc4ad737f3c40ff5ac76f434f4104b5)): ?>
<?php $attributes = $__attributesOriginal8fc4ad737f3c40ff5ac76f434f4104b5; ?>
<?php unset($__attributesOriginal8fc4ad737f3c40ff5ac76f434f4104b5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8fc4ad737f3c40ff5ac76f434f4104b5)): ?>
<?php $component = $__componentOriginal8fc4ad737f3c40ff5ac76f434f4104b5; ?>
<?php unset($__componentOriginal8fc4ad737f3c40ff5ac76f434f4104b5); ?>
<?php endif; ?>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Sales Trend Chart -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-[#401B1B]">Sales Trend</h3>
                <div class="text-sm text-[#72383D]">Last 6 months</div>
            </div>
            <div class="relative h-[300px] w-full">
                <canvas id="salesChart"></canvas>
                <?php if(empty($salesChartData['data'])): ?>
                    <div class="absolute inset-0 flex items-center justify-center text-gray-500">
                        No sales data available
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Top Products Chart -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-[#401B1B]">Product Distribution</h3>
                <div class="text-sm text-[#72383D]">Top 5 products</div>
            </div>
            <div class="relative h-[300px] w-full">
                <canvas id="productsChart"></canvas>
                <?php if(empty($topProductsChartData['data'])): ?>
                    <div class="absolute inset-0 flex items-center justify-center text-gray-500">
                        No product data available
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Tables Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Pre-orders -->
        <?php if (isset($component)) { $__componentOriginal7f194736b6f6432dc38786f292496c34 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7f194736b6f6432dc38786f292496c34 = $attributes; } ?>
<?php $component = Mary\View\Components\Card::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Card::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'bg-white shadow-lg rounded-lg overflow-hidden']); ?>
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-[#401B1B]">Recent Pre-orders</h3>
                    <a href="<?php echo e(route('preorders.index')); ?>" class="text-sm text-[#72383D] hover:text-[#401B1B] transition-colors duration-200">
                        View All →
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gradient-to-r from-[#401B1B] to-[#72383D] text-white">
                                <th class="text-left font-semibold p-3 rounded-tl-lg">Customer</th>
                                <th class="text-left font-semibold p-3">Products</th>
                                <th class="text-left font-semibold p-3">Amount</th>
                                <th class="text-left font-semibold p-3 rounded-tr-lg">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $recentPreorders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $preorder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="border-b border-[#D2DCE6] hover:bg-[#F2F2EB] transition-colors duration-200">
                                    <td class="p-3">
                                        <div class="font-medium text-[#401B1B]"><?php echo e($preorder->customer->name); ?></div>
                                        <div class="text-sm text-[#72383D]">#<?php echo e($preorder->id); ?></div>
                                    </td>
                                    <td class="p-3">
                                        <div class="text-[#401B1B] line-clamp-1">
                                            <?php $__currentLoopData = $preorder->preorderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php echo e($item->product->product_name); ?>

                                                <?php if(!$loop->last): ?>, <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </td>
                                    <td class="p-3">
                                        <div class="text-[#401B1B] font-medium">₱<?php echo e(number_format($preorder->total_amount, 2)); ?></div>
                                    </td>
                                    <td class="p-3">
                                        <div class="text-[#401B1B]"><?php echo e($preorder->order_date->format('M d, Y')); ?></div>
                                        <div class="text-sm text-[#72383D]"><?php echo e($preorder->order_date->format('h:i A')); ?></div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7f194736b6f6432dc38786f292496c34)): ?>
<?php $attributes = $__attributesOriginal7f194736b6f6432dc38786f292496c34; ?>
<?php unset($__attributesOriginal7f194736b6f6432dc38786f292496c34); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7f194736b6f6432dc38786f292496c34)): ?>
<?php $component = $__componentOriginal7f194736b6f6432dc38786f292496c34; ?>
<?php unset($__componentOriginal7f194736b6f6432dc38786f292496c34); ?>
<?php endif; ?>

        <!-- Top Products -->
        <?php if (isset($component)) { $__componentOriginal7f194736b6f6432dc38786f292496c34 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7f194736b6f6432dc38786f292496c34 = $attributes; } ?>
<?php $component = Mary\View\Components\Card::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Card::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'bg-white shadow-lg rounded-lg overflow-hidden']); ?>
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-[#401B1B]">Best Selling Products</h3>
                    <a href="<?php echo e(route('products.index')); ?>" class="text-sm text-[#72383D] hover:text-[#401B1B] transition-colors duration-200">
                        View All →
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gradient-to-r from-[#72383D] to-[#AB644B] text-white">
                                <th class="text-left font-semibold p-3 rounded-tl-lg">Product</th>
                                <th class="text-left font-semibold p-3">Brand</th>
                                <th class="text-left font-semibold p-3">Revenue</th>
                                <th class="text-left font-semibold p-3 rounded-tr-lg">Sold</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $topProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="border-b border-[#D2DCE6] hover:bg-[#F2F2EB] transition-colors duration-200">
                                    <td class="p-3">
                                        <div class="font-medium text-[#401B1B]"><?php echo e($product->product_name); ?></div>
                                    </td>
                                    <td class="p-3 text-[#72383D]"><?php echo e($product->product_brand); ?></td>
                                    <td class="p-3">
                                        <div class="text-[#401B1B] font-medium">₱<?php echo e(number_format($product->total_sales, 2)); ?></div>
                                    </td>
                                    <td class="p-3">
                                        <div class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-[#F2F2EB] text-[#401B1B]">
                                            <?php echo e($product->quantity_sold ?? 0); ?> units
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7f194736b6f6432dc38786f292496c34)): ?>
<?php $attributes = $__attributesOriginal7f194736b6f6432dc38786f292496c34; ?>
<?php unset($__attributesOriginal7f194736b6f6432dc38786f292496c34); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7f194736b6f6432dc38786f292496c34)): ?>
<?php $component = $__componentOriginal7f194736b6f6432dc38786f292496c34; ?>
<?php unset($__componentOriginal7f194736b6f6432dc38786f292496c34); ?>
<?php endif; ?>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sales Trend Chart
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($salesChartData['labels'] ?? [], 15, 512) ?>,
            datasets: [{
                label: 'Monthly Sales',
                data: <?php echo json_encode($salesChartData['data'] ?? [], 15, 512) ?>,
                borderColor: '#72383D',
                backgroundColor: 'rgba(114, 56, 61, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return '₱' + context.raw.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    },
                    ticks: {
                        callback: function(value) {
                            return '₱' + value.toLocaleString();
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Top Products Chart
    const productsCtx = document.getElementById('productsChart').getContext('2d');
    new Chart(productsCtx, {
        type: 'doughnut',
        data: {
            labels: <?php echo json_encode($topProductsChartData['labels'] ?? [], 15, 512) ?>,
            datasets: [{
                data: <?php echo json_encode($topProductsChartData['data'] ?? [], 15, 512) ?>,
                backgroundColor: ['#401B1B', '#72383D', '#AB644B', '#9CABB4', '#D2DCE6'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        usePointStyle: true,
                        padding: 20,
                        font: {
                            size: 12
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.raw || 0;
                            return `${label}: ${value} units`;
                        }
                    }
                }
            },
            cutout: '60%'
        }
    });
});
</script>
<?php $__env->stopPush(); ?><?php /**PATH C:\laragon\www\inventorymanagement\resources\views\livewire\Dashboard\index.blade.php ENDPATH**/ ?>