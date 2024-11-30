<span class="px-2 py-1 text-xs font-medium rounded-full {{ $colors[$status] }}">
    {{ $count }} units
    @if ($status === 'low_stock')
        (Low Stock)
    @elseif ($status === 'out_of_stock')
        (Out of Stock)
    @endif
</span> 