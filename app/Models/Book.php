<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'isbn',
        'title',
        'author',
        'genre',
        'call_number',
        'publisher',
        'published_year',
        'description',
        'cover_color',
        'total_copies',
        'available_copies',
    ];

    protected function casts(): array
    {
        return [
            'published_year' => 'integer',
            'total_copies' => 'integer',
            'available_copies' => 'integer',
        ];
    }

    public function checkouts(): HasMany
    {
        return $this->hasMany(Checkout::class);
    }

    public function activeCheckouts(): HasMany
    {
        return $this->checkouts()->whereNull('returned_at');
    }

    public function holds(): HasMany
    {
        return $this->hasMany(Hold::class);
    }

    public function waitingHolds(): HasMany
    {
        return $this->holds()->where('status', 'waiting');
    }

    public function isAvailable(): bool
    {
        return $this->available_copies > 0;
    }

    public function nextDueDate(): ?string
    {
        $checkout = $this->activeCheckouts()->orderBy('due_at')->first();

        return $checkout?->due_at;
    }
}
