<div>
    <div class="page-header">
        <h1>My Holds</h1>
        <p>Books you&rsquo;re waiting on</p>
    </div>

    @if ($errorMessage)
        <div class="error-banner">{{ $errorMessage }}</div>
    @endif

    @if ($holds->isEmpty())
        <div class="empty-state">
            <div class="icon">&#9873;</div>
            <h3>No active holds</h3>
            <p>Place a hold from any book&rsquo;s page when all copies are checked out.</p>
        </div>
    @else
        <div class="book-grid">
            @foreach ($holds as $hold)
                <div class="book-card" wire:key="hold-{{ $hold->id }}">
                    <div class="book-spine" style="background: {{ $hold->book->cover_color }};"></div>
                    <div class="book-card-body">
                        <p class="title">{{ $hold->book->title }}</p>
                        <p class="author">{{ $hold->book->author }}</p>
                        @if ($hold->status === 'ready')
                            <span class="tag available">Ready for pickup!</span>
                        @else
                            <span class="tag">Waiting in queue</span>
                        @endif
                        <button type="button" class="btn btn-outline btn-sm" style="margin-top:12px;"
                            @click="$dispatch('confirm-action', {
                                title: 'Cancel Hold',
                                message: @js('Cancel your hold on "'.$hold->book->title.'"? You will lose your place in the queue.'),
                                id: $wire.$id,
                                method: 'cancel',
                                params: [{{ $hold->id }}]
                            })">Cancel hold</button>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
