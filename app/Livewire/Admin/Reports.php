<?php

namespace App\Livewire\Admin;

use App\Models\Checkout;
use App\Services\CirculationService;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Reports extends Component
{
    public function render()
    {
        $fineCentsPerDay = app(CirculationService::class)->fineCentsPerDay();

        $overdue = Checkout::whereNull('returned_at')
            ->where('due_at', '<', now())
            ->with(['book', 'user'])
            ->orderBy('due_at')
            ->get()
            ->map(function (Checkout $checkout) use ($fineCentsPerDay) {
                $daysOverdue = $checkout->daysOverdue();

                return [
                    'title' => $checkout->book->title,
                    'full_name' => $checkout->user->full_name,
                    'grade' => $checkout->user->grade,
                    'due_at' => $checkout->due_at,
                    'daysOverdue' => $daysOverdue,
                    'estimatedFineCents' => $daysOverdue * $fineCentsPerDay,
                ];
            });

        $mostBorrowed = DB::table('checkouts')
            ->join('books', 'books.id', '=', 'checkouts.book_id')
            ->selectRaw('books.title, books.author, books.genre, COUNT(checkouts.id) as borrow_count')
            ->groupBy('books.id', 'books.title', 'books.author', 'books.genre')
            ->orderByDesc('borrow_count')
            ->limit(25)
            ->get();

        $inventory = DB::table('books')
            ->selectRaw('genre, COUNT(*) as titles, SUM(total_copies) as total_copies, SUM(available_copies) as available_copies')
            ->groupBy('genre')
            ->orderByDesc('titles')
            ->get();

        return view('livewire.admin.reports', [
            'overdue' => $overdue,
            'mostBorrowed' => $mostBorrowed,
            'inventory' => $inventory,
        ]);
    }
}
