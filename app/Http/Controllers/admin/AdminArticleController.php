<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Mail\ArticleRejected;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Facades\Log;

class AdminArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::with(['user', 'category']);

        // Full-text Search (title + user name)
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhereHas('user', function ($q2) use ($request) {
                        $q2->where('firstName', 'like', '%' . $request->search . '%')
                            ->orWhere('lastName', 'like', '%' . $request->search . '%');
                    });
            });
        }

        // Filter by category
        if ($request->filled('category') && $request->category !== 'All') {
            $query->where('category_id', $request->category);
        }

        // Filter by status
        if ($request->filled('status') && in_array($request->status, ['under_review', 'published', 'draft'])) {
            $query->where('status', $request->status);
        }

        // Sorting
        if ($request->filled('sort')) {
            match ($request->sort) {
                'oldest' => $query->orderBy('published_at', 'asc'),
                'title' => $query->orderBy('title', 'asc'),
                default => $query->orderBy('published_at', 'desc'),
            };
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $articles = $query->paginate(6)->appends($request->all()); // preserve query in pagination links
        $categories = Category::all();

        return view('manage_articles', compact('articles', 'categories'));
    }


    /**
     * Approve an article
     */
    public function approve($id)
    {
        $article = Article::findOrFail($id);
        $article->update([
            'status' => 'published',
            'published_at' => now(),
        ]);

        activity('admin')
            ->causedBy(Auth::guard('admin')->user())
            ->performedOn($article)
            ->withProperties([
                'title' => $article->title,
                'article_id' => $article->id,
                'status' => 'published'
            ])
            ->log('Approved an article');
        return redirect()->back()->with('success', 'Article approved successfully!');
    }

    /**
     * Reject an article
     */
    public function reject($id)
    {
        $article = Article::with('user')->findOrFail($id);
        $article->update(['status' => 'draft']);

        // Notify user by email
        if ($article->user) {
            Mail::to($article->user->email)->send(new ArticleRejected($article));
        }
        // Log the rejection
        activity('admin')
            ->causedBy(Auth::guard('admin')->user())
            ->performedOn($article)
            ->withProperties([
                'title' => $article->title,
                'article_id' => $article->id,
                'status' => 'rejected (set to draft)',
                'notified_user' => $article->user->email ?? 'N/A',
            ])
            ->log('Rejected an article');

        return redirect()->back()->with('success', 'Article rejected and author notified.');
    }

    /**
     * View all articles with statuses
     */
    public function statusedArticles()
    {
        $articles = Article::with('user')
            ->whereIn('status', ['published', 'draft', 'Under_Review'])
            ->orderBy('updated_at', 'desc')
            ->paginate(10);
        activity('admin')
            ->causedBy(Auth::guard('admin')->user())
            ->log('Viewed statused articles list');

        return view('admin.statused_articles', compact('articles'));
    }

    public function show($id)
    {
        $article = Article::with(['user', 'category'])->findOrFail($id);
        return view('articles_show', compact('article'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'image' => 'nullable|image|max:2048', // validate image file
            // other validations...
        ]);

        $article = new Article();
        $article->title = $request->title;
        $article->body = $request->body;
        $article->user_id = Auth::id(); // or whichever user id you want to assign
        // other fields...

        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('articles', 'public');
            $article->attributes['image_url'] = $path;
        }

        $article->save();

        return redirect()->route('admin.articles.index')->with('success', 'Article created successfully!');
    }
    public function allArticles()
    {
        $articles = \App\Models\Article::latest()->paginate(20);
        return view('user.all_articles', compact('articles'));
    }

    public function pendingReview()
    {
        $articles = \App\Models\Article::where('status', 'Under_Review')->latest()->paginate(20);
        return view('user.articles_pending', compact('articles'));
    }
}
