    @aware(['activateByRoute' => false, 'activeBgColor' => 'bg-base-300'])

    <li>
        <a
            {{
                $attributes->class([
                    "my-0.5 hover:text-inherit rounded-md whitespace-nowrap ",
                    "mary-active-menu $activeBgColor" => ($active || ($activateByRoute && $routeMatches()))
                ])
            }}

            @if($link)
                href="{{ $link }}"

                @if($external)
                    target="_blank"
                @endif

                @if(!$external && !$noWireNavigate)
                    wire:navigate
                @endif
            @endif
        >
            @if($icon)
                <x-mary-icon :name="$icon" />
            @endif

            @if($title || $slot->isNotEmpty())
            <span class="mary-hideable whitespace-nowrap truncate">
                @if($title)
                    {{ $title }}

                    @if($badge)
                        <span class="badge badge-ghost badge-sm {{ $badgeClasses }}">{{ $badge }}</span>
                    @endif
                @else
                    {{ $slot }}
                @endif
            </span>
            @endif
        </a>
    </li>