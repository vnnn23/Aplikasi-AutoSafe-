<?php

namespace App\Http\Controllers;
use App\Models\Datauser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function prosesregister(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:datauser',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Datauser::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'user', // otomatis user
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Registrasi berhasil!');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function proseslogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('web')->attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
        ])) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        // Set error khusus untuk customer
        return back()->with('customer_error', 'Email atau password salah.');
    }

    public function prosesloginadmin(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $admin = \App\Models\Datauser::where('nama', $credentials['username'])
            ->where('role', 'admin')
            ->first();

        if ($admin && \Illuminate\Support\Facades\Hash::check($credentials['password'], $admin->password)) {
            \Illuminate\Support\Facades\Auth::login($admin);
            $request->session()->regenerate();
            // Redirect ke dashboardadmin
            return redirect()->route('dashboardadmin');
        }

        // Set error khusus untuk admin
        return back()->with('admin_error', 'Username atau password admin salah.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        // Redirect ke landing page
        return redirect('/'); // Pastikan route '/' mengarah ke landingpage.blade.php
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            // Login sukses
            return redirect()->intended('/dashboard');
        } else {
            // Login gagal
            return back()->withErrors(['email' => 'Email atau password salah']);
        }
    }
}
