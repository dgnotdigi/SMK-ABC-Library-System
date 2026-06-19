<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    protected array $firstNames = [
        'Ahmad', 'Muhammad', 'Amirul', 'Haziq', 'Izzat', 'Faris', 'Syafiq', 'Irfan', 'Hafiz', 'Azri',
        'Nurul', 'Siti', 'Nur', 'Aina', 'Farah', 'Nadia', 'Aisha', 'Liyana', 'Hanis', 'Sofea',
        'Wei Jie', 'Kai Xian', 'Mei Ling', 'Hui Ling', 'Jun Hao',
        'Arjun', 'Priya', 'Kavitha', 'Rajan', 'Suresh',
    ];

    protected array $lastNames = [
        'bin Abdullah', 'bin Razak', 'bin Hamid', 'bin Yusof', 'bin Ismail',
        'bin Othman', 'bin Zainuddin', 'bin Kamaruddin', 'bin Nordin', 'bin Ghazali',
        'binti Ahmad', 'binti Hassan', 'binti Ibrahim', 'binti Mohd', 'binti Aziz',
        'binti Jalil', 'binti Rahim', 'binti Saad', 'binti Musa', 'binti Idris',
        'Tan', 'Lim', 'Wong', 'Ng', 'Lee',
        'a/l Krishnan', 'a/p Muthu', 'a/l Raju', 'a/p Selvi', 'a/l Kumar',
    ];

    public function run(): void
    {
        if (User::count() > 0) {
            $this->command->info('Users already exist, skipping.');

            return;
        }

        User::create([
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'full_name' => 'Puan Rozita binti Hamdan (Pustakawan)',
            'role' => 'admin',
        ]);

        User::create([
            'username' => 'libstaff',
            'password' => Hash::make('staff123'),
            'full_name' => 'Encik Faizal bin Sulaiman (Pembantu Perpustakaan)',
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
                'grade' => 'Tingkatan '.random_int(1, 5),
            ]);
        }

        $this->command->info('Users seeded: 2 admin/staff + 40 students');
    }
}
