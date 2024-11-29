<dialog
    {{ $attributes->except('wire:model')->class(["modal"]) }}

    @if($id)
        id="{{ $id }}"
    @else
        x-data="{open: @entangle($attributes->wire('model')).live }"
        :class="{'modal-open !animate-none': open}"
        :open="open"
        @if(!$persistent)
            @keydown.escape.window = "$wire.{{ $attributes->wire('model')->value() }} = false"
        @endif
    @endif
>
    <div class="modal-box {{ $boxClass }}">
        @if($title)
            <x-mary-header :title="$title" :subtitle="$subtitle" size="text-2xl" :separator="$separator" class="mb-5" />
        @endif

        <p class="">
            {{ $slot }}
        </p>

        @if($separator)
            <hr class="mt-5" />
        @endif

        @if($actions)
            <div class="modal-action">
                {{ $actions }}
            </div>
        @endif
    </div>

    @if(!$persistent)
        <form class="modal-backdrop" method="dialog">
            @if ($id)
                <button type="submit">close</button>
            @else
                <button @click="$wire.{{ $attributes->wire('model')->value() }} = false" type="button">close</button>
            @endif
        </form>
    @endif
</dialog>