<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    protected array $genres = [
        'Fiction', 'Science Fiction', 'Fantasy', 'Mystery', 'Biography',
        'History', 'Science', 'Mathematics', 'Poetry', 'Drama',
        'Graphic Novel', 'Reference', 'Young Adult', 'Classics', 'Non-Fiction',
    ];

    protected array $adjectives = ['Hidden', 'Last', 'Silent', 'Golden', 'Broken', 'Distant', 'Forgotten', 'Quiet', 'Lost', 'Endless',
        'Crimson', 'Northern', 'Secret', 'Ancient', 'Wandering', 'Restless', 'Bright', 'Shattered', 'Wild', 'Modern'];

    protected array $nouns = ['River', 'Garden', 'Kingdom', 'Mirror', 'Storm', 'Library', 'Forest', 'Bridge', 'Journey', 'Letter',
        'Clock', 'Harbor', 'Orchard', 'Signal', 'Lantern', 'Compass', 'Empire', 'Code', 'Tide', 'Map'];

    protected array $suffixes = ['', ' of Time', ' Reborn', ': A Memoir', '’s Legacy', ' and the Long Road', ' Rising', ' Untold', ' Chronicles', ''];

    protected array $firstNames = ['Maria', 'James', 'Wei', 'Aisha', 'Carlos', 'Yuki', 'Emma', 'David', 'Fatima', 'Liam',
        'Sofia', 'Noah', 'Priya', 'Lucas', 'Amara', 'Daniel', 'Mei', 'Omar', 'Grace', 'Ravi'];

    protected array $lastNames = ['Tan', 'Garcia', 'Chen', 'Khan', 'Nguyen', 'Smith', 'Patel', 'Kim', 'Silva', 'Brown',
        'Lim', 'Rahman', 'Ibrahim', 'Lopez', 'Wong', 'Adeyemi', 'Costa', 'Hassan', 'Park', 'Murphy'];

    protected array $publishers = ['Riverstone Press', 'Northgate Books', 'Aldwych & Sons', 'Pinegrove Publishing', 'Harbor House', 'Compass Books'];

    protected array $colors = ['#1B3A2E', '#C1622D', '#5A4632', '#2F4858', '#7A6240', '#3B5249', '#8C3B2E'];

    protected array $callPrefixes = [
        'Fiction' => 'FIC', 'Science Fiction' => 'SF', 'Fantasy' => 'FAN', 'Mystery' => 'MYS',
        'Biography' => 'BIO', 'History' => '900', 'Science' => '500', 'Mathematics' => '510',
        'Poetry' => '811', 'Drama' => '812', 'Graphic Novel' => 'GN', 'Reference' => 'REF',
        'Young Adult' => 'YA', 'Classics' => 'CLA', 'Non-Fiction' => '000',
    ];

    public function run(): void
    {
        if (Book::count() > 0) {
            $this->command->info('Books already exist, skipping.');

            return;
        }

        $this->command->info('Seeding books (this may take a moment)...');

        $target = 5200;
        $created = 0;
        $usedTitles = [];
        $genreIndex = [];
        $batch = [];
        $batchSize = 500;
        $now = now();

        while ($created < $target) {
            $genre = $this->genres[array_rand($this->genres)];
            $title = $this->adjectives[array_rand($this->adjectives)].' '.$this->nouns[array_rand($this->nouns)].$this->suffixes[array_rand($this->suffixes)];
            $key = $title.'|'.$genre;

            if (isset($usedTitles[$key])) {
                continue;
            }
            $usedTitles[$key] = true;

            $genreIndex[$genre] = ($genreIndex[$genre] ?? 0) + 1;
            $author = $this->firstNames[array_rand($this->firstNames)].' '.$this->lastNames[array_rand($this->lastNames)];
            $callNumber = ($this->callPrefixes[$genre] ?? 'GEN').'-'.str_pad((string) $genreIndex[$genre], 4, '0', STR_PAD_LEFT);
            $year = random_int(1955, 2025);
            $totalCopies = random_int(1, 5);

            $batch[] = [
                'isbn' => $this->makeIsbn(),
                'title' => $title,
                'author' => $author,
                'genre' => $genre,
                'call_number' => $callNumber,
                'publisher' => $this->publishers[array_rand($this->publishers)],
                'published_year' => $year,
                'description' => "A {$this->lowercase($genre)} book exploring themes connected to \"{$title}\".",
                'cover_color' => $this->colors[array_rand($this->colors)],
                'total_copies' => $totalCopies,
                'available_copies' => $totalCopies,
                'created_at' => $now,
                'updated_at' => $now,
            ];

            $created++;

            if (count($batch) >= $batchSize) {
                DB::table('books')->insert($batch);
                $batch = [];
                $this->command->info("  {$created}/{$target} books...");
            }
        }

        if (! empty($batch)) {
            DB::table('books')->insert($batch);
        }

        $this->command->info("Books seeded: {$created}");
    }

    protected function makeIsbn(): string
    {
        $isbn = '978';
        for ($i = 0; $i < 10; $i++) {
            $isbn .= random_int(0, 9);
        }

        return $isbn;
    }

    protected function lowercase(string $value): string
    {
        return mb_strtolower($value);
    }
}
