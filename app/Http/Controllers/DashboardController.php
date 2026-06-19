<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __invoke(AdminDashboardController $adminDashboard)
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return $adminDashboard->index();
        }

        return redirect()->route('catalog.index');
    }
}
