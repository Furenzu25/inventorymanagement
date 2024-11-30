<div class="bg-white/40 backdrop-blur-md overflow-hidden shadow-2xl sm:rounded-3xl border border-[#AB644B]/20">
    <div class="grid grid-cols-12 min-h-[600px]">
        <!-- Users List -->
        <div class="col-span-4 border-r border-[#AB644B]/20">
            <div class="p-4">
                <h2 class="text-xl font-semibold text-[#401B1B] mb-4">Messages</h2>
                <div class="space-y-2">
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <button 
                            wire:click="selectUser(<?php echo e($user['id']); ?>)"
                            wire:key="user-<?php echo e($user['id']); ?>"
                            class="w-full text-left p-3 rounded-lg hover:bg-white/50 transition-all duration-300
                                <?php echo e($selectedUser === $user['id'] ? 'bg-white/50' : ''); ?>">
                            <div class="font-medium text-[#401B1B]">
                                <?php echo e($user['name']); ?>

                            </div>
                            <div class="text-sm text-[#72383D]">
                                <?php echo e($user['email']); ?>

                            </div>
                        </button>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </div>
        </div>

        <!-- Chat Area -->
        <div class="col-span-8 flex flex-col">
            <!--[if BLOCK]><![endif]--><?php if($selectedUser): ?>
                <!-- Messages -->
                <div class="flex-1 p-4 overflow-y-auto space-y-4" id="chat-messages">
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex <?php echo e($msg['sender_id'] === auth()->id() ? 'justify-end' : 'justify-start'); ?>">
                            <div class="<?php echo e($msg['sender_id'] === auth()->id() 
                                ? 'bg-gradient-to-r from-[#72383D] to-[#AB644B] text-white' 
                                : 'bg-white/50 text-[#401B1B]'); ?> 
                                rounded-lg px-4 py-2 max-w-[70%]">
                                <?php echo e($msg['content']); ?>

                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </div>

                <!-- Message Input -->
                <div class="p-4 border-t border-[#AB644B]/20">
                    <form wire:submit.prevent="sendMessage" class="flex gap-2">
                        <input type="text" 
                            wire:model="message" 
                            class="flex-1 rounded-lg border-[#72383D]/20 bg-white/50 focus:border-[#72383D] focus:ring focus:ring-[#72383D]/30"
                            placeholder="Type your message...">
                        <button type="submit" 
                            class="px-4 py-2 bg-gradient-to-r from-[#72383D] to-[#AB644B] text-white rounded-lg hover:from-[#401B1B] hover:to-[#72383D] transition-all duration-300">
                            Send
                        </button>
                    </form>
                </div>
            <?php else: ?>
                <div class="flex-1 flex items-center justify-center text-[#72383D]">
                    Select a user to start messaging
                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:initialized', () => {
        const chatMessages = document.getElementById('chat-messages');
        if (chatMessages) {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
    });
</script> <?php /**PATH C:\laragon\www\inventorymanagement\resources\views/livewire/messages/chat-box.blade.php ENDPATH**/ ?>