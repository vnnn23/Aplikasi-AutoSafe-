<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function proseslogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $admin = Admin::where('email', $credentials['email'])
            ->where('role', 'admin')
            ->first();

        if ($admin && Hash::check($credentials['password'], $admin->password)) {
            Auth::login($admin);
            $request->session()->regenerate();
            // Redirect ke admindashboard
            return redirect()->route('admindashboard');
        }

        // Jika gagal, kirim error ke session
        return back()->with('admin_error', 'Email atau password admin salah.');
    }

    public function showRegisterAdmin()
    {
        return view('auth.register-admin-secret');
    }

    public function prosesRegisterAdmin(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:datauser,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $admin = \App\Models\Admin::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'admin',
        ]);

        Auth::login($admin);

        return redirect()->route('admindashboard')->with('success', 'Admin berhasil didaftarkan!');
    }

    public function exportPdf()
    {
        $datapesanan = \App\Models\Pesanan::all();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.pesanan', compact('datapesanan'));
        return $pdf->download('data-pesanan.pdf');
    }
}