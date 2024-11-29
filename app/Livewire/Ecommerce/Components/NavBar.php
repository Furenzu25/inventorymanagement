<?php

namespace App\Livewire\Ecommerce\Components;

use Livewire\Component;
use App\Traits\WithCartCount;
use App\Traits\WithNotificationCount;

class NavBar extends Component
{
    use WithCartCount;
    use WithNotificationCount;

    protected $listeners = [
        'cart-updated' => '$refresh',
        'notification-updated' => '$refresh',
        'payment-submitted' => 'handlePaymentSubmitted'
    ];

    public function getCartCountProperty()
    {
        return array_sum(array_column(session('cart', []), 'quantity'));
    }

    public function render()
    {
        return view('livewire.ecommerce.components.nav-bar');
    }

    public function logout()
    {
        auth()->logout();
        session()->forget('cart');
        return redirect()->route('login');
    }

    public function handlePaymentSubmitted()
    {
        session()->flash('message', 'Payment submitted successfully! Please wait for admin approval.');
    }
}