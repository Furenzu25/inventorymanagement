<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AppBrand extends Component
{
    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <a href="/" wire:navigate class="flex items-center">
                <span class="font-bold text-xl bg-gradient-to-r from-yellow-500 to-red-300 bg-clip-text text-transparent">
                    Rosels Tech Shop
                </span>
            </a>
        HTML;
    }
}
