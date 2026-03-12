<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Admin;
use App\Mail\UserBannedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        $adminEmails = Admin::pluck('email')->toArray();

        $users->map(function ($user) use ($adminEmails) {
            $user->is_admin = in_array($user->email, $adminEmails);
            return $user;
        });

        $totalUsers = $users->count();
        $activeUsers = $users->where('status', 'active')->count();
        $bannedUsers = $users->where('status', 'banned')->count();
        $adminCount = $users->whereIn('email', $adminEmails)->count();

        return view('manage_user2', compact(
            'users',
            'totalUsers',
            'activeUsers',
            'bannedUsers',
            'adminCount'
        ));
    }

    public function ban(User $user)
    {
        $user->status = 'banned';
        $user->save();

        Mail::to($user->email)->send(new UserBannedMail($user));

        activity('admin')
            ->causedBy(Auth::guard('admin')->user())
            ->performedOn($user)
            ->log('Banned user');

        return redirect()->back()->with('success', 'User has been banned.');
    }

    public function unban(User $user)
    {
        $user->status = 'active';
        $user->save();

        activity('admin')
            ->causedBy(Auth::guard('admin')->user())
            ->performedOn($user)
            ->log('Unbanned user');

        return redirect()->back()->with('success', 'User has been unbanned.');
    }

    public function promote(string $email)
    {
        $user = User::where('email', $email)->firstOrFail();

        if (!Admin::where('email', $email)->exists()) {
            Admin::create([
                'email'         => $user->email,
                'firstName'     => $user->firstName ?? 'Admin',
                'lastName'      => $user->lastName ?? 'User',
                // ✅ COPY the already hashed password from users table
                'password_hash' => $user->password_hash,
            ]);

            activity('admin')
                ->causedBy(Auth::guard('admin')->user())
                ->performedOn($user)
                ->log('Promoted user to admin');
        }

        return back()->with('success', 'User promoted to admin.');
    }

    public function demote(string $email)
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return back()->with('error', 'User not found.');
        }

        Admin::where('email', $email)->delete();

        activity('admin')
            ->causedBy(Auth::guard('admin')->user())
            ->performedOn($user)
            ->log('Demoted user from admin');

        return redirect()->back()->with('success', 'Admin privileges removed.');
    }

    public function editUser(User $user)
    {
        return view('edit_user', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->getKey(), 'user_id'),
            ],
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
                'password_hash' => Hash::make($request->password),
            ]);
        }

        activity('admin')
            ->causedBy(Auth::guard('admin')->user())
            ->performedOn($user)
            ->log('Updated user details');

        return redirect()->route('admin.manage.users')->with('success', 'User updated successfully!');
    }

    /**
     * Show recent activity logs on the dashboard (optional method)
     */
    public function recentActivity()
    {
        $recentActivities = Activity::where('subject_type', User::class)
            ->with('causer', 'subject')
            ->latest()
            ->limit(10)
            ->get();

        return view('admin_dashboard', compact('recentActivities'));
    }

    public function newUsersThisMonth()
    {
        $users = User::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->latest()
            ->paginate(20);

        return view('user.new_this_month', compact('users'));
    }
}
