<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    protected array $firstNames = ['Maria', 'James', 'Wei', 'Aisha', 'Carlos', 'Yuki', 'Emma', 'David', 'Fatima', 'Liam',
        'Sofia', 'Noah', 'Priya', 'Lucas', 'Amara', 'Daniel', 'Mei', 'Omar', 'Grace', 'Ravi'];

    protected array $lastNames = ['Tan', 'Garcia', 'Chen', 'Khan', 'Nguyen', 'Smith', 'Patel', 'Kim', 'Silva', 'Brown',
        'Lim', 'Rahman', 'Ibrahim', 'Lopez', 'Wong', 'Adeyemi', 'Costa', 'Hassan', 'Park', 'Murphy'];

    public function run(): void
    {
        if (User::count() > 0) {
            $this->command->info('Users already exist, skipping.');

            return;
        }

        User::create([
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'full_name' => 'Mrs. Alvarez (Librarian)',
            'role' => 'admin',
        ]);

        User::create([
            'username' => 'libstaff',
            'password' => Hash::make('staff123'),
            'full_name' => 'Mr. Owusu (Library Aide)',
            'role' => 'admin',
        ]);

        for ($i = 1; $i <= 40; $i++) {
            $first = $this->firstNames[array_rand($this->firstNames)];
            $last = $this->lastNames[array_rand($this->lastNames)];

            User::create([
                'username' => "student{$i}",
                'password' => Hash::make('student123'),
                'full_name' => "{$first} {$last}",
                'role' => 'student',
                'grade' => 'Grade '.random_int(6, 12),
            ]);
        }

        $this->command->info('Users seeded: 2 admin/staff + 40 students');
    }
}
