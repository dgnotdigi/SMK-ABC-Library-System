@if ($paginator->hasPages())
    <div class="pagination">
        @if ($paginator->onFirstPage())
            <button class="btn btn-outline btn-sm" disabled>&larr; Prev</button>
        @else
            <button class="btn btn-outline btn-sm" wire:click="previousPage" wire:loading.attr="disabled">&larr; Prev</button>
        @endif

        <span>Page {{ $paginator->currentPage() }} of {{ $paginator->lastPage() }}</span>

        @if ($paginator->hasMorePages())
            <button class="btn btn-outline btn-sm" wire:click="nextPage" wire:loading.attr="disabled">Next &rarr;</button>
        @else
            <button class="btn btn-outline btn-sm" disabled>Next &rarr;</button>
        @endif
    </div>
@endif
