<x-app-layout :title="$book->title . ' — SMK ABC Library'">
    <a href="{{ route('catalog.index') }}" class="btn btn-outline btn-sm" style="margin-bottom: 18px; display: inline-flex;">&larr; Back to catalog</a>

    <div class="panel">
        <div style="display:flex; gap:24px; flex-wrap:wrap;">
            <div class="book-spine" style="background: {{ $book->cover_color }}; width:140px; height:190px; flex-shrink:0; border-radius:6px; flex-direction:column; align-items:flex-start; justify-content:flex-end; padding:16px;">
                <span class="call-no" style="font-size:13px;">{{ $book->call_number }}</span>
            </div>

            <div style="flex:1; min-width:240px;">
                <h2 style="font-size:24px; margin-bottom:4px;">{{ $book->title }}</h2>
                <p class="muted" style="font-size:16px; margin-bottom:14px;">by {{ $book->author }}</p>

                <div style="display:flex; gap:8px; flex-wrap:wrap; margin-bottom:16px;">
                    <span class="tag">{{ $book->genre ?? 'General' }}</span>
                    @if ($book->isAvailable())
                        <span class="tag available">{{ $book->available_copies }} of {{ $book->total_copies }} available</span>
                    @else
                        <span class="tag unavailable">All copies checked out</span>
                    @endif
                    @if ($activeHoldsCount > 0)
                        <span class="tag">{{ $activeHoldsCount }} on hold</span>
                    @endif
                </div>

                @if ($book->description)
                    <p>{{ $book->description }}</p>
                @endif

                <div class="table-wrap" style="margin:16px 0;">
                    <table class="data-table">
                        <tr><td>ISBN</td><td class="mono">{{ $book->isbn ?? '—' }}</td></tr>
                        <tr><td>Publisher</td><td>{{ $book->publisher ?? '—' }}</td></tr>
                        <tr><td>Published</td><td>{{ $book->published_year ?? '—' }}</td></tr>
                        @if (! $book->isAvailable() && $nextDue)
                            <tr><td>Next copy due back</td><td>{{ \Carbon\Carbon::parse($nextDue)->format('M j, Y') }}</td></tr>
                        @endif
                    </table>
                </div>

                @if ($errorMessage)
                    <div class="error-banner">{{ $errorMessage }}</div>
                @endif
                @if ($successMessage)
                    <div class="success-banner">{{ $successMessage }}</div>
                @endif

                @if ($book->isAvailable())
                    <button wire:click="checkout" class="btn btn-accent">Check out this book</button>
                @else
                    <button wire:click="placeHold" class="btn btn-outline">Place a hold</button>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
