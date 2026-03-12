<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Article Management Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        * {
            font-family: 'Inter', sans-serif;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        .status-badge {
            position: relative;
            overflow: hidden;
        }

        .status-badge::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }

        .status-badge:hover::before {
            left: 100%;
        }

        .table-row {
            transition: all 0.3s ease;
            position: relative;
        }

        .table-row:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .floating-card {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .pulse-border {
            border: 2px solid #667eea;
            animation: pulse-border 2s infinite;
        }

        @keyframes pulse-border {
            0% {
                border-color: #667eea;
                box-shadow: 0 0 0 0 rgba(102, 126, 234, 0.7);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(102, 126, 234, 0);
            }

            100% {
                border-color: #764ba2;
            }
        }

        .shimmer {
            background: linear-gradient(45deg, #f0f0f0 25%, transparent 25%),
                linear-gradient(-45deg, #f0f0f0 25%, transparent 25%),
                linear-gradient(45deg, transparent 75%, #f0f0f0 75%),
                linear-gradient(-45deg, transparent 75%, #f0f0f0 75%);
            background-size: 20px 20px;
            background-position: 0 0, 0 10px, 10px -10px, -10px 0px;
            animation: shimmer 2s linear infinite;
        }

        @keyframes shimmer {
            0% {
                background-position: 0 0, 0 10px, 10px -10px, -10px 0px;
            }

            100% {
                background-position: 20px 20px, 20px 30px, 30px 10px, 10px 20px;
            }
        }
    </style>
</head>

<body class="min-h-screen gradient-bg">
    <!-- Animated Background Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-white opacity-10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-purple-300 opacity-10 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
    </div>

    <div class="relative z-10 container mx-auto px-4 py-8 max-w-7xl">
        <!-- Header Section -->
        <div class="text-center mb-12">
            <div class="inline-block p-1 rounded-full glass-effect mb-6">
                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center">
                    <i class="fas fa-newspaper text-2xl text-purple-600"></i>
                </div>
            </div>
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                Article Management
                <span class="block text-xl md:text-2xl font-normal text-purple-200 mt-2">
                    Dashboard Overview
                </span>
            </h1>
            <p class="text-purple-100 text-lg max-w-2xl mx-auto">
                Manage and monitor your articles with real-time status tracking
            </p>
        </div>

        <!-- Navigation -->
        <div class="mb-8 flex justify-between items-center">
            <a href="{{ route('admin.articles.index') }}"
                class="group inline-flex items-center px-6 py-3 glass-effect text-white rounded-xl hover:bg-white hover:text-purple-700 transition-all duration-300 transform hover:scale-105">
                <i class="fas fa-arrow-left mr-3 transition-transform group-hover:-translate-x-1"></i>
                Back to Articles
            </a>

            <div class="flex space-x-4">
                <button class="px-4 py-2 glass-effect text-white rounded-lg hover:bg-white hover:text-purple-700 transition-all duration-300">
                    <i class="fas fa-filter mr-2"></i>Filter
                </button>
                <button class="px-4 py-2 glass-effect text-white rounded-lg hover:bg-white hover:text-purple-700 transition-all duration-300">
                    <i class="fas fa-download mr-2"></i>Export
                </button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="floating-card glass-effect rounded-2xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-200 text-sm uppercase tracking-wide">Published</p>
                        <p class="text-3xl font-bold">{{ $articles->where('status', 'published')->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center">
                        <i class="fas fa-check text-white"></i>
                    </div>
                </div>
            </div>

            <div class="floating-card glass-effect rounded-2xl p-6 text-white" style="animation-delay: 0.2s;">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-200 text-sm uppercase tracking-wide">Draft</p>
                        <p class="text-3xl font-bold">{{ $articles->where('status', 'draft')->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-500 rounded-xl flex items-center justify-center">
                        <i class="fas fa-edit text-white"></i>
                    </div>
                </div>
            </div>

            <div class="floating-card glass-effect rounded-2xl p-6 text-white" style="animation-delay: 0.4s;">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-200 text-sm uppercase tracking-wide">Under Review</p>
                        <p class="text-3xl font-bold">{{ $articles->where('status', 'under review')->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center">
                        <i class="fas fa-eye text-white"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Articles Table -->
        <div class="glass-effect rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-white border-opacity-20">
                            <th class="px-6 py-4 text-left text-sm font-semibold text-white uppercase tracking-wider">
                                <i class="fas fa-hashtag mr-2"></i>ID
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-white uppercase tracking-wider">
                                <i class="fas fa-file-alt mr-2"></i>Title
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-white uppercase tracking-wider">
                                <i class="fas fa-user mr-2"></i>Author
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-white uppercase tracking-wider">
                                <i class="fas fa-flag mr-2"></i>Status
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-white uppercase tracking-wider">
                                <i class="fas fa-calendar mr-2"></i>Updated
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-white uppercase tracking-wider">
                                <i class="fas fa-cog mr-2"></i>Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white divide-opacity-10">
                        @forelse ($articles as $article)
                        <tr class="table-row text-white hover:bg-white hover:bg-opacity-10">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="w-10 h-10 bg-purple-600 rounded-lg flex items-center justify-center text-sm font-bold">
                                    {{ $article->id }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="max-w-xs truncate font-medium">
                                    {{ $article->title }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-gradient-to-r from-purple-400 to-pink-400 rounded-full flex items-center justify-center text-xs font-bold mr-3">
                                        {{ substr($article->user->firstName, 0, 1) }}
                                    </div>
                                    {{ $article->user->firstName }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($article->status === 'published')
                                <span class="status-badge inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-500 text-white">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Published
                                </span>
                                @elseif($article->status === 'draft')
                                <span class="status-badge inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-500 text-white">
                                    <i class="fas fa-edit mr-1"></i>
                                    Draft
                                </span>
                                @else
                                <span class="status-badge inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-500 text-white">
                                    <i class="fas fa-eye mr-1"></i>
                                    Under Review
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                {{ $article->updated_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex space-x-2">
                                    <button class="w-8 h-8 bg-blue-500 hover:bg-blue-600 rounded-lg flex items-center justify-center transition-colors duration-200">
                                        <i class="fas fa-eye text-xs text-white"></i>
                                    </button>
                                    <button class="w-8 h-8 bg-green-500 hover:bg-green-600 rounded-lg flex items-center justify-center transition-colors duration-200">
                                        <i class="fas fa-edit text-xs text-white"></i>
                                    </button>
                                    <button class="w-8 h-8 bg-red-500 hover:bg-red-600 rounded-lg flex items-center justify-center transition-colors duration-200">
                                        <i class="fas fa-trash text-xs text-white"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-purple-600 rounded-full flex items-center justify-center mb-4">
                                        <i class="fas fa-inbox text-2xl text-white"></i>
                                    </div>
                                    <p class="text-white text-lg font-medium mb-2">No articles found</p>
                                    <p class="text-purple-200">Create your first article to get started</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-8 flex justify-center">
            <div class="glass-effect rounded-xl p-4">
                {{ $articles->links() }}
            </div>
        </div>
    </div>

    <script>
        // Add some interactive animations
        document.addEventListener('DOMContentLoaded', function() {
            // Animate table rows on scroll
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry, index) => {
                    if (entry.isIntersecting) {
                        entry.target.style.animationDelay = `${index * 0.1}s`;
                        entry.target.classList.add('animate-fadeInUp');
                    }
                });
            });

            document.querySelectorAll('.table-row').forEach(row => {
                observer.observe(row);
            });
        });
    </script>
</body>

</html>