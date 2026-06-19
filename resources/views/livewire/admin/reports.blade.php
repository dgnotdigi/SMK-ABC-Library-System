<div>
    <div class="page-header">
        <h1>Reports</h1>
        <p>Overdue items, popular titles, and inventory by genre</p>
    </div>

    <div class="panel">
        <h2>Overdue Books ({{ $overdue->count() }})</h2>
        @if ($overdue->isEmpty())
            <p class="muted">Nothing overdue right now.</p>
        @else
            <div class="table-wrap">
                <table class="data-table">
                    <tr>
                        <th>Title</th><th>Borrower</th><th>Grade</th><th>Due</th><th>Days Late</th><th>Est. Fine</th>
                    </tr>
                    @foreach ($overdue as $row)
                        <tr>
                            <td>{{ $row['title'] }}</td>
                            <td>{{ $row['full_name'] }}</td>
                            <td>{{ $row['grade'] ?? '—' }}</td>
                            <td class="mono">{{ $row['due_at']->format('M j, Y') }}</td>
                            <td><span class="tag unavailable">{{ $row['daysOverdue'] }}d</span></td>
                            <td class="mono">${{ number_format($row['estimatedFineCents'] / 100, 2) }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @endif
    </div>

    <div class="panel">
        <h2>Most Borrowed Books</h2>
        <div class="table-wrap">
            <table class="data-table">
                <tr><th>Title</th><th>Author</th><th>Genre</th><th>Times Borrowed</th></tr>
                @foreach ($mostBorrowed as $row)
                    <tr>
                        <td>{{ $row->title }}</td>
                        <td>{{ $row->author }}</td>
                        <td>{{ $row->genre ?? '—' }}</td>
                        <td><strong>{{ $row->borrow_count }}</strong></td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

    <div class="panel">
        <h2>Inventory by Genre</h2>
        <div class="table-wrap">
            <table class="data-table">
                <tr><th>Genre</th><th>Titles</th><th>Total Copies</th><th>Available Now</th></tr>
                @foreach ($inventory as $row)
                    <tr>
                        <td>{{ $row->genre ?? 'Uncategorized' }}</td>
                        <td>{{ $row->titles }}</td>
                        <td>{{ $row->total_copies }}</td>
                        <td>{{ $row->available_copies }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
