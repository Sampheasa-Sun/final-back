<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminSettingController extends Controller
{
    public function show()
    {
        return view('admin_setting');
    }

    public function update(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        if (!$admin) {
            return redirect()->route('admin.login')->with('error', 'Please login first.');
        }
        if (!($admin instanceof \App\Models\Admin)) {
            dd('Admin instance not found', get_class($admin));
        }
        $request->validate([
            'firstName' => 'required|string|max:100',
            'lastName' => 'required|string|max:100',
            'email' => 'required|email|unique:admins,email,' . $admin->id,
            'password' => 'nullable|confirmed|min:6',
            'current_password' => 'required',
            'photo' => 'nullable|image|max:2048',  // Max 2MB image
        ]);

        // Verify current password
        if (!Hash::check($request->current_password, $admin->password_hash)) {
            return back()->with('error', 'Current password is incorrect.');
        }

        // If new photo uploaded
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($admin->photo) {
                Storage::disk('public')->delete($admin->photo);
            }

            // Store new photo and update path
            $photoPath = $request->file('photo')->store('admin_photos', 'public');
            $admin->photo = $photoPath;
        }

        // Update other fields
        $admin->firstName = $request->firstName;
        $admin->lastName = $request->lastName;
        $admin->email = $request->email;

        if ($request->filled('password')) {
            $admin->password_hash = Hash::make($request->password);
        }

        $admin->save();

        return redirect()->route('admin.settings')->with('success', 'Settings updated successfully.');
    }
}
