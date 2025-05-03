<span class="px-2 py-1 text-xs font-medium rounded-full {{ $colors[$status] ?? $colors['default'] }}">
    {{ str_replace('_', ' ', ucfirst($status)) }}
</span> 