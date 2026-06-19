<div>
    <div class="page-header">
        <h1>Holds Queue</h1>
        <p>Readers waiting for unavailable titles</p>
    </div>

    @if ($holds->isEmpty())
        <div class="empty-state">
            <h3>No active holds</h3>
        </div>
    @else
        <div class="panel">
            <div class="table-wrap">
                <table class="data-table">
                    <tr>
                        <th>Title</th><th>Author</th><th>Requested by</th><th>Requested on</th><th>Status</th>
                    </tr>
                    @foreach ($holds as $hold)
                        <tr wire:key="admin-hold-{{ $hold->id }}">
                            <td>{{ $hold->book->title }}</td>
                            <td>{{ $hold->book->author }}</td>
                            <td>{{ $hold->user->full_name }}</td>
                            <td class="mono">{{ $hold->requested_at->format('M j, Y') }}</td>
                            <td>
                                @if ($hold->status === 'ready')
                                    <span class="tag available">Ready</span>
                                @else
                                    <span class="tag">Waiting</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    @endif
</div>
