<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Checkout;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class CheckoutSeeder extends Seeder
{
    public function run(): void
    {
        if (Checkout::count() > 0) {
            $this->command->info('Checkouts already exist, skipping.');

            return;
        }

        $this->command->info('Seeding sample checkouts...');

        $studentIds = User::where('role', 'student')->pluck('id')->all();
        $books = Book::limit(300)->get()->keyBy('id');
        $bookIds = $books->keys()->all();

        $made = 0;

        for ($i = 0; $i < 80; $i++) {
            $bookId = $bookIds[array_rand($bookIds)];
            $book = $books[$bookId];

            if ($book->available_copies <= 0) {
                continue;
            }

            $studentId = $studentIds[array_rand($studentIds)];

            $daysAgo = random_int(1, 20);
            $checkedOutAt = Carbon::now()->subDays($daysAgo);
            $dueAt = $checkedOutAt->copy()->addDays(14);

            Checkout::create([
                'book_id' => $bookId,
                'user_id' => $studentId,
                'checked_out_at' => $checkedOutAt,
                'due_at' => $dueAt,
            ]);

            $book->decrement('available_copies');
            $made++;
        }

        $this->command->info("Sample checkouts seeded: {$made}");
    }
}
