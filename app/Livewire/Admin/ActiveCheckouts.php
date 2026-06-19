<?php

namespace App\Livewire\Admin;

use App\Exceptions\CirculationException;
use App\Models\Checkout;
use App\Services\CirculationService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ActiveCheckouts extends Component
{
    public ?string $errorMessage = null;

    public function markReturned(int $checkoutId): void
    {
        $this->errorMessage = null;
        $checkout = Checkout::findOrFail($checkoutId);

        try {
            app(CirculationService::class)->returnBook($checkout, Auth::user());
        } catch (CirculationException $e) {
            $this->errorMessage = $e->getMessage();
        }
    }

    public function render()
    {
        $checkouts = Checkout::whereNull('returned_at')
            ->with(['book', 'user'])
            ->orderBy('due_at')
            ->get();

        return view('livewire.admin.active-checkouts', ['checkouts' => $checkouts]);
    }
}
