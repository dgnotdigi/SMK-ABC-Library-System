<div>
    <div class="page-header">
        <h1>Active Checkouts</h1>
        <p>Every book currently out, sorted by due date</p>
    </div>

    @if ($errorMessage)
        <div class="error-banner">{{ $errorMessage }}</div>
    @endif

    @if ($checkouts->isEmpty())
        <div class="empty-state">
            <h3>Nothing checked out right now</h3>
        </div>
    @else
        <div class="panel">
            <div class="table-wrap">
                <table class="data-table">
                    <tr>
                        <th>Title</th><th>Author</th><th>Borrower</th><th>Due</th><th>Status</th><th></th>
                    </tr>
                    @foreach ($checkouts as $checkout)
                        @php($isOverdue = $checkout->isOverdue())
                        <tr wire:key="admin-checkout-{{ $checkout->id }}">
                            <td>{{ $checkout->book->title }}</td>
                            <td>{{ $checkout->book->author }}</td>
                            <td>{{ $checkout->user->full_name }}</td>
                            <td class="mono">{{ $checkout->due_at->format('M j, Y') }}</td>
                            <td>
                                @if ($isOverdue)
                                    <span class="tag unavailable">Overdue</span>
                                @else
                                    <span class="tag available">On time</span>
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-outline btn-sm"
                                    @click="$dispatch('confirm-action', {
                                        title: 'Mark as Returned',
                                        message: @js('Mark "'.$checkout->book->title.'" as returned by '.$checkout->user->full_name.'?'),
                                        id: $wire.$id,
                                        method: 'markReturned',
                                        params: [{{ $checkout->id }}]
                                    })">Mark returned</button>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    @endif
</div>
