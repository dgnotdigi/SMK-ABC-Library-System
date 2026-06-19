<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Hold;
use App\Models\User;
use Illuminate\Database\Seeder;

class HoldSeeder extends Seeder
{
    public function run(): void
    {
        if (Hold::count() > 0) {
            $this->command->info('Holds already exist, skipping.');

            return;
        }

        $studentIds = User::where('role', 'student')->pluck('id')->all();
        $unavailableBookIds = Book::where('available_copies', 0)->limit(10)->pluck('id')->all();

        $made = 0;

        foreach ($unavailableBookIds as $bookId) {
            Hold::create([
                'book_id' => $bookId,
                'user_id' => $studentIds[array_rand($studentIds)],
                'status' => 'waiting',
            ]);
            $made++;
        }

        $this->command->info("Sample holds seeded: {$made}");
    }
}
