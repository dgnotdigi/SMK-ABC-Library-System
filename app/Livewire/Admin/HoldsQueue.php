<?php

namespace App\Livewire\Admin;

use App\Models\Hold;
use Livewire\Component;

class HoldsQueue extends Component
{
    public function render()
    {
        $holds = Hold::whereIn('status', ['waiting', 'ready'])
            ->with(['book', 'user'])
            ->orderBy('requested_at')
            ->get();

        return view('livewire.admin.holds-queue', ['holds' => $holds]);
    }
}
