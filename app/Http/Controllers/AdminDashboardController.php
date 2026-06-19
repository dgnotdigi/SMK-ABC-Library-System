<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Checkout;
use App\Models\Hold;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totals = Book::query()->selectRaw('COUNT(*) as titles, SUM(total_copies) as copies')->first();

        $summary = [
            'totalTitles' => $totals->titles ?? 0,
            'totalCopies' => $totals->copies ?? 0,
            'totalStudents' => User::where('role', 'student')->count(),
            'activeCheckouts' => Checkout::whereNull('returned_at')->count(),
            'overdueCount' => Checkout::whereNull('returned_at')->where('due_at', '<', now())->count(),
            'waitingHolds' => Hold::whereIn('status', ['waiting', 'ready'])->count(),
        ];

        return view('admin.dashboard', ['summary' => $summary]);
    }
}
