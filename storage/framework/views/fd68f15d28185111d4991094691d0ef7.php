<div class="relative z-10 bg-gradient-to-br from-[#F2F2EB] via-[#D2DCE6] to-[#9CABB4] min-h-screen">
    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('ecommerce.components.nav-bar', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-2472237428-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>

    <main class="p-4 sm:p-6 md:p-8">
        <div class="max-w-7xl mx-auto">
            <h2 class="font-semibold text-5xl text-[#401B1B] leading-tight mb-12 text-center">
                <span class="bg-gradient-to-r from-[#401B1B] via-[#72383D] to-[#AB644B] text-transparent bg-clip-text">
                    <?php echo e(__('Welcome!')); ?>

                </span>
            </h2>

            <div class="py-12">
                <div class="bg-white/40 backdrop-blur-md overflow-hidden shadow-2xl sm:rounded-3xl border border-[#AB644B]/20">
                    <div class="p-8 sm:p-12">
                        <h3 class="text-3xl font-light text-[#401B1B] mb-8 text-center">Featured Products</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="bg-gradient-to-br from-white to-[#F2F2EB] p-6 rounded-2xl flex flex-col transition-all duration-300 hover:shadow-xl hover:scale-105 group">
                                    <div class="relative aspect-square mb-6 overflow-hidden rounded-xl">
                                        <!--[if BLOCK]><![endif]--><?php if($product->image): ?>
                                            <img 
                                                src="<?php echo e(Storage::url($product->image)); ?>" 
                                                alt="<?php echo e($product->product_name); ?>" 
                                                class="absolute inset-0 w-full h-full object-contain rounded-xl transition-transform duration-300 group-hover:scale-110"
                                            >
                                        <?php else: ?>
                                            <div class="absolute inset-0 bg-gradient-to-br from-[#D2DCE6] to-[#9CABB4] flex items-center justify-center rounded-xl">
                                                <?php if (isset($component)) { $__componentOriginalce0070e6ae017cca68172d0230e44821 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce0070e6ae017cca68172d0230e44821 = $attributes; } ?>
<?php $component = Mary\View\Components\Icon::resolve(['name' => 'o-photo'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Icon::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-16 h-16 text-white']); ?>
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
                                            </div>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                    <div class="flex flex-col h-[250px]">
                                        <div class="flex-grow">
                                            <h4 class="font-semibold text-[#401B1B] text-xl mb-2 line-clamp-2"><?php echo e($product->product_name); ?></h4>
                                            <p class="text-[#401B1B] font-bold text-2xl mb-3">₱<?php echo e(number_format($product->price, 2)); ?></p>
                                            <p class="text-[#72383D] line-clamp-3"><?php echo e(Str::limit($product->product_description, 100)); ?></p>
                                        </div>
                                        <div class="mt-4 flex justify-between items-center">
                                            <!--[if BLOCK]><![endif]--><?php if(auth()->guard()->check()): ?>
                                                <button 
                                                    wire:click="$dispatch('openModal', [<?php echo e($product->id); ?>])" 
                                                    class="bg-gradient-to-r from-[#72383D] to-[#AB644B] text-white px-4 py-2 rounded-lg hover:from-[#401B1B] hover:to-[#72383D] transition duration-300 transform hover:scale-105"
                                                >
                                                    Add to Cart
                                                </button>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            <button 
                                                onclick="showProductDetails(<?php echo e($product->id); ?>)" 
                                                class="text-[#AB644B] hover:text-[#401B1B] transition duration-300 underline"
                                            >
                                                View Details
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Product Details Modal -->
    <div id="productDetailsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-[60]">
        <div class="bg-white p-8 rounded-2xl max-w-2xl w-full mx-4 shadow-2xl border border-[#AB644B]/20" onclick="event.stopPropagation()">
            <h2 id="modalProductTitle" class="text-3xl font-bold text-[#401B1B] mb-6"></h2>
            <div id="modalProductContent" class="text-[#72383D]"></div>
            <div class="mt-8 flex justify-between items-center">
                <button onclick="closeProductDetails()" class="bg-gradient-to-r from-[#72383D] to-[#AB644B] hover:from-[#401B1B] hover:to-[#72383D] text-white px-6 py-3 rounded-lg transition duration-300 transform hover:scale-105">
                    Close
                </button>
                <!--[if BLOCK]><![endif]--><?php if(auth()->guard()->check()): ?>
                    <button onclick="openAddToCartModal(currentProductId)" 
                            class="bg-gradient-to-r from-[#401B1B] to-[#72383D] text-white px-6 py-3 rounded-lg transition duration-300 transform hover:scale-105">
                        Add to Cart
                    </button>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>
    </div>

    <!--[if BLOCK]><![endif]--><?php if(!auth()->user()->customer): ?>
        <div class="fixed bottom-4 right-4 bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] border-l-4 border-[#AB644B] text-[#401B1B] p-4 rounded-lg shadow-lg">
            <p class="font-bold mb-1">Profile Incomplete</p>
            <p>Complete your profile to unlock pre-ordering features.</p>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('ecommerce.add-to-cart-modal', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-2472237428-1', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
</div>

<script>
    let currentProductId = null;

    function openAddToCartModal(productId) {
        closeProductDetails();
        window.Livewire.find('<?php echo e($_instance->getId()); ?>').dispatch('openModal', productId);
    }

    function showProductDetails(productId) {
        currentProductId = productId;
        const modal = document.getElementById('productDetailsModal');
        const title = document.getElementById('modalProductTitle');
        const content = document.getElementById('modalProductContent');

        window.Livewire.find('<?php echo e($_instance->getId()); ?>').call('getProductDetails', productId).then(product => {
            title.textContent = product.product_name;
            content.innerHTML = `
                <div class="space-y-6">
                    <div class="mb-6">
                        <h3 class="font-bold text-xl mb-3 text-[#401B1B]">Product Description</h3>
                        <div class="text-[#72383D]">${product.product_description}</div>
                    </div>

                    <div class="mb-6">
                        <h3 class="font-bold text-xl mb-3 text-[#401B1B]">Product Details</h3>
                        <div class="text-[#72383D] whitespace-pre-line">${product.product_details}</div>
                    </div>
                    
                    <div class="mb-6">
                        <h3 class="font-bold text-xl mb-3 text-[#401B1B]">Specifications</h3>
                        <ul class="list-disc list-inside text-[#72383D] space-y-2">
                            <li>Model: ${product.product_model}</li>
                            <li>Brand: ${product.product_brand}</li>
                            <li>Storage: ${product.storage_capacity}</li>
                            <li>Category: ${product.product_category}</li>
                        </ul>
                    </div>
                </div>
            `;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        });
    }

    function closeProductDetails() {
        const modal = document.getElementById('productDetailsModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        currentProductId = null;
    }

    // Close modal when clicking outside
    document.getElementById('productDetailsModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeProductDetails();
        }
    });
</script><?php /**PATH C:\laragon\www\inventorymanagement\resources\views/livewire/ecommerce/home.blade.php ENDPATH**/ ?>