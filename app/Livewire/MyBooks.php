<?php

namespace App\Livewire;

use App\Exceptions\CirculationException;
use App\Models\Checkout;
use App\Services\CirculationService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MyBooks extends Component
{
    /** @var array<int, string> */
    public array $messages = [];

    /** @var array<int, string> */
    public array $errors2 = [];

    public function renew(int $checkoutId): void
    {
        $checkout = Checkout::findOrFail($checkoutId);

        try {
            $updated = app(CirculationService::class)->renew($checkout, Auth::user());
            $this->messages[$checkoutId] = 'Renewed! New due date '.$updated->due_at->format('M j, Y').'.';
            unset($this->errors2[$checkoutId]);
        } catch (CirculationException $e) {
            $this->errors2[$checkoutId] = $e->getMessage();
            unset($this->messages[$checkoutId]);
        }
    }

    public function returnBook(int $checkoutId): void
    {
        $checkout = Checkout::findOrFail($checkoutId);

        try {
            $returned = app(CirculationService::class)->returnBook($checkout, Auth::user());
            $fineNote = $returned->fine_cents > 0
                ? ' A late fee of $'.number_format($returned->fine_cents / 100, 2).' applies.'
                : '';
            $this->messages[$checkoutId] = 'Returned successfully.'.$fineNote;
            unset($this->errors2[$checkoutId]);
        } catch (CirculationException $e) {
            $this->errors2[$checkoutId] = $e->getMessage();
        }
    }

    public function render()
    {
        $user = Auth::user();

        $checkouts = $user->checkouts()
            ->whereNull('returned_at')
            ->with('book')
            ->orderBy('due_at')
            ->get();

        $history = $user->checkouts()
            ->whereNotNull('returned_at')
            ->with('book')
            ->orderByDesc('returned_at')
            ->limit(25)
            ->get();

        return view('livewire.my-books', [
            'checkouts' => $checkouts,
            'history' => $history,
        ])->layout('components.layouts.app', ['title' => 'My Books — SMK ABC Library']);
    }
}
