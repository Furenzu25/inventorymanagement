<div class="relative">
    <button class="relative p-2" wire:click="toggleNotifications">
        <x-icon name="o-bell" class="w-6 h-6 text-gray-400" />
        @if($unreadCount > 0)
            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-500 rounded-full">
                {{ $unreadCount }}
            </span>
        @endif
    </button>

    @if($showNotifications)
        <div class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg overflow-hidden z-50">
            <div class="p-4">
                <h3 class="text-lg font-semibold mb-4">Notifications</h3>
                @forelse($notifications as $notification)
                    <div class="mb-4 p-3 {{ $notification->status === 'unread' ? 'bg-blue-50' : 'bg-gray-50' }} rounded">
                        <h4 class="font-semibold">{{ $notification->title }}</h4>
                        <p class="text-sm text-gray-600">{{ $notification->message }}</p>
                        <div class="mt-2 text-xs text-gray-500">
                            {{ $notification->created_at->diffForHumans() }}
                        </div>
                        @if($notification->status === 'unread')
                            <button wire:click="markAsRead({{ $notification->id }})" class="text-xs text-blue-600 hover:text-blue-800">
                                Mark as read
                            </button>
                        @endif
                    </div>
                @empty
                    <p class="text-gray-500">No notifications</p>
                @endforelse
            </div>
        </div>
    @endif
</div>
