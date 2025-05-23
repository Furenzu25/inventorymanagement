    <div>
         @php
             // Wee need this extra step to support models arrays. Ex: wire:model="emails.0"  , wire:model="emails.1"
             $uuid = $uuid . $modelName()
         @endphp

        <!-- STANDARD LABEL -->
        @if($label && !$inline)
            <label for="{{ $uuid }}" class="pt-0 label label-text font-semibold">
                <span>
                    {{ $label }}

                    @if($attributes->get('required'))
                        <span class="text-error">*</span>
                    @endif
                </span>
            </label>
        @endif

        <!-- PREPEND/APPEND CONTAINER -->
        @if($prepend || $append)
            <div class="flex">
        @endif

        <!-- PREPEND -->
        @if($prepend)
            <div class="rounded-s-lg flex items-center bg-base-200">
                {{ $prepend }}
            </div>
        @endif

        <div class="relative flex-1">
            <select
                id="{{ $uuid }}"
                {{ $attributes->whereDoesntStartWith('class') }}
                {{ $attributes->class([
                            'select select-primary w-full font-normal',
                            'ps-10' => ($icon),
                            'h-14' => ($inline),
                            'pt-3' => ($inline && $label),
                            'rounded-s-none' => $prepend,
                            'rounded-e-none' => $append,
                            'border border-dashed' => $attributes->has('readonly') && $attributes->get('readonly') == true,
                            'select-error' => $errors->has($errorFieldName())
                        ])
                }}

            >
                @if($placeholder)
                    <option value="{{ $placeholderValue }}">{{ $placeholder }}</option>
                @endif

                @foreach ($options as $option)
                    <option value="{{ data_get($option, $optionValue) }}" @if(data_get($option, 'disabled')) disabled @endif>{{ data_get($option, $optionLabel) }}</option>
                @endforeach
            </select>

            <!-- ICON -->
            @if($icon)
                <x-mary-icon :name="$icon" class="absolute pointer-events-none top-1/2 -translate-y-1/2 start-3 text-gray-400" />
            @endif

            <!-- RIGHT ICON  -->
            @if($iconRight)
                <x-mary-icon :name="$iconRight" class="absolute pointer-events-none top-1/2 end-8 -translate-y-1/2 text-gray-400 " />
            @endif

            <!-- INLINE LABEL -->
            @if($label && $inline)
                <label for="{{ $uuid }}" class="absolute pointer-events-none text-gray-500 duration-300 transform -translate-y-1 scale-75 top-2 origin-left rtl:origin-right rounded px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-1 @if($inline && $icon) start-9 @else start-3 @endif">
                    {{ $label }}
                </label>
            @endif
        </div>

        <!-- APPEND -->
        @if($append)
            <div class="rounded-e-lg flex items-center bg-base-200">
                {{ $append }}
            </div>
        @endif

        <!-- END: APPEND/PREPEND CONTAINER  -->
        @if($prepend || $append)
            </div>
        @endif

        <!-- ERROR -->
        @if(!$omitError && $errors->has($errorFieldName()))
            @foreach($errors->get($errorFieldName()) as $message)
                @foreach(Arr::wrap($message) as $line)
                    <div class="{{ $errorClass }}" x-classes="text-red-500 label-text-alt p-1">{{ $line }}</div>
                    @break($firstErrorOnly)
                @endforeach
                @break($firstErrorOnly)
            @endforeach
        @endif

        <!-- HINT -->
        @if($hint)
            <div class="{{ $hintClass }}" x-classes="label-text-alt text-gray-400 ps-1 mt-2">{{ $hint }}</div>
        @endif
    </div>