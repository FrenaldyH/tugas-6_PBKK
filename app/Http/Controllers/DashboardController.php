<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Profile dashboard: show only the projects owned by the logged-in user, newest first.
     * Going through the relation adds "WHERE user_id = ?" with a bound parameter,
     * so the query is scoped to the owner and safe from SQL injection.
     */
    public function __invoke(Request $request): View
    {
        $user = $request->user();

        return view('dashboard', [
            'user' => $user,
            'projects' => $user->projects()->latest()->get(),
        ]);
    }
}
