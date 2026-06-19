<div>
    <div class="page-header">
        <h1>Add a Book</h1>
        <p>Add a new title to the catalog</p>
    </div>

    <div class="panel" style="max-width:560px;">
        <form wire:submit="save">
            <div class="field">
                <label for="title">Title *</label>
                <input type="text" id="title" wire:model="title" />
                @error('title') <div class="hint" style="color:var(--red);">{{ $message }}</div> @enderror
            </div>

            <div class="field">
                <label for="author">Author *</label>
                <input type="text" id="author" wire:model="author" />
                @error('author') <div class="hint" style="color:var(--red);">{{ $message }}</div> @enderror
            </div>

            <div class="field">
                <label for="genre">Genre</label>
                <input type="text" id="genre" wire:model="genre" placeholder="e.g. Fiction, Science, History" />
            </div>

            <div class="field">
                <label for="isbn">ISBN</label>
                <input type="text" id="isbn" wire:model="isbn" placeholder="e.g. 9780000000000" />
            </div>

            <div class="field">
                <label for="call_number">Call number</label>
                <input type="text" id="call_number" wire:model="call_number" placeholder="e.g. FIC-0001" />
            </div>

            <div class="field">
                <label for="publisher">Publisher</label>
                <input type="text" id="publisher" wire:model="publisher" />
            </div>

            <div class="field">
                <label for="published_year">Published year</label>
                <input type="number" id="published_year" wire:model="published_year" min="1000" max="2100" />
                @error('published_year') <div class="hint" style="color:var(--red);">{{ $message }}</div> @enderror
            </div>

            <div class="field">
                <label for="total_copies">Number of copies</label>
                <input type="number" id="total_copies" wire:model="total_copies" min="1" />
                @error('total_copies') <div class="hint" style="color:var(--red);">{{ $message }}</div> @enderror
            </div>

            <div class="field">
                <label for="description">Description</label>
                <textarea id="description" rows="3" wire:model="description"></textarea>
            </div>

            <div class="field">
                <label for="coverImage">Cover image</label>
                <input type="file" id="coverImage" wire:model="coverImage" accept="image/*" class="file-input" />
                @error('coverImage') <div class="hint" style="color:var(--red);">{{ $message }}</div> @enderror

                @if ($coverImage)
                    <div style="margin-top:10px;">
                        <img src="{{ $coverImage->temporaryUrl() }}" alt="Cover preview" class="cover-preview" />
                    </div>
                @endif
            </div>

            @if ($successMessage)
                <div class="success-banner">{{ $successMessage }}</div>
            @endif

            <button type="button" class="btn btn-accent"
                @click="$dispatch('confirm-action', {
                    title: 'Add Book',
                    message: 'Add this book to the catalog?',
                    id: $wire.$id,
                    method: 'save',
                    params: []
                })">Add to catalog</button>
        </form>
    </div>
</div>
