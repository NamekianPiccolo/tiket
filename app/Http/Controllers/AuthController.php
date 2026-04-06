<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Register Customer
    public function showRegisterForm()
    {
        return view('auth.register');
    }
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'customer'
        ]);
        return redirect()->route('login')->with('success', 'Registration successful! Please login.');
    }

    // Login untuk semua user
    public function showLoginForm(Request $request)
    {
        // Simpan return_url ke session jika ada
        if ($request->has('return_url')) {
            session(['return_url' => $request->input('return_url')]);
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'name' => 'required|string',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Cek jika ada return_url di session
            if (session()->has('return_url')) {
                $returnUrl = session('return_url');
                session()->forget('return_url'); // Hapus dari session setelah digunakan
                return redirect($returnUrl);
            }

            // Redirect berdasarkan role
            if (auth()->user()->isAdmin()) {
                return redirect('/tikets');
            }

            return redirect('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
