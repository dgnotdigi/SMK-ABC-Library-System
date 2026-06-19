<?php

namespace App\Livewire;

use App\Models\Book;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Catalog extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    #[Url]
    public string $genre = '';

    #[Url]
    public string $availability = '';

    #[Url]
    public string $sort = 'title';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedGenre(): void
    {
        $this->resetPage();
    }

    public function updatedAvailability(): void
    {
        $this->resetPage();
    }

    public function genres()
    {
        return Book::query()
            ->whereNotNull('genre')
            ->distinct()
            ->orderBy('genre')
            ->pluck('genre');
    }

    public function render()
    {
        $query = Book::query();

        if (trim($this->search) !== '') {
            $term = '%'.trim($this->search).'%';
            $query->where(function ($q) use ($term) {
                $q->where('title', 'like', $term)
                    ->orWhere('author', 'like', $term)
                    ->orWhere('isbn', 'like', $term)
                    ->orWhere('call_number', 'like', $term);
            });
        }

        if ($this->genre !== '') {
            $query->where('genre', $this->genre);
        }

        if ($this->availability === 'available') {
            $query->where('available_copies', '>', 0);
        } elseif ($this->availability === 'unavailable') {
            $query->where('available_copies', '=', 0);
        }

        match ($this->sort) {
            'author' => $query->orderBy('author'),
            'newest' => $query->orderByDesc('published_year'),
            'oldest' => $query->orderBy('published_year'),
            default => $query->orderBy('title'),
        };

        $books = $query->paginate(24);

        return view('livewire.catalog', [
            'books' => $books,
            'genreOptions' => $this->genres(),
        ]);
    }
}
