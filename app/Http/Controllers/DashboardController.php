<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Profile dashboard: the logged-in user's biodata, assignment history and projects.
     * Every query goes through the user's relations, which add "WHERE user_id = ?" with a bound
     * parameter, so it is scoped to the owner and safe from SQL injection.
     */
    public function __invoke(Request $request): View
    {
        $user = $request->user();

        return view('dashboard', [
            'user' => $user,
            'profile' => $user->profile,
            // Newest submission first; in-progress items (NULL date) sort last.
            'assignments' => $user->assignments()->orderByDesc('dikumpulkan_pada')->latest()->get(),
            'projects' => $user->projects()->latest()->get(),
        ]);
    }
}
