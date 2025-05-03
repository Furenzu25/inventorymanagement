<div class="bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] min-h-screen p-6">
    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-[#401B1B] mb-2">Payment Management</h1>
        <p class="text-[#72383D] text-lg">Track and manage customer payments</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white/80 rounded-xl shadow-lg p-6 border border-[#72383D]/10">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-[#72383D]">Total Payments</p>
                    <h3 class="text-2xl font-bold text-[#401B1B]">₱<?php echo e(number_format($totalPayments ?? 0, 2)); ?></h3>
                </div>
                <div class="bg-[#72383D]/10 p-3 rounded-full">
                    <svg class="w-6 h-6 text-[#72383D]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white/80 rounded-xl shadow-lg p-6 border border-[#72383D]/10">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-[#72383D]">Pending Approvals</p>
                    <h3 class="text-2xl font-bold text-[#401B1B]"><?php echo e($pendingCount ?? 0); ?></h3>
                </div>
                <div class="bg-[#AB644B]/10 p-3 rounded-full">
                    <svg class="w-6 h-6 text-[#AB644B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white/80 rounded-xl shadow-lg p-6 border border-[#72383D]/10">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-[#72383D]">Today's Payments</p>
                    <h3 class="text-2xl font-bold text-[#401B1B]">₱<?php echo e(number_format($todayPayments ?? 0, 2)); ?></h3>
                </div>
                <div class="bg-[#72383D]/10 p-3 rounded-full">
                    <svg class="w-6 h-6 text-[#72383D]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="bg-white/80 rounded-xl shadow-lg p-6 mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-[#72383D]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                </div>
                <?php if (isset($component)) { $__componentOriginalf51438a7488970badd535e5f203e0c1b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf51438a7488970badd535e5f203e0c1b = $attributes; } ?>
<?php $component = Mary\View\Components\Input::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['placeholder' => 'Search customers...','wire:model.live.debounce.300ms' => 'search','class' => 'pl-10 w-full bg-[#F2F2EB]/50 border-[#72383D]/20 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30 rounded-lg']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf51438a7488970badd535e5f203e0c1b)): ?>
<?php $attributes = $__attributesOriginalf51438a7488970badd535e5f203e0c1b; ?>
<?php unset($__attributesOriginalf51438a7488970badd535e5f203e0c1b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf51438a7488970badd535e5f203e0c1b)): ?>
<?php $component = $__componentOriginalf51438a7488970badd535e5f203e0c1b; ?>
<?php unset($__componentOriginalf51438a7488970badd535e5f203e0c1b); ?>
<?php endif; ?>
            </div>
            
            <div class="flex gap-4">
                <select wire:model.live="filterStatus" class="rounded-lg border-[#72383D]/20 bg-[#F2F2EB]/50 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30">
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                </select>
                
                <select wire:model.live="sortBy" class="rounded-lg border-[#72383D]/20 bg-[#F2F2EB]/50 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30">
                    <option value="latest">Latest First</option>
                    <option value="oldest">Oldest First</option>
                    <option value="amount_high">Highest Amount</option>
                    <option value="amount_low">Lowest Amount</option>
                </select>
            </div>
        </div>
    </div>

    <!-- After the Search and Filter Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Payment Submissions Card -->
        <div class="bg-white/80 rounded-xl shadow-lg p-6">
            <h2 class="text-xl font-semibold text-[#401B1B] mb-4">Pending Payment Submissions</h2>
            <div class="space-y-4">
                <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $paymentSubmissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="bg-[#F2F2EB]/50 p-4 rounded-lg border border-[#72383D]/10">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-medium text-[#401B1B]"><?php echo e($submission->customer->name); ?></p>
                                <p class="text-sm text-[#72383D]">Amount: ₱<?php echo e(number_format($submission->amount, 2)); ?></p>
                                <p class="text-xs text-[#72383D]">Submitted: <?php echo e($submission->created_at->diffForHumans()); ?></p>
                            </div>
                            <button 
                                wire:click="viewSubmission(<?php echo e($submission->id); ?>)"
                                class="text-sm bg-[#72383D] text-white px-3 py-1 rounded-full hover:bg-[#401B1B] transition-colors duration-200"
                            >
                                Review
                            </button>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-[#72383D] text-center">No pending submissions</p>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>

        <!-- Record Payment Card -->
        <div class="bg-white/80 rounded-xl shadow-lg p-6">
            <h2 class="text-xl font-semibold text-[#401B1B] mb-4">Record Payment</h2>
            <div class="space-y-4">
                <button 
                    wire:click="$set('recordPaymentOpen', true)"
                    class="w-full bg-gradient-to-r from-[#72383D] to-[#AB644B] hover:from-[#401B1B] hover:to-[#72383D] text-white py-2 rounded-lg transition-colors duration-200"
                >
                    Record New Payment
                </button>
            </div>
        </div>
    </div>

    <!-- Payment History Table -->
    <div class="bg-white/80 rounded-xl shadow-lg p-6">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gradient-to-r from-[#72383D]/10 to-[#AB644B]/10">
                        <th class="px-6 py-4 text-left text-xs font-semibold text-[#401B1B] uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-[#401B1B] uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-[#401B1B] uppercase tracking-wider">Date</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-[#401B1B] uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-[#401B1B] uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#72383D]/10">
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $this->payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="hover:bg-[#F2F2EB]/50 transition-colors duration-200">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div>
                                        <div class="text-sm font-medium text-[#401B1B]">
                                            <?php echo e($payment->customer->name); ?>

                                        </div>
                                        <div class="text-xs text-[#72383D]">
                                            ID: #<?php echo e($payment->id); ?>

                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-[#401B1B]">₱<?php echo e(number_format($payment->amount_paid, 2)); ?></div>
                                <div class="text-xs text-[#72383D]">
                                    AR #<?php echo e($payment->accountReceivable->id); ?> - Remaining: ₱<?php echo e(number_format($payment->accountReceivable->getRemainingBalanceWithInterest(), 2)); ?>

                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-[#401B1B]"><?php echo e($payment->payment_date->format('M d, Y')); ?></div>
                                <div class="text-xs text-[#72383D]">
                                    Due Amount: ₱<?php echo e(number_format($payment->due_amount, 2)); ?>

                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold
                                    <?php echo e($payment->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                    <?php echo e(ucfirst($payment->status)); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <!--[if BLOCK]><![endif]--><?php if($payment->status === 'active'): ?>
                                    <button 
                                        wire:click="confirmVoid(<?php echo e($payment->id); ?>)"
                                        class="text-sm bg-[#AB644B] text-white px-4 py-1.5 rounded-full hover:bg-[#72383D] transition-colors duration-200 flex items-center gap-2"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Void
                                    </button>
                                <?php else: ?>
                                    <span class="text-sm text-[#72383D]">Voided</span>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </tbody>
            </table>
        </div>

        <!-- Pagination Controls -->
        <div class="mt-6">
            <?php echo e($this->payments->links()); ?>

        </div>

        <!-- Items Per Page Selector -->
        <div class="mt-4 flex items-center justify-end space-x-2">
            <span class="text-sm text-[#72383D]">Items per page:</span>
            <select wire:model.live="perPage" class="rounded-lg border-[#72383D]/20 bg-[#F2F2EB]/50 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
    </div>

    <!-- Payment History Modal -->
    <div x-data="{ open: <?php if ((object) ('paymentHistoryOpen') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('paymentHistoryOpen'->value()); ?>')<?php echo e('paymentHistoryOpen'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('paymentHistoryOpen'); ?>')<?php endif; ?> }" 
         x-show="open" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 backdrop-blur-sm bg-black/50 transition-opacity"></div>
            
            <div class="relative bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] rounded-lg max-w-4xl w-full border-2 border-[#72383D]/20 shadow-xl">
                <div class="p-6">
                    <h3 class="text-2xl font-bold text-[#401B1B] mb-6">Payment History - <?php echo e($selectedCustomer?->name); ?></h3>

                    <!--[if BLOCK]><![endif]--><?php if(session()->has('message')): ?>
                        <div class="mb-6 p-4 bg-[#72383D] text-white rounded-lg">
                            <?php echo e(session('message')); ?>

                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    
                    <!--[if BLOCK]><![endif]--><?php if($selectedCustomer): ?>
                        <!-- AR Selection -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-[#401B1B] mb-2">Select Account Receivable</label>
                            <select wire:model="selectedAR" wire:change="selectAR($event.target.value)" 
                                class="mt-1 block w-full rounded-md border-[#72383D]/20 shadow-md focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30 focus:ring-opacity-50 bg-white/80 transition-all duration-300">
                                <option value="">Select an AR</option>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $selectedCustomer->accountReceivables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ar): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($ar->id); ?>">
                                        AR #<?php echo e($ar->id); ?> - <?php echo e($ar->preorder->preorderItems->map(function($item) { return $item->product->product_name; })->implode(', ')); ?>

                                        (₱<?php echo e(number_format($ar->getRemainingBalanceWithInterest(), 2)); ?> remaining)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </select>
                        </div>

                        <!--[if BLOCK]><![endif]--><?php if($selectedAR && $selectedCustomerPayments->isNotEmpty()): ?>
                            <div class="overflow-x-auto rounded-lg border border-[#72383D]/10 shadow-lg mt-6">
                                <table class="min-w-full divide-y divide-[#72383D]/10">
                                    <thead class="bg-gradient-to-r from-[#72383D]/10 to-[#AB644B]/10">
                                        <tr>
                                            <th class="px-6 py-4 text-left text-xs font-semibold text-[#401B1B] uppercase tracking-wider">Payment Date</th>
                                            <th class="px-6 py-4 text-left text-xs font-semibold text-[#401B1B] uppercase tracking-wider">Amount Paid</th>
                                            <th class="px-6 py-4 text-left text-xs font-semibold text-[#401B1B] uppercase tracking-wider">Due Amount</th>
                                            <th class="px-6 py-4 text-left text-xs font-semibold text-[#401B1B] uppercase tracking-wider">Remaining Balance</th>
                                            <th class="px-6 py-4 text-left text-xs font-semibold text-[#401B1B] uppercase tracking-wider">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white/50 divide-y divide-[#72383D]/10">
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $selectedCustomerPayments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class="hover:bg-[#F2F2EB]/50 transition-colors duration-300">
                                                <td class="px-6 py-4 text-[#401B1B]"><?php echo e($payment->payment_date->format('M d, Y')); ?></td>
                                                <td class="px-6 py-4 text-[#72383D] font-medium">₱<?php echo e(number_format($payment->amount_paid, 2)); ?></td>
                                                <td class="px-6 py-4 text-[#72383D]">₱<?php echo e(number_format($payment->due_amount, 2)); ?></td>
                                                <td class="px-6 py-4 text-[#72383D]">₱<?php echo e(number_format($payment->accountReceivable->getRemainingBalanceWithInterest(), 2)); ?></td>
                                                <td class="px-6 py-4">
                                                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                                                        <?php echo e($payment->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                                        <?php echo e(ucfirst($payment->status)); ?>

                                                    </span>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    </tbody>
                                </table>
                            </div>
                        <?php elseif($selectedAR): ?>
                            <div class="bg-white/50 p-4 rounded-lg text-center text-[#72383D]">
                                No payment history found for this account.
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                        <div class="mt-6">
                            <?php if (isset($component)) { $__componentOriginal602b228a887fab12f0012a3179e5b533 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal602b228a887fab12f0012a3179e5b533 = $attributes; } ?>
<?php $component = Mary\View\Components\Button::resolve(['label' => 'Record New Payment'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'showRecordPayment','class' => 'bg-gradient-to-r from-[#72383D] to-[#AB644B] hover:from-[#401B1B] hover:to-[#72383D] text-white transition duration-300 shadow-md']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal602b228a887fab12f0012a3179e5b533)): ?>
<?php $attributes = $__attributesOriginal602b228a887fab12f0012a3179e5b533; ?>
<?php unset($__attributesOriginal602b228a887fab12f0012a3179e5b533); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal602b228a887fab12f0012a3179e5b533)): ?>
<?php $component = $__componentOriginal602b228a887fab12f0012a3179e5b533; ?>
<?php unset($__componentOriginal602b228a887fab12f0012a3179e5b533); ?>
<?php endif; ?>
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                    <!-- Close Button -->
                    <button 
                        wire:click="closePaymentHistory" 
                        class="absolute top-4 right-4 text-[#72383D] hover:text-[#401B1B] transition-colors duration-300"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Record Payment Modal -->
    <div x-show="$wire.recordPaymentOpen" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 backdrop-blur-sm bg-black/50 transition-opacity"></div>
            
            <div class="relative bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] rounded-xl max-w-lg w-full border-2 border-[#72383D]/20 shadow-2xl transform transition-all">
                <div class="p-8">
                    <!-- Header -->
                    <div class="mb-6">
                        <h3 class="text-2xl font-bold text-[#401B1B]">Record Payment</h3>
                        <p class="text-sm text-[#72383D] mt-1">Select an account receivable and enter payment details</p>
                    </div>
                    
                    <div class="space-y-6">
                        <!-- AR Selection with Icon -->
                        <div class="relative">
                            <label for="ar_id" class="block text-sm font-medium text-[#401B1B] mb-2">Account Receivable</label>
                            <div class="relative">
                                <select 
                                    wire:model.live="selectedAR"
                                    id="ar_id"
                                    class="appearance-none block w-full pl-4 pr-10 py-3 rounded-lg border-[#72383D]/20 bg-white/80 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30 transition-all duration-200"
                                >
                                    <option value="">Select an AR</option>
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $accountReceivables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ar): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($ar->id); ?>">
                                            <?php echo e($ar->customer->name); ?> - ₱<?php echo e(number_format($ar->getTotalAmountWithInterest(), 2)); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="h-5 w-5 text-[#72383D]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!--[if BLOCK]><![endif]--><?php if($selectedARDetails): ?>
                            <!-- AR Details Card -->
                            <div class="bg-white/50 rounded-lg p-4 mt-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-[#72383D]">Monthly Payment</p>
                                        <p class="text-xl font-bold text-[#401B1B]">₱<?php echo e(number_format($selectedARDetails->monthly_payment, 2)); ?></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-[#72383D]">Remaining Balance</p>
                                        <p class="text-xl font-bold text-[#401B1B]">₱<?php echo e(number_format($selectedARDetails->getRemainingBalanceWithInterest(), 2)); ?></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment Amount -->
                            <div>
                                <label for="amount_paid" class="block text-sm font-medium text-[#401B1B] mb-2">Payment Amount</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-[#72383D]">₱</span>
                                    <input 
                                        type="number" 
                                        wire:model="payment.amount_paid"
                                        id="amount_paid"
                                        step="0.01"
                                        class="pl-8 block w-full rounded-lg border-[#72383D]/20 bg-white/80 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30 transition-all duration-200"
                                        placeholder="Enter amount"
                                    >
                                </div>
                            </div>

                            <!-- Payment Date -->
                            <div>
                                <label for="payment_date" class="block text-sm font-medium text-[#401B1B] mb-2">Payment Date</label>
                                <div class="relative">
                                    <input 
                                        type="date" 
                                        wire:model="payment.payment_date"
                                        id="payment_date"
                                        class="block w-full rounded-lg border-[#72383D]/20 bg-white/80 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30 transition-all duration-200"
                                    >
                                </div>
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                        <!-- Action Buttons -->
                        <div class="flex justify-end space-x-3 pt-4">
                            <button 
                                wire:click="$set('recordPaymentOpen', false)"
                                class="px-4 py-2 text-sm font-medium text-[#72383D] hover:text-[#401B1B] transition-colors duration-200"
                            >
                                Cancel
                            </button>
                            <button 
                                wire:click="recordPayment"
                                class="px-6 py-2 text-sm font-medium text-white rounded-lg bg-gradient-to-r from-[#72383D] to-[#AB644B] hover:from-[#401B1B] hover:to-[#72383D] transition-all duration-200 transform hover:scale-105"
                            >
                                Record Payment
                            </button>
                        </div>
                    </div>

                    <!-- Close Button -->
                    <button 
                        wire:click="$set('recordPaymentOpen', false)"
                        class="absolute top-4 right-4 text-[#72383D] hover:text-[#401B1B] transition-colors duration-200"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Reversal Modal -->
    <div x-data="{ open: <?php if ((object) ('reversalModalOpen') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('reversalModalOpen'->value()); ?>')<?php echo e('reversalModalOpen'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('reversalModalOpen'); ?>')<?php endif; ?> }" 
         x-show="open" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 backdrop-blur-sm bg-black/50 transition-opacity"></div>
            
            <div class="relative bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] rounded-lg max-w-lg w-full border-2 border-[#72383D]/20 shadow-xl">
                <div class="p-6">
                    <h3 class="text-2xl font-bold text-[#401B1B] mb-6">Reverse Payment</h3>
                    
                    <!--[if BLOCK]><![endif]--><?php if($reversalStage === 'confirm'): ?>
                        <div class="bg-white/50 p-4 rounded-lg shadow-inner mb-4">
                            <p class="text-[#401B1B]">
                                Are you sure you want to reverse the payment of ₱<?php echo e(number_format($paymentToReverse?->amount_paid ?? 0, 2)); ?>?
                            </p>
                        </div>
                        <div class="flex space-x-2">
                            <?php if (isset($component)) { $__componentOriginal602b228a887fab12f0012a3179e5b533 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal602b228a887fab12f0012a3179e5b533 = $attributes; } ?>
<?php $component = Mary\View\Components\Button::resolve(['label' => 'Yes, Reverse'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'confirmReversal','class' => 'bg-[#72383D] hover:bg-[#401B1B] text-white']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal602b228a887fab12f0012a3179e5b533)): ?>
<?php $attributes = $__attributesOriginal602b228a887fab12f0012a3179e5b533; ?>
<?php unset($__attributesOriginal602b228a887fab12f0012a3179e5b533); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal602b228a887fab12f0012a3179e5b533)): ?>
<?php $component = $__componentOriginal602b228a887fab12f0012a3179e5b533; ?>
<?php unset($__componentOriginal602b228a887fab12f0012a3179e5b533); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal602b228a887fab12f0012a3179e5b533 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal602b228a887fab12f0012a3179e5b533 = $attributes; } ?>
<?php $component = Mary\View\Components\Button::resolve(['label' => 'Cancel'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'cancelReversal','class' => 'bg-[#AB644B] hover:bg-[#72383D] text-white']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal602b228a887fab12f0012a3179e5b533)): ?>
<?php $attributes = $__attributesOriginal602b228a887fab12f0012a3179e5b533; ?>
<?php unset($__attributesOriginal602b228a887fab12f0012a3179e5b533); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal602b228a887fab12f0012a3179e5b533)): ?>
<?php $component = $__componentOriginal602b228a887fab12f0012a3179e5b533; ?>
<?php unset($__componentOriginal602b228a887fab12f0012a3179e5b533); ?>
<?php endif; ?>
                        </div>
                    <?php elseif($reversalStage === 'edit'): ?>
                        <div class="space-y-4">
                            <div class="bg-white/50 p-4 rounded-lg shadow-inner">
                                <label class="block text-sm font-semibold text-[#401B1B] mb-2">New Payment Amount</label>
                                <?php if (isset($component)) { $__componentOriginalf51438a7488970badd535e5f203e0c1b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf51438a7488970badd535e5f203e0c1b = $attributes; } ?>
<?php $component = Mary\View\Components\Input::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model.live' => 'newPaymentAmount','type' => 'number','step' => '0.01','class' => 'mt-1 block w-full border-[#72383D]/20 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf51438a7488970badd535e5f203e0c1b)): ?>
<?php $attributes = $__attributesOriginalf51438a7488970badd535e5f203e0c1b; ?>
<?php unset($__attributesOriginalf51438a7488970badd535e5f203e0c1b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf51438a7488970badd535e5f203e0c1b)): ?>
<?php $component = $__componentOriginalf51438a7488970badd535e5f203e0c1b; ?>
<?php unset($__componentOriginalf51438a7488970badd535e5f203e0c1b); ?>
<?php endif; ?>
                            </div>
                            
                            <div class="bg-white/50 p-4 rounded-lg shadow-inner">
                                <label class="block text-sm font-semibold text-[#401B1B] mb-2">New Payment Date</label>
                                <?php if (isset($component)) { $__componentOriginalf51438a7488970badd535e5f203e0c1b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf51438a7488970badd535e5f203e0c1b = $attributes; } ?>
<?php $component = Mary\View\Components\Input::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'newPaymentDate','type' => 'date','class' => 'mt-1 block w-full border-[#72383D]/20 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf51438a7488970badd535e5f203e0c1b)): ?>
<?php $attributes = $__attributesOriginalf51438a7488970badd535e5f203e0c1b; ?>
<?php unset($__attributesOriginalf51438a7488970badd535e5f203e0c1b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf51438a7488970badd535e5f203e0c1b)): ?>
<?php $component = $__componentOriginalf51438a7488970badd535e5f203e0c1b; ?>
<?php unset($__componentOriginalf51438a7488970badd535e5f203e0c1b); ?>
<?php endif; ?>
                            </div>

                            <div class="bg-white/50 p-4 rounded-lg shadow-inner">
                                <label class="block text-sm font-semibold text-[#401B1B] mb-2">Updated Remaining Balance</label>
                                <?php if (isset($component)) { $__componentOriginalf51438a7488970badd535e5f203e0c1b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf51438a7488970badd535e5f203e0c1b = $attributes; } ?>
<?php $component = Mary\View\Components\Input::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(number_format($this->updatedRemainingBalance, 2)),'type' => 'text','readonly' => true,'disabled' => true,'class' => 'mt-1 block w-full bg-[#D2DCE6]/50 border-[#72383D]/20 shadow-sm']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf51438a7488970badd535e5f203e0c1b)): ?>
<?php $attributes = $__attributesOriginalf51438a7488970badd535e5f203e0c1b; ?>
<?php unset($__attributesOriginalf51438a7488970badd535e5f203e0c1b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf51438a7488970badd535e5f203e0c1b)): ?>
<?php $component = $__componentOriginalf51438a7488970badd535e5f203e0c1b; ?>
<?php unset($__componentOriginalf51438a7488970badd535e5f203e0c1b); ?>
<?php endif; ?>
                            </div>

                            <div class="flex space-x-2 mt-4">
                                <?php if (isset($component)) { $__componentOriginal602b228a887fab12f0012a3179e5b533 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal602b228a887fab12f0012a3179e5b533 = $attributes; } ?>
<?php $component = Mary\View\Components\Button::resolve(['label' => 'Save Changes'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'processReversalWithNewPayment','class' => 'bg-[#72383D] hover:bg-[#401B1B] text-white']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal602b228a887fab12f0012a3179e5b533)): ?>
<?php $attributes = $__attributesOriginal602b228a887fab12f0012a3179e5b533; ?>
<?php unset($__attributesOriginal602b228a887fab12f0012a3179e5b533); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal602b228a887fab12f0012a3179e5b533)): ?>
<?php $component = $__componentOriginal602b228a887fab12f0012a3179e5b533; ?>
<?php unset($__componentOriginal602b228a887fab12f0012a3179e5b533); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginal602b228a887fab12f0012a3179e5b533 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal602b228a887fab12f0012a3179e5b533 = $attributes; } ?>
<?php $component = Mary\View\Components\Button::resolve(['label' => 'Cancel'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'cancelReversal','class' => 'bg-[#AB644B] hover:bg-[#72383D] text-white']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal602b228a887fab12f0012a3179e5b533)): ?>
<?php $attributes = $__attributesOriginal602b228a887fab12f0012a3179e5b533; ?>
<?php unset($__attributesOriginal602b228a887fab12f0012a3179e5b533); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal602b228a887fab12f0012a3179e5b533)): ?>
<?php $component = $__componentOriginal602b228a887fab12f0012a3179e5b533; ?>
<?php unset($__componentOriginal602b228a887fab12f0012a3179e5b533); ?>
<?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </div>
        </div>
    </div>

    <!-- Add this section to show pending submissions -->


    <!-- Payment Approval Modal -->
    <div x-show="$wire.showApprovalModal" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 backdrop-blur-sm bg-black/50 transition-opacity"></div>
            
            <div class="relative bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] rounded-lg max-w-lg w-full border-2 border-[#72383D]/20 shadow-xl">
                <div class="p-6">
                    <h3 class="text-2xl font-bold text-[#401B1B] mb-6">Approve Payment</h3>
                    
                    <div class="space-y-4">
                        <p class="text-[#401B1B]">Are you sure you want to approve this payment?</p>
                        
                        <div class="bg-white/50 p-4 rounded-lg">
                            <p class="text-[#72383D]">Amount: ₱<?php echo e(number_format($viewingSubmission->amount ?? 0, 2)); ?></p>
                            <p class="text-[#72383D]">Customer: <?php echo e($viewingSubmission->customer->name ?? 'N/A'); ?></p>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <?php if (isset($component)) { $__componentOriginal602b228a887fab12f0012a3179e5b533 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal602b228a887fab12f0012a3179e5b533 = $attributes; } ?>
<?php $component = Mary\View\Components\Button::resolve(['label' => 'Cancel'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => '$set(\'showApprovalModal\', false)','class' => 'bg-[#AB644B] hover:bg-[#72383D] text-white']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal602b228a887fab12f0012a3179e5b533)): ?>
<?php $attributes = $__attributesOriginal602b228a887fab12f0012a3179e5b533; ?>
<?php unset($__attributesOriginal602b228a887fab12f0012a3179e5b533); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal602b228a887fab12f0012a3179e5b533)): ?>
<?php $component = $__componentOriginal602b228a887fab12f0012a3179e5b533; ?>
<?php unset($__componentOriginal602b228a887fab12f0012a3179e5b533); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal602b228a887fab12f0012a3179e5b533 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal602b228a887fab12f0012a3179e5b533 = $attributes; } ?>
<?php $component = Mary\View\Components\Button::resolve(['label' => 'Approve'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'approveSubmission','class' => 'bg-gradient-to-r from-[#72383D] to-[#AB644B] hover:from-[#401B1B] hover:to-[#72383D] text-white']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal602b228a887fab12f0012a3179e5b533)): ?>
<?php $attributes = $__attributesOriginal602b228a887fab12f0012a3179e5b533; ?>
<?php unset($__attributesOriginal602b228a887fab12f0012a3179e5b533); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal602b228a887fab12f0012a3179e5b533)): ?>
<?php $component = $__componentOriginal602b228a887fab12f0012a3179e5b533; ?>
<?php unset($__componentOriginal602b228a887fab12f0012a3179e5b533); ?>
<?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Rejection Modal -->
    <div x-show="$wire.showRejectionModal" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 backdrop-blur-sm bg-black/50 transition-opacity"></div>
            
            <div class="relative bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] rounded-lg max-w-lg w-full border-2 border-[#72383D]/20 shadow-xl">
                <div class="p-6">
                    <h3 class="text-2xl font-bold text-[#401B1B] mb-6">Reject Payment</h3>
                    
                    <div class="space-y-4">
                        <p class="text-[#401B1B]">Please provide a reason for rejecting this payment:</p>
                        
                        <div class="bg-white/50 p-4 rounded-lg">
                            <p class="text-[#72383D]">Amount: ₱<?php echo e(number_format($viewingSubmission->amount ?? 0, 2)); ?></p>
                            <p class="text-[#72383D]">Customer: <?php echo e($viewingSubmission->customer->name ?? 'N/A'); ?></p>
                        </div>

                        <div class="mt-4">
                            <label for="rejection_reason" class="block text-sm font-medium text-[#401B1B]">Rejection Reason</label>
                            <textarea
                                wire:model="rejectionReason"
                                id="rejection_reason"
                                rows="3"
                                class="mt-1 block w-full rounded-md border-[#72383D]/20 shadow-sm focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30"
                                placeholder="Enter the reason for rejection..."
                                required
                            ></textarea>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <?php if (isset($component)) { $__componentOriginal602b228a887fab12f0012a3179e5b533 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal602b228a887fab12f0012a3179e5b533 = $attributes; } ?>
<?php $component = Mary\View\Components\Button::resolve(['label' => 'Cancel'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => '$set(\'showRejectionModal\', false)','class' => 'bg-[#AB644B] hover:bg-[#72383D] text-white']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal602b228a887fab12f0012a3179e5b533)): ?>
<?php $attributes = $__attributesOriginal602b228a887fab12f0012a3179e5b533; ?>
<?php unset($__attributesOriginal602b228a887fab12f0012a3179e5b533); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal602b228a887fab12f0012a3179e5b533)): ?>
<?php $component = $__componentOriginal602b228a887fab12f0012a3179e5b533; ?>
<?php unset($__componentOriginal602b228a887fab12f0012a3179e5b533); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal602b228a887fab12f0012a3179e5b533 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal602b228a887fab12f0012a3179e5b533 = $attributes; } ?>
<?php $component = Mary\View\Components\Button::resolve(['label' => 'Reject'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'rejectSubmission','class' => 'bg-[#72383D] hover:bg-[#401B1B] text-white']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal602b228a887fab12f0012a3179e5b533)): ?>
<?php $attributes = $__attributesOriginal602b228a887fab12f0012a3179e5b533; ?>
<?php unset($__attributesOriginal602b228a887fab12f0012a3179e5b533); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal602b228a887fab12f0012a3179e5b533)): ?>
<?php $component = $__componentOriginal602b228a887fab12f0012a3179e5b533; ?>
<?php unset($__componentOriginal602b228a887fab12f0012a3179e5b533); ?>
<?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Submission Review Modal -->
    <div x-show="$wire.submissionModalOpen" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 backdrop-blur-sm bg-black/50 transition-opacity"></div>
            
            <div class="relative bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] rounded-lg max-w-lg w-full border-2 border-[#72383D]/20 shadow-xl">
                <div class="p-6">
                    <h3 class="text-2xl font-bold text-[#401B1B] mb-6">Review Payment Submission</h3>
                    
                    <!--[if BLOCK]><![endif]--><?php if($viewingSubmission): ?>
                    <div class="space-y-4">
                        <!-- Payment Details -->
                        <div class="bg-white/50 p-4 rounded-lg">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-[#72383D]">Customer</p>
                                    <p class="font-medium text-[#401B1B]"><?php echo e($viewingSubmission->customer->name); ?></p>
                                </div>
                                <div>
                                    <p class="text-sm text-[#72383D]">Amount</p>
                                    <p class="font-medium text-[#401B1B]">₱<?php echo e(number_format($viewingSubmission->amount, 2)); ?></p>
                                </div>
                                <div>
                                    <p class="text-sm text-[#72383D]">Due Amount</p>
                                    <p class="font-medium text-[#401B1B]">₱<?php echo e(number_format($viewingSubmission->due_amount, 2)); ?></p>
                                </div>
                                <div>
                                    <p class="text-sm text-[#72383D]">Payment Date</p>
                                    <p class="font-medium text-[#401B1B]"><?php echo e($viewingSubmission->payment_date->format('M d, Y')); ?></p>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Proof -->
                        <div class="bg-white/50 p-4 rounded-lg">
                            <p class="text-sm text-[#72383D] mb-2">Payment Proof</p>
                            <img 
                                src="<?php echo e(Storage::url($viewingSubmission->payment_proof)); ?>" 
                                alt="Payment Proof"
                                class="w-full rounded-lg shadow-md"
                            >
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-end space-x-3">
                            <?php if (isset($component)) { $__componentOriginal602b228a887fab12f0012a3179e5b533 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal602b228a887fab12f0012a3179e5b533 = $attributes; } ?>
<?php $component = Mary\View\Components\Button::resolve(['label' => 'Close'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => '$set(\'submissionModalOpen\', false)','class' => 'bg-[#9CABB4] hover:bg-[#72383D] text-white']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal602b228a887fab12f0012a3179e5b533)): ?>
<?php $attributes = $__attributesOriginal602b228a887fab12f0012a3179e5b533; ?>
<?php unset($__attributesOriginal602b228a887fab12f0012a3179e5b533); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal602b228a887fab12f0012a3179e5b533)): ?>
<?php $component = $__componentOriginal602b228a887fab12f0012a3179e5b533; ?>
<?php unset($__componentOriginal602b228a887fab12f0012a3179e5b533); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal602b228a887fab12f0012a3179e5b533 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal602b228a887fab12f0012a3179e5b533 = $attributes; } ?>
<?php $component = Mary\View\Components\Button::resolve(['label' => 'Reject'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'openRejectionModal','class' => 'bg-[#AB644B] hover:bg-[#72383D] text-white']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal602b228a887fab12f0012a3179e5b533)): ?>
<?php $attributes = $__attributesOriginal602b228a887fab12f0012a3179e5b533; ?>
<?php unset($__attributesOriginal602b228a887fab12f0012a3179e5b533); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal602b228a887fab12f0012a3179e5b533)): ?>
<?php $component = $__componentOriginal602b228a887fab12f0012a3179e5b533; ?>
<?php unset($__componentOriginal602b228a887fab12f0012a3179e5b533); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal602b228a887fab12f0012a3179e5b533 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal602b228a887fab12f0012a3179e5b533 = $attributes; } ?>
<?php $component = Mary\View\Components\Button::resolve(['label' => 'Approve'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'openApprovalModal','class' => 'bg-gradient-to-r from-[#72383D] to-[#AB644B] hover:from-[#401B1B] hover:to-[#72383D] text-white']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal602b228a887fab12f0012a3179e5b533)): ?>
<?php $attributes = $__attributesOriginal602b228a887fab12f0012a3179e5b533; ?>
<?php unset($__attributesOriginal602b228a887fab12f0012a3179e5b533); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal602b228a887fab12f0012a3179e5b533)): ?>
<?php $component = $__componentOriginal602b228a887fab12f0012a3179e5b533; ?>
<?php unset($__componentOriginal602b228a887fab12f0012a3179e5b533); ?>
<?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </div>
        </div>
    </div>

    <!-- Void Payment Modal -->
    <div x-show="$wire.showVoidModal" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 backdrop-blur-sm bg-black/50 transition-opacity"></div>
            
            <div class="relative bg-gradient-to-br from-[#F2F2EB] to-[#D2DCE6] rounded-lg max-w-lg w-full border-2 border-[#72383D]/20 shadow-xl">
                <div class="p-6">
                    <h3 class="text-2xl font-bold text-[#401B1B] mb-6">Void Payment</h3>
                    
                    <!--[if BLOCK]><![endif]--><?php if($selectedPayment): ?>
                    <div class="space-y-4">
                        <!-- Payment Details -->
                        <div class="bg-white/50 p-4 rounded-lg">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-[#72383D]">Customer</p>
                                    <p class="font-medium text-[#401B1B]"><?php echo e($selectedPayment->customer->name); ?></p>
                                </div>
                                <div>
                                    <p class="text-sm text-[#72383D]">Amount</p>
                                    <p class="font-medium text-[#401B1B]">₱<?php echo e(number_format($selectedPayment->amount_paid, 2)); ?></p>
                                </div>
                                <div>
                                    <p class="text-sm text-[#72383D]">Payment Date</p>
                                    <p class="font-medium text-[#401B1B]"><?php echo e($selectedPayment->payment_date->format('M d, Y')); ?></p>
                                </div>
                                <div>
                                    <p class="text-sm text-[#72383D]">Status</p>
                                    <p class="font-medium text-[#401B1B] capitalize"><?php echo e($selectedPayment->status); ?></p>
                                </div>
                            </div>
                        </div>

                        <!-- Void Reason -->
                        <div class="mt-4">
                            <label for="void_reason" class="block text-sm font-medium text-[#401B1B]">Void Reason</label>
                            <textarea
                                wire:model="voidReason"
                                id="void_reason"
                                rows="3"
                                class="mt-1 block w-full rounded-md border-[#72383D]/20 shadow-sm focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30"
                                placeholder="Enter the reason for voiding this payment..."
                                required
                            ></textarea>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['voidReason'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                                <span class="text-red-600 text-sm"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <!-- Warning Message -->
                        <div class="bg-[#AB644B]/10 p-4 rounded-lg">
                            <p class="text-[#AB644B] text-sm">
                                <svg class="w-5 h-5 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                Warning: This action cannot be undone. Voiding this payment will update the account receivable balance.
                            </p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-end space-x-3">
                            <?php if (isset($component)) { $__componentOriginal602b228a887fab12f0012a3179e5b533 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal602b228a887fab12f0012a3179e5b533 = $attributes; } ?>
<?php $component = Mary\View\Components\Button::resolve(['label' => 'Cancel'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => '$set(\'showVoidModal\', false)','class' => 'bg-[#9CABB4] hover:bg-[#72383D] text-white']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal602b228a887fab12f0012a3179e5b533)): ?>
<?php $attributes = $__attributesOriginal602b228a887fab12f0012a3179e5b533; ?>
<?php unset($__attributesOriginal602b228a887fab12f0012a3179e5b533); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal602b228a887fab12f0012a3179e5b533)): ?>
<?php $component = $__componentOriginal602b228a887fab12f0012a3179e5b533; ?>
<?php unset($__componentOriginal602b228a887fab12f0012a3179e5b533); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal602b228a887fab12f0012a3179e5b533 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal602b228a887fab12f0012a3179e5b533 = $attributes; } ?>
<?php $component = Mary\View\Components\Button::resolve(['label' => 'Void Payment'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Mary\View\Components\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'voidPayment','class' => 'bg-gradient-to-r from-[#72383D] to-[#AB644B] hover:from-[#401B1B] hover:to-[#72383D] text-white']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal602b228a887fab12f0012a3179e5b533)): ?>
<?php $attributes = $__attributesOriginal602b228a887fab12f0012a3179e5b533; ?>
<?php unset($__attributesOriginal602b228a887fab12f0012a3179e5b533); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal602b228a887fab12f0012a3179e5b533)): ?>
<?php $component = $__componentOriginal602b228a887fab12f0012a3179e5b533; ?>
<?php unset($__componentOriginal602b228a887fab12f0012a3179e5b533); ?>
<?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                    <!-- Close Button -->
                    <button 
                        wire:click="$set('showVoidModal', false)"
                        class="absolute top-4 right-4 text-[#72383D] hover:text-[#401B1B] transition-colors duration-200"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div><?php /**PATH C:\laragon\www\inventorymanagement\resources\views/livewire/payments/index.blade.php ENDPATH**/ ?>