<?php

namespace App\Services;

use App\Exceptions\CirculationException;
use App\Models\Book;
use App\Models\Checkout;
use App\Models\Hold;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CirculationService
{
    public function __construct(
        protected int $loanDays = 14,
        protected int $fineCentsPerDay = 25,
        protected int $maxCheckoutsPerStudent = 5,
    ) {
        $this->loanDays = (int) config('library.loan_days', $loanDays);
        $this->fineCentsPerDay = (int) config('library.fine_cents_per_day', $fineCentsPerDay);
        $this->maxCheckoutsPerStudent = (int) config('library.max_checkouts_per_student', $maxCheckoutsPerStudent);
    }

    public function fineCentsPerDay(): int
    {
        return $this->fineCentsPerDay;
    }

    /**
     * Check out a book to a user (a student checking out for themselves, or
     * an admin checking out on a student's behalf).
     *
     * @throws CirculationException
     */
    public function checkout(Book $book, User $borrower, bool $isAdminActing = false): Checkout
    {
        return DB::transaction(function () use ($book, $borrower, $isAdminActing) {
            // Lock the book row to avoid a race where two requests both see a copy available.
            $book = Book::where('id', $book->id)->lockForUpdate()->first();

            if ($book->available_copies <= 0) {
                throw new CirculationException('No copies available. You can place a hold instead.');
            }

            if (! $isAdminActing) {
                $activeCount = $borrower->activeCheckouts()->count();
                if ($activeCount >= $this->maxCheckoutsPerStudent) {
                    throw new CirculationException(
                        "You've reached the limit of {$this->maxCheckoutsPerStudent} checked-out books."
                    );
                }
            }

            $alreadyHas = Checkout::where('book_id', $book->id)
                ->where('user_id', $borrower->id)
                ->whereNull('returned_at')
                ->exists();

            if ($alreadyHas) {
                throw new CirculationException('This reader already has this book checked out.');
            }

            $now = Carbon::now();

            $checkout = Checkout::create([
                'book_id' => $book->id,
                'user_id' => $borrower->id,
                'checked_out_at' => $now,
                'due_at' => $now->copy()->addDays($this->loanDays),
            ]);

            $book->decrement('available_copies');

            return $checkout;
        });
    }

    /**
     * Return a book. Calculates and stores any late fine. If another reader
     * is waiting on a hold, marks the next hold as "ready".
     *
     * @throws CirculationException
     */
    public function returnBook(Checkout $checkout, User $actor): Checkout
    {
        return DB::transaction(function () use ($checkout, $actor) {
            $checkout = Checkout::where('id', $checkout->id)->lockForUpdate()->first();

            if ($checkout->returned_at !== null) {
                throw new CirculationException('This book was already returned.');
            }

            if (! $actor->isAdmin() && $checkout->user_id !== $actor->id) {
                throw new CirculationException('You can only return your own checkouts.');
            }

            $now = Carbon::now();
            $fine = $this->computeFineCents($checkout->due_at, $now);

            $checkout->update([
                'returned_at' => $now,
                'fine_cents' => $fine,
            ]);

            $book = Book::where('id', $checkout->book_id)->lockForUpdate()->first();
            $book->increment('available_copies');

            $nextHold = Hold::where('book_id', $checkout->book_id)
                ->where('status', 'waiting')
                ->orderBy('requested_at')
                ->first();

            if ($nextHold) {
                $nextHold->update([
                    'status' => 'ready',
                    'notified_at' => $now,
                ]);
            }

            return $checkout->refresh();
        });
    }

    /**
     * Renew a checkout, pushing the due date back \u2014 only allowed if no one
     * else is waiting on a hold for the book.
     *
     * @throws CirculationException
     */
    public function renew(Checkout $checkout, User $actor): Checkout
    {
        if ($checkout->returned_at !== null) {
            throw new CirculationException('This book was already returned.');
        }

        if (! $actor->isAdmin() && $checkout->user_id !== $actor->id) {
            throw new CirculationException('You can only renew your own checkouts.');
        }

        $waitingHold = Hold::where('book_id', $checkout->book_id)
            ->where('status', 'waiting')
            ->exists();

        if ($waitingHold) {
            throw new CirculationException('Cannot renew — another reader is waiting on a hold for this book.');
        }

        $checkout->update([
            'due_at' => Carbon::now()->addDays($this->loanDays),
        ]);

        return $checkout->refresh();
    }

    /**
     * Place a hold for a user on a book that's fully checked out.
     *
     * @throws CirculationException
     */
    public function placeHold(Book $book, User $user): Hold
    {
        if ($book->available_copies > 0) {
            throw new CirculationException('This book is available right now — check it out instead of placing a hold.');
        }

        $existing = Hold::where('book_id', $book->id)
            ->where('user_id', $user->id)
            ->whereIn('status', ['waiting', 'ready'])
            ->exists();

        if ($existing) {
            throw new CirculationException('You already have a hold on this book.');
        }

        return Hold::create([
            'book_id' => $book->id,
            'user_id' => $user->id,
            'status' => 'waiting',
        ]);
    }

    /**
     * Cancel a hold.
     *
     * @throws CirculationException
     */
    public function cancelHold(Hold $hold, User $actor): void
    {
        if (! $actor->isAdmin() && $hold->user_id !== $actor->id) {
            throw new CirculationException('You can only cancel your own holds.');
        }

        $hold->update(['status' => 'cancelled']);
    }

    public function computeFineCents(Carbon $dueAt, Carbon $returnedAt): int
    {
        $lateDays = $dueAt->diffInDays($returnedAt, false);

        if ($lateDays <= 0) {
            return 0;
        }

        return (int) ($lateDays * $this->fineCentsPerDay);
    }
}
