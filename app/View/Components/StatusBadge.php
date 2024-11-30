<?php

namespace App\View\Components;

use Illuminate\View\Component;

class StatusBadge extends Component
{
    public $status;
    public $colors;

    public function __construct($status)
    {
        $this->status = strtolower($status);
        $this->colors = $this->getStatusColors();
    }

    public function getStatusColors()
    {
        return [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'approved' => 'bg-blue-100 text-blue-800',
            'cancelled' => 'bg-red-100 text-red-800',
            'in_stock' => 'bg-green-100 text-green-800',
            'picked_up' => 'bg-purple-100 text-purple-800',
            'completed' => 'bg-green-100 text-green-800',
            'ready_for_pickup' => 'bg-indigo-100 text-indigo-800',
            'stocked_out' => 'bg-gray-100 text-gray-800',
            'default' => 'bg-gray-100 text-gray-800',
        ];
    }

    public function render()
    {
        return view('components.status-badge');
    }
}