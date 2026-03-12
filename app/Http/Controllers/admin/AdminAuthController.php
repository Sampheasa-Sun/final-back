<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\AdminLog;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('admin.sign_up');
    }

    public function register(Request $request)
    {
        $request->validate([
            'firstName' => 'required|string|max:50',
            'lastName'  => 'required|string|max:50',
            'email'     => 'required|email|unique:admins,email',
            'password'  => 'required|confirmed|min:8',
        ]);

        Admin::create([
            'firstName'     => $request->firstName,
            'lastName'      => $request->lastName,
            'email'         => $request->email,
            'password_hash' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.login')->with('success', 'Admin registered successfully! Please log in.');
    }

    public function showLoginForm()
    {
        return view('admin.log_in');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin || !Hash::check($request->password, $admin->password_hash)) {
            return back()->with('error', 'Invalid email or password.')->withInput();
        }

        Auth::guard('admin')->login($admin);

        // ✅ Log login
        AdminLog::create([
            'admin_id'    => $admin->id,
            'action'      => 'login',
            'target_type' => 'admin',
            'target_id'   => $admin->id,
        ]);

        return redirect()->route('dashboard')->with('success', 'Welcome back! You have been logged in successfully.');
    }

    public function logout(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        // ✅ Log logout
        if ($admin) {
            AdminLog::create([
                'admin_id'    => $admin->id,
                'action'      => 'logout',
                'target_type' => 'admin',
                'target_id'   => $admin->id,
            ]);
        }

        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'You have been logged out successfully.');
    }

    // Optional helper methods
    public function checkAuth()
    {
        return Auth::guard('admin')->check();
    }

    public function getCurrentAdmin()
    {
        return Auth::guard('admin')->user();
    }
}
