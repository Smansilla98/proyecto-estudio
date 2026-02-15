<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Obtener estadísticas
        $ritmosCount = \App\Models\Ritmo::count();
        $videosCount = \App\Models\Video::count();
        $partiturasCount = \App\Models\Partitura::count();
        $usersCount = \App\Models\User::count();

        return view('dashboard', [
            'user' => $user,
            'ritmosCount' => $ritmosCount,
            'videosCount' => $videosCount,
            'partiturasCount' => $partiturasCount,
            'usersCount' => $usersCount,
        ]);
    }
}

