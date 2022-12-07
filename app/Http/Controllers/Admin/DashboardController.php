<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $masuk = User::get()->count();
        $keluar = User::get()->count();

        return view('pages.admin.dashboard',[
            'masuk' => $masuk,
            'keluar' => $keluar
        ]);
    }
}
