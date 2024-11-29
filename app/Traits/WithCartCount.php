<?php

namespace App\Traits;

trait WithCartCount
{
    public function getCartCountProperty()
    {
        if (!auth()->check()) {
            return 0;
        }
        return array_sum(array_column(session('cart', []), 'quantity'));
    }

    protected function getListeners()
    {
        $parentListeners = method_exists($this, 'parent::getListeners') 
            ? parent::getListeners() 
            : [];
            
        return array_merge($parentListeners, [
            'cart-updated' => '$refresh',
            'notification-updated' => '$refresh'
        ]);
    }

    public function logout()
    {
        auth()->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('login');
    }
} 