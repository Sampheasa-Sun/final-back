<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Pending Review Articles</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        'primary': {
                            50: '#f0f9ff',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                        }
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .article-card {
            transition: all 0.3s ease;
        }
        .article-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .status-badge {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        }
        .header-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 font-sans min-h-screen">
    <!-- Header Section -->
   <div class="bg-blue-900 text-white">
    <div class="max-w-6xl mx-auto px-6 py-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Content Review Dashboard</h1>
                <p class="text-white/80 text-lg">Manage and review pending articles</p>
            </div>
            <div class="flex items-center space-x-4">
                <div class="bg-blue-700 px-4 py-2 rounded-full text-sm font-medium text-white shadow-lg flex items-center">
                    <span class="inline-block w-2 h-2 bg-white rounded-full mr-2 animate-pulse"></span>
                    Pending Review
                </div>
                <a href="{{ route('dashboard') }}"
                   class="inline-flex items-center gap-2 bg-white text-blue-900 font-semibold text-sm px-4 py-2 rounded-lg shadow hover:bg-gray-100 transition duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to Dashboard
                </a>
            </div>
        </div>
    </div>
</div>


    <!-- Main Content -->
    <div class="max-w-6xl mx-auto px-6 py-8">
        <!-- Stats Bar -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-50 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-500">Total Articles</h3>
                        <p class="text-2xl font-semibold text-gray-900">{{ $articles->total() ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                <div class="flex items-center">
                    <div class="p-3 bg-yellow-50 rounded-lg">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-500">Pending Review</h3>
                        <p class="text-2xl font-semibold text-gray-900">{{ $articles->count() ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                <div class="flex items-center">
                    <div class="p-3 bg-green-50 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-500">Avg. Review Time</h3>
                        <p class="text-2xl font-semibold text-gray-900">2.3 days</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Articles Grid -->
        <div class="space-y-4">
            @foreach ($articles as $article)
                <div class="article-card bg-white rounded-xl p-6 shadow-sm border border-gray-200 hover:border-blue-300 fade-in">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center mb-3">
                                <h2 class="text-xl font-semibold text-gray-900 mr-3">{{ $article->title }}</h2>
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-medium rounded-full">
                                    Pending Review
                                </span>
                            </div>
                            
                            <div class="flex items-center text-sm text-gray-500 mb-4 space-x-4">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    By {{ $article->user->firstName ?? 'Unknown' }}
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ $article->created_at->format('F d, Y') }}
                                </div>
                            </div>
                            
                            <p class="text-gray-700 leading-relaxed mb-4">
                                {{ Str::limit(strip_tags($article->body), 150) }}
                            </p>
                        </div>
                        
                        <div class="flex flex-col space-y-2 ml-6">
                            <a href="{{ route('admin.articles.show', $article->id) }}" 
                            class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Review
                            </a>
                            <button class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors duration-200">
                                Quick View
                            </button>
                        </div>
                    </div>
                    
                    <!-- Article Meta Footer -->
                    <div class="flex items-center justify-between pt-4 mt-4 border-t border-gray-100">
                        <div class="flex items-center text-xs text-gray-500">
                            <span class="flex items-center mr-4">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2h4a1 1 0 110 2h-1v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6H3a1 1 0 010-2h4z"></path>
                                </svg>
                                {{ Str::words(strip_tags($article->body), 1, '') }} words
                            </span>
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $article->created_at->diffForHumans() }}
                            </span>
                        </div>
                        
                        <div class="flex items-center space-x-2">
                            <span class="w-2 h-2 bg-yellow-400 rounded-full"></span>
                            <span class="text-xs text-gray-500">Awaiting Review</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="mt-8 flex justify-center">
            <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-200">
                {{ $articles->links() }}
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-16">
        <div class="max-w-6xl mx-auto px-6 py-8">
            <div class="flex items-center justify-between">
                <p class="text-gray-500 text-sm">© 2024 Content Management System. All rights reserved.</p>
                <div class="flex items-center space-x-4 text-sm text-gray-500">
                    <a href="#" class="hover:text-gray-700 transition-colors">Help</a>
                    <a href="#" class="hover:text-gray-700 transition-colors">Support</a>
                    <a href="#" class="hover:text-gray-700 transition-colors">Documentation</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>