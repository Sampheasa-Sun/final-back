<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Articles</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-30px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        @keyframes shimmer {
            0% { background-position: -200px 0; }
            100% { background-position: calc(200px + 100%) 0; }
        }
        
        .animate-fade-in {
            animation: fadeIn 0.6s ease-out;
        }
        
        .animate-slide-in {
            animation: slideIn 0.5s ease-out;
        }
        
        .article-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(10px);
            position: relative;
            overflow: hidden;
        }
        
        .article-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 16px 32px -4px rgba(0, 0, 0, 0.1), 0 8px 16px -8px rgba(0, 0, 0, 0.1);
        }
        
        .article-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.5s ease;
        }
        
        .article-card:hover::before {
            left: 100%;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .header-gradient {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        }
        
        .article-meta {
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            margin-top: 1rem;
        }
        
        .author-avatar {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            width: 2rem;
            height: 2rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.875rem;
            flex-shrink: 0;
        }
        
        .article-excerpt {
            position: relative;
            overflow: hidden;
        }
        
        .article-excerpt::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 20px;
            background: linear-gradient(transparent, rgba(255, 255, 255, 0.9));
        }
        
        .empty-state {
            background: radial-gradient(circle at center, rgba(148, 163, 184, 0.1) 0%, transparent 70%);
        }
        
        .tag-badge {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            color: #1e40af;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .read-time {
            color: #64748b;
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }
        
        @media (max-width: 640px) {
            .article-card {
                padding: 1rem;
            }
            
            .article-meta {
                padding: 0.5rem 0.75rem;
            }
        }
    </style>
</head>
<body class="gradient-bg min-h-screen">
    <div class="min-h-screen flex flex-col">
        <!-- Enhanced Header -->
        <header class="header-gradient text-white shadow-xl">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
        <div class="animate-slide-in">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-3xl sm:text-4xl font-bold mb-2">All Articles</h1>
                    <p class="text-blue-100 text-sm sm:text-base opacity-90">
                        Discover insights, stories, and knowledge from our community
                    </p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253z"></path>
                        </svg>
                        <span class="text-sm text-blue-100">{{ $articles->total() ?? 'Loading...' }} Articles</span>
                    </div>

                    <!-- Back to Dashboard Button -->
                    <a href="{{ route('dashboard') }}" 
                       class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm px-4 py-2 rounded-lg shadow transition duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>


        <!-- Main Content -->
        <main class="flex-1 container mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
            @forelse ($articles as $index => $article)
                <article class="article-card glass-card rounded-2xl p-5 sm:p-6 mb-6 sm:mb-8 shadow-sm animate-fade-in"
                         style="animation-delay: {{ $index * 0.1 }}s">
                    <!-- Article Header -->
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-4">
                        <div class="flex-1">
                            <h2 class="text-xl sm:text-2xl font-semibold text-slate-800 mb-2 leading-tight hover:text-blue-600 transition-colors cursor-pointer">
                                {{ $article->title }}
                            </h2>
                            
                            <!-- Article Tags (if available) -->
                            @if(isset($article->tags) && $article->tags->count())
                                <div class="flex flex-wrap gap-2 mb-3">
                                    @foreach($article->tags->take(3) as $tag)
                                        <span class="tag-badge">{{ $tag->name }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        
                        <!-- Reading Time Estimate -->
                        <div class="read-time">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>{{ ceil(str_word_count(strip_tags($article->body ?? '')) / 200) }} min read</span>
                        </div>
                    </div>

                    <!-- Article Excerpt -->
                    <div class="article-excerpt mb-4">
                        <p class="text-slate-700 text-sm sm:text-base leading-relaxed">
                            {{ Str::limit(strip_tags($article->body), 120) }}
                        </p>
                    </div>

                    <!-- Article Meta -->
                    <div class="article-meta">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="author-avatar">
                                    {{ substr($article->user->firstName ?? 'U', 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-slate-800">
                                        {{ $article->user->firstName ?? 'Unknown' }}
                                    </p>
                                    <p class="text-xs text-slate-500">
                                        {{ $article->created_at->format('F d, Y') }}
                                    </p>
                                </div>
                            </div>
                            
                            <div class="flex items-center space-x-4">
                                <!-- View Count (if available) -->
                                @if(isset($article->views_count))
                                    <div class="flex items-center space-x-1 text-slate-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        <span class="text-xs">{{ $article->views_count }}</span>
                                    </div>
                                @endif
                                
                                <!-- Comments Count (if available) -->
                                @if(isset($article->comments_count))
                                    <div class="flex items-center space-x-1 text-slate-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                        </svg>
                                        <span class="text-xs">{{ $article->comments_count }}</span>
                                    </div>
                                @endif
                                
                                <!-- Read More Button -->
                                
                               <a href="{{ route('admin.articles.show', $article->id) }}" 
                                class="text-blue-600 hover:text-blue-800 text-sm font-medium transition-colors">
                                Read More →
                                </a>

                            </div>
                        </div>
                    </div>
                </article>
            @empty
                <!-- Enhanced Empty State -->
                <div class="empty-state text-center py-16 sm:py-20 rounded-2xl animate-fade-in">
                    <svg class="w-16 h-16 sm:w-20 sm:h-20 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253z"></path>
                    </svg>
                    <h3 class="text-xl sm:text-2xl font-semibold text-slate-700 mb-2">No Articles Yet</h3>
                    <p class="text-slate-500 text-sm sm:text-base max-w-md mx-auto">
                        No articles are available at the moment. Check back later for fresh content and insights.
                    </p>
                </div>
            @endforelse

            <!-- Enhanced Pagination -->
            @if(isset($articles) && $articles->hasPages())
                <div class="glass-card rounded-2xl p-4 sm:p-6 mt-6 sm:mt-8 animate-fade-in">
                    <div class="flex items-center justify-between mb-4">
                        <p class="text-sm text-slate-600">
                            Showing {{ $articles->firstItem() }} to {{ $articles->lastItem() }} of {{ $articles->total() }} articles
                        </p>
                    </div>
                    {{ $articles->links() }}
                </div>
            @endif
        </main>

        <!-- Footer -->
        <footer class="bg-white/50 backdrop-blur-sm border-t border-slate-200 mt-auto">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                    <p class="text-xs sm:text-sm text-slate-500">
                        Last updated: {{ now()->format('M d, Y \a\t g:i A') }}
                    </p>
                    <div class="flex items-center space-x-4 text-xs sm:text-sm text-slate-500">
                        <span>Articles Portal</span>
                        <span>•</span>
                        <span>v1.0.0</span>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>