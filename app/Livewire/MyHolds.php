<?php

namespace App\Livewire;

use App\Exceptions\CirculationException;
use App\Models\Hold;
use App\Services\CirculationService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MyHolds extends Component
{
    public ?string $errorMessage = null;

    public function cancel(int $holdId): void
    {
        $this->errorMessage = null;
        $hold = Hold::findOrFail($holdId);

        try {
            app(CirculationService::class)->cancelHold($hold, Auth::user());
        } catch (CirculationException $e) {
            $this->errorMessage = $e->getMessage();
        }
    }

    public function render()
    {
        $holds = Auth::user()->holds()
            ->whereIn('status', ['waiting', 'ready'])
            ->with('book')
            ->orderBy('requested_at')
            ->get();

        return view('livewire.my-holds', ['holds' => $holds])->layout('components.layouts.app', ['title' => 'My Holds — SMK ABC Library']);
    }
}
