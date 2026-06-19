<?php

namespace App\Livewire;

use App\Exceptions\CirculationException;
use App\Models\Book;
use App\Services\CirculationService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BookDetail extends Component
{
    public Book $book;

    public ?string $errorMessage = null;

    public ?string $successMessage = null;

    public function mount(Book $book): void
    {
        $this->book = $book;
    }

    public function checkout(): void
    {
        $this->resetMessages();

        try {
            $checkout = app(CirculationService::class)->checkout($this->book, Auth::user());
            $this->successMessage = 'Checked out! Due back '.$checkout->due_at->format('M j, Y').'.';
            $this->book->refresh();
        } catch (CirculationException $e) {
            $this->errorMessage = $e->getMessage();
        }
    }

    public function placeHold(): void
    {
        $this->resetMessages();

        try {
            app(CirculationService::class)->placeHold($this->book, Auth::user());
            $this->successMessage = "Hold placed. You'll be notified when it's ready.";
        } catch (CirculationException $e) {
            $this->errorMessage = $e->getMessage();
        }
    }

    protected function resetMessages(): void
    {
        $this->errorMessage = null;
        $this->successMessage = null;
    }

    public function render()
    {
        return view('livewire.book-detail', [
            'activeHoldsCount' => $this->book->waitingHolds()->count(),
            'nextDue' => $this->book->nextDueDate(),
        ]);
    }
}
