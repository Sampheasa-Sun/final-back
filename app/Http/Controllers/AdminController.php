<?php
// In app/Http/Controllers/AdminController.php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // Your existing methods...

    /**
     * Show the edit user form
     */
    public function editUser(User $user)
    {
        return view('edit_user', compact('user'));
    }

    /**
     * Update the user
     */


    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'status' => 'required|in:active,banned',
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user->update([
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'email' => $request->email,
            'status' => $request->status,
        ]);

        if ($request->filled('password')) {
            $user->update([
                'password_hash' => Hash::make($request->password)
            ]);
        }

        // Log admin activity
        $statusLabel = $user->status === 'banned' ? 'banned' : 'updated';
        activity('admin')
            ->causedBy(Auth::guard('admin')->user())
            ->performedOn($user)
            ->withProperties([
                'user_id' => $user->id,
                'user_name' => $user->firstName . ' ' . $user->lastName,
                'status' => $user->status,
            ])
            ->log("Admin {$statusLabel} a user");

        return redirect()->route('admin.manage.users')->with('success', 'User updated successfully!');
    }
    


    // Your other existing methods...
}
