<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Checkout extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'user_id',
        'checked_out_at',
        'due_at',
        'returned_at',
        'fine_cents',
        'fine_paid',
    ];

    protected function casts(): array
    {
        return [
            'checked_out_at' => 'datetime',
            'due_at' => 'datetime',
            'returned_at' => 'datetime',
            'fine_cents' => 'integer',
            'fine_paid' => 'boolean',
        ];
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isOverdue(): bool
    {
        return $this->returned_at === null && $this->due_at->isPast();
    }

    public function daysOverdue(): int
    {
        if (! $this->isOverdue()) {
            return 0;
        }

        return (int) $this->due_at->diffInDays(Carbon::now());
    }

    /**
     * Fine owed if returned right now (or, if already returned, the fine that was charged).
     */
    public function estimatedFineCents(int $centsPerDay): int
    {
        if ($this->returned_at !== null) {
            return $this->fine_cents;
        }

        return $this->daysOverdue() * $centsPerDay;
    }
}
