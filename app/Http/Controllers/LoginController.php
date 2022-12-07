<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login', [
            'title' => 'Login'
        ]);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            if (in_array($user->role_id, [1, 2])) {
                $request->session()->regenerate();
                return redirect()->intended('admin/dashboard');    

            }

            return back()->with('loginError', 'Login Failed!');        
        }

        return back()->with('loginError', 'Login Failed!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function register()
    {
        $positions = Position::all();
        return view('auth.register', ['positions' => $positions, 'title' => 'Register']);
    }

    public function registerReview(Request $request)
    {
        $credentials = $request->validate([
            'name' => 'required|min:3|max:255',
            'position_id' => 'required|numeric|min:1',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|max:255',
        ]);

        $credentials['password'] = Hash::make($credentials['password']);
        $credentials['role_id'] = 2;

        DB::beginTransaction();
        User::create($credentials);

        /* $array = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($array)) {
            $request->session()->regenerate();
            return redirect()->intended('admin/dashboard');
        } */

        DB::commit();

        return redirect()->route('login')->with('success', 'Register success');
    }
}
