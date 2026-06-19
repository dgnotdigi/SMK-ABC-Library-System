<div>
    <div class="page-header">
        <h1>My Books</h1>
        <p>Items currently checked out to you</p>
    </div>

    @if ($checkouts->isEmpty())
        <div class="empty-state">
            <div class="icon">&#9495;</div>
            <h3>No books checked out</h3>
            <p>Browse the catalog to find your next read.</p>
        </div>
    @else
        <div class="book-grid">
            @foreach ($checkouts as $checkout)
                @php($isOverdue = $checkout->isOverdue())
                <div class="book-card" wire:key="checkout-{{ $checkout->id }}">
                    <div class="book-spine" style="background: {{ $checkout->book->cover_color }};">
                        <span class="call-no">{{ $checkout->book->call_number }}</span>
                    </div>
                    <div class="book-card-body">
                        <p class="title">{{ $checkout->book->title }}</p>
                        <p class="author">{{ $checkout->book->author }}</p>

                        <div class="stamp-wrap">
                            <div class="stamp {{ $isOverdue ? 'overdue' : '' }}">
                                <span class="stamp-label">{{ $isOverdue ? 'Overdue Since' : 'Due Back' }}</span>
                                <span class="stamp-date">{{ $checkout->due_at->format('M j, Y') }}</span>
                            </div>
                        </div>

                        @if (isset($errors2[$checkout->id]))
                            <div class="error-banner">{{ $errors2[$checkout->id] }}</div>
                        @endif
                        @if (isset($messages[$checkout->id]))
                            <div class="success-banner">{{ $messages[$checkout->id] }}</div>
                        @endif

                        <div style="display:flex; gap:8px; margin-top:12px;">
                            <button type="button" class="btn btn-outline btn-sm"
                                @click="$dispatch('confirm-action', {
                                    title: 'Renew Book',
                                    message: @js('Renew "'.$checkout->book->title.'"? This will extend your loan period.'),
                                    id: $wire.$id,
                                    method: 'renew',
                                    params: [{{ $checkout->id }}]
                                })">Renew</button>
                            <button type="button" class="btn btn-accent btn-sm"
                                @click="$dispatch('confirm-action', {
                                    title: 'Return Book',
                                    message: @js('Return "'.$checkout->book->title.'"?'.($isOverdue ? ' A late fine will be calculated.' : '')),
                                    id: $wire.$id,
                                    method: 'returnBook',
                                    params: [{{ $checkout->id }}]
                                })">Return</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    @if ($history->isNotEmpty())
        <div class="panel" style="margin-top:30px;">
            <h2>Past Returns</h2>
            <div class="table-wrap">
                <table class="data-table">
                    <tr><th>Title</th><th>Author</th><th>Returned</th><th>Fine</th></tr>
                    @foreach ($history as $h)
                        <tr>
                            <td>{{ $h->book->title }}</td>
                            <td>{{ $h->book->author }}</td>
                            <td>{{ $h->returned_at->format('M j, Y') }}</td>
                            <td>{{ $h->fine_cents > 0 ? '$'.number_format($h->fine_cents / 100, 2) : '—' }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    @endif
</div>
