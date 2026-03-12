<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\User;
use Spatie\Activitylog\Models\Activity;


class dashboardController extends Controller
{
    public function index()
    {
        $totalArticles = Article::count();

        // Correct enum value here
        $pendingReview = Article::where('status', 'Under_Review')->count();

        $articleStats = Article::selectRaw("status, COUNT(*) as count")
            ->groupBy('status')
            ->pluck('count', 'status');

        $userStats = User::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as count")
            ->where('created_at', '>=', now()->subMonths(5)->startOfMonth())
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month');

        $articles = Article::where('status', 'Under_Review')
            ->with('user')  // make sure this relation exists
            ->latest()
            ->take(5)
            ->get();
        $recentActivities = Activity::latest()->take(10)->get();

        $newUsersThisMonth = User::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        return view('admin_dashboard', compact(
            'totalArticles',
            'pendingReview',
            'articleStats',
            'userStats',
            'articles',
            'recentActivities',
            'newUsersThisMonth' // ← new
        ));
    }
}
