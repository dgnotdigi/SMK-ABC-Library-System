<div>
    <div class="page-header">
        <h1>Browse the Catalog</h1>
        <p>{{ auth()->user()->isAdmin() ? 'Manage and search' : 'Search' }} the full collection</p>
    </div>

    <div class="toolbar">
        <input
            type="text"
            wire:model.live.debounce.350ms="search"
            placeholder="Search title, author, ISBN, or call number&hellip;"
        />

        <select wire:model.live="genre">
            <option value="">All genres</option>
            @foreach ($genreOptions as $g)
                <option value="{{ $g }}">{{ $g }}</option>
            @endforeach
        </select>

        <select wire:model.live="availability">
            <option value="">All availability</option>
            <option value="available">Available now</option>
            <option value="unavailable">Checked out</option>
        </select>

        <select wire:model.live="sort">
            <option value="title">Sort: Title A&ndash;Z</option>
            <option value="author">Sort: Author A&ndash;Z</option>
            <option value="newest">Sort: Newest first</option>
            <option value="oldest">Sort: Oldest first</option>
        </select>
    </div>

    <div wire:loading.delay class="spinner"></div>

    <div wire:loading.remove.delay>
        @if ($books->total() === 0)
            <div class="empty-state">
                <div class="icon">&#9633;</div>
                <h3>No books found</h3>
                <p>Try a different search term or clear your filters.</p>
            </div>
        @else
            <p class="muted">{{ number_format($books->total()) }} book{{ $books->total() === 1 ? '' : 's' }} found</p>

            <div class="book-grid">
                @foreach ($books as $book)
                    <a href="{{ route('catalog.show', $book) }}" class="book-card" style="display:flex; flex-direction:column;" wire:key="book-{{ $book->id }}">
                        <div class="book-spine" style="background: {{ $book->cover_color }};">
                            <span class="call-no">{{ $book->call_number }}</span>
                        </div>
                        <div class="book-card-body">
                            <p class="title">{{ $book->title }}</p>
                            <p class="author">{{ $book->author }}</p>
                            <div class="meta-row">
                                <span class="tag">{{ $book->genre ?? 'General' }}</span>
                                @if ($book->isAvailable())
                                    <span class="tag available">{{ $book->available_copies }} available</span>
                                @else
                                    <span class="tag unavailable">Checked out</span>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="pagination">
                {{ $books->links() }}
            </div>
        @endif
    </div>
</div>
