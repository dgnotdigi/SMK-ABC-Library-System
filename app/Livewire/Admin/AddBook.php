<?php

namespace App\Livewire\Admin;

use App\Models\Book;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class AddBook extends Component
{
    use WithFileUploads;

    #[Validate('required|string|max:255')]
    public string $title = '';

    #[Validate('required|string|max:255')]
    public string $author = '';

    #[Validate('nullable|string|max:100')]
    public string $genre = '';

    #[Validate('nullable|string|max:20')]
    public string $isbn = '';

    #[Validate('nullable|string|max:30')]
    public string $call_number = '';

    #[Validate('nullable|string|max:255')]
    public string $publisher = '';

    #[Validate('nullable|integer|min:1000|max:2100')]
    public ?int $published_year = null;

    #[Validate('required|integer|min:1')]
    public int $total_copies = 1;

    #[Validate('nullable|string')]
    public string $description = '';

    #[Validate('nullable|image|max:2048')]
    public $coverImage = null;

    public ?string $successMessage = null;

    public function save(): void
    {
        $this->successMessage = null;
        $validated = $this->validate();

        $coverPath = null;
        if ($this->coverImage) {
            $coverPath = $this->coverImage->store('covers', 'public');
        }

        Book::create([
            'title' => $validated['title'],
            'author' => $validated['author'],
            'genre' => $validated['genre'] ?: null,
            'isbn' => $validated['isbn'] ?: null,
            'call_number' => $validated['call_number'] ?: null,
            'publisher' => $validated['publisher'] ?: null,
            'published_year' => $validated['published_year'],
            'description' => $validated['description'] ?: null,
            'total_copies' => $validated['total_copies'],
            'available_copies' => $validated['total_copies'],
            'cover_image' => $coverPath,
        ]);

        $this->successMessage = 'Book added to the catalog.';
        $this->reset(['title', 'author', 'genre', 'isbn', 'call_number', 'publisher', 'published_year', 'description', 'coverImage']);
        $this->total_copies = 1;
    }

    public function render()
    {
        return view('livewire.admin.add-book')->layout('components.layouts.app', ['title' => 'Add a Book — SMK ABC Library']);
    }
}
