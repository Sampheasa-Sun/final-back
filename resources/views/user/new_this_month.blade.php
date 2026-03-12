<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Users This Month</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        .animate-fade-in {
            animation: fadeIn 0.6s ease-out;
        }
        
        .animate-slide-in {
            animation: slideIn 0.5s ease-out;
        }
        
        .user-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(10px);
        }
        
        .user-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px -4px rgba(0, 0, 0, 0.1), 0 8px 16px -8px rgba(0, 0, 0, 0.1);
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .status-badge {
            backdrop-filter: blur(8px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .empty-state {
            background: radial-gradient(circle at center, rgba(148, 163, 184, 0.1) 0%, transparent 70%);
        }
        
        .header-gradient {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        }
        
        @media (max-width: 640px) {
            .user-card {
                padding: 1rem;
            }
        }
    </style>
</head>
<body class="gradient-bg min-h-screen">
    <div class="min-h-screen flex flex-col">
        <!-- Enhanced Header -->
        <header class="header-gradient text-white shadow-xl">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="animate-slide-in">
                <h1 class="text-3xl sm:text-4xl font-bold mb-1">New Users This Month</h1>
                <p class="text-blue-100 text-sm sm:text-base opacity-90">
                    Showing users registered in {{ now()->format('F Y') }}
                </p>
            </div>

            <!-- Back to Dashboard Button -->
            <a href="{{ route('dashboard') }}"
               class="inline-flex items-center gap-2 bg-white/80 hover:bg-white text-slate-800 font-medium text-sm px-4 py-2 rounded-lg shadow-sm transition-all duration-200 backdrop-blur-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Dashboard
            </a>
        </div>
    </div>
</header>


        <!-- Main Content -->
        <main class="flex-1 container mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
            @if ($users->count())
                <!-- Stats Summary -->
                <div class="glass-card rounded-2xl p-4 sm:p-6 mb-6 sm:mb-8 animate-fade-in">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h2 class="text-lg sm:text-xl font-semibold text-slate-800 mb-1">
                                {{ $users->total() }} New {{ $users->total() === 1 ? 'User' : 'Users' }}
                            </h2>
                            <p class="text-sm text-slate-600">
                                {{ $users->count() }} showing on this page
                            </p>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                            <span class="text-sm text-slate-600">Active Dashboard</span>
                        </div>
                    </div>
                </div>

                <!-- Users Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">
                    @foreach ($users as $index => $user)
                        <div class="user-card glass-card rounded-2xl p-4 sm:p-5 shadow-sm animate-fade-in"
                             style="animation-delay: {{ $index * 0.1 }}s">
                            <div class="flex flex-col space-y-3">
                                <!-- User Avatar & Name -->
                                <div class="flex items-start justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full flex items-center justify-center text-white font-semibold text-sm sm:text-base">
                                            {{ substr($user->firstName, 0, 1) }}{{ substr($user->lastName, 0, 1) }}
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <h3 class="font-semibold text-slate-800 text-sm sm:text-base truncate">
                                                {{ $user->firstName }} {{ $user->lastName }}
                                            </h3>
                                            <span class="status-badge text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full font-medium">
                                                {{ ucfirst($user->status) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- User Details -->
                                <div class="space-y-2">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                        </svg>
                                        <p class="text-sm text-slate-600 truncate">{{ $user->email }}</p>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4m-6 4h6M6 21h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <p class="text-xs text-slate-500">
                                            Joined {{ $user->created_at->format('M d, Y') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Enhanced Pagination -->
                <div class="glass-card rounded-2xl p-4 sm:p-6 animate-fade-in">
                    {{ $users->links() }}
                </div>
            @else
                <!-- Enhanced Empty State -->
                <div class="empty-state text-center py-16 sm:py-20 rounded-2xl">
                    <div class="animate-fade-in">
                        <svg class="w-16 h-16 sm:w-20 sm:h-20 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <h3 class="text-xl sm:text-2xl font-semibold text-slate-700 mb-2">No New Users Yet</h3>
                        <p class="text-slate-500 text-sm sm:text-base max-w-md mx-auto">
                            No new users have registered this month. Check back later or review your user acquisition strategies.
                        </p>
                    </div>
                </div>
            @endif
        </main>

        <!-- Footer -->
        <footer class="bg-white/50 backdrop-blur-sm border-t border-slate-200 mt-auto">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <p class="text-center text-xs sm:text-sm text-slate-500">
                    Last updated: {{ now()->format('M d, Y \a\t g:i A') }}
                </p>
            </div>
        </footer>
    </div>
</body>
</html>