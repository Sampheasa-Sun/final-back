<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .sidebar-overlay {
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
        }

        /* Custom scrollbar for webkit browsers */
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 3px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }

        /* Timeline styles for Recent Activity */
        .timeline-item {
            position: relative;
            padding-left: 2rem; 
        }
        .timeline-item:not(:last-child)::before {
            content: '';
            position: absolute;
            top: 0.75rem; /* Align with the dot's center */
            left: 0.3125rem; /* Center the line on the dot */
            bottom: -0.75rem;
            width: 2px;
            background-color: #e5e7eb; /* Light gray line */
        }
        .timeline-dot {
            position: absolute;
            left: 0;
            top: 0.5rem; /* Vertically center with the first line of text */
            width: 0.75rem;
            height: 0.75rem;
            border-radius: 50%;
            border: 2px solid #fff;
            background-color: currentColor;
        }
        .timeline-dot-pulse {
            animation: pulse-dot 2s infinite cubic-bezier(0.4, 0, 0.6, 1);
        }
        @keyframes pulse-dot {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: .5;
            }
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800">
    <!-- Mobile Menu Overlay -->
    <div id="mobileOverlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden sidebar-overlay"></div>

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div id="sidebar" class="w-64 fixed inset-y-0 left-0 z-50 flex flex-col bg-white border-r border-slate-200 transition-transform duration-300 ease-in-out -translate-x-full lg:translate-x-0">
            <div class="px-6 py-4 border-b border-slate-200">
                <a href="#" class="flex items-center gap-2">
                    <img src="/assets/askly-high-resolution-logo-transparent.png" class="h-8 object-contain" alt="Askly Logo" />
                </a>
            </div>
            
            <nav class="flex-1 flex flex-col justify-between p-4 space-y-4">
                <div class="space-y-6">
                    <div>
                        <p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Menu</p>
                        <div class="space-y-1">
                            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium rounded-lg bg-blue-50 text-blue-600 border-l-4 border-blue-600">
                                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                                <span>Dashboard</span>
                            </a>
                            <a href="{{ route('admin.articles.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-slate-600 rounded-lg hover:bg-slate-100 transition-colors">
                                <i data-lucide="file-text" class="w-5 h-5"></i>
                                <span>Manage Articles</span>
                            </a>
                            <a href="/manage_user" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-slate-600 rounded-lg hover:bg-slate-100 transition-colors">
                                <i data-lucide="users" class="w-5 h-5"></i>
                                <span>Manage Users</span>
                            </a>
                        </div>
                    </div>
                    <div>
                        <p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Admin</p>
                        <a href="/admin_setting" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-slate-600 rounded-lg hover:bg-slate-100 transition-colors">
                            <i data-lucide="settings" class="w-5 h-5"></i>
                            <span>Settings</span>
                        </a>
                    </div>
                </div>

                <!-- User Profile Section at bottom of Sidebar -->
                <div class="pt-4 border-t border-slate-200">
                     @php $admin = Auth::guard('admin')->user(); @endphp
                    <div class="flex items-center gap-3">
                        @if ($admin && $admin->photo)
                            <img src="{{ asset('storage/' . $admin->photo) }}" class="w-10 h-10 rounded-full object-cover" alt="Admin Photo">
                        @else
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center">
                                <span class="text-white font-medium">
                                    {{ strtoupper(substr($admin->firstName, 0, 1)) ?? '?' }}{{ strtoupper(substr($admin->lastName, 0, 1)) ?? '?' }}
                                </span>
                            </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-slate-800 truncate">{{ $admin->firstName }} {{ $admin->lastName }}</p>
                            <p class="text-xs text-slate-500 truncate">{{ $admin->email }}</p>
                        </div>
                        <form method="POST" action="{{ route('admin.logout') }}">
                             @csrf
                            <button type="submit" aria-label="Log out" class="p-2 text-slate-500 hover:bg-slate-100 hover:text-red-600 rounded-lg transition-colors">
                                <i data-lucide="log-out" class="w-5 h-5"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 lg:ml-64 flex flex-col">
            <!-- Header -->
         <header class="h-16 bg-white/80 backdrop-blur-sm border-b border-slate-200 px-4 sm:px-6 flex items-center justify-between sticky top-0 z-30">
    <div class="flex items-center justify-between w-full">
        <!-- Left: Sidebar toggle -->
        <div class="flex items-center gap-4">
            <button id="openSidebar" aria-label="Open sidebar" class="lg:hidden p-2 -ml-2 text-slate-600 hover:bg-slate-100 rounded-lg">
                <i data-lucide="menu" class="w-6 h-6"></i>
            </button>
        </div>

        <!-- Right: Search bar and profile -->
        <div class="flex items-center gap-4">
            <!-- Search Bar -->
            <div class="relative">
                <i data-lucide="search" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" placeholder="Search..." class="w-64 pl-9 pr-4 py-2 text-sm bg-slate-100 border border-transparent rounded-lg focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
            </div>

            <!-- User Profile Dropdown -->
            <div class="relative">
                <button id="profileBtn" class="flex items-center gap-2 p-1 rounded-full hover:bg-slate-100 transition-colors">
                    @if ($admin && $admin->photo)
                        <img src="{{ asset('storage/' . $admin->photo) }}" class="w-9 h-9 rounded-full object-cover ring-2 ring-white" alt="Admin Photo">
                    @else
                        <div class="w-9 h-9 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center ring-2 ring-white">
                            <span class="text-white text-sm font-medium">
                                {{ strtoupper(substr($admin->firstName, 0, 1)) ?? '?' }}{{ strtoupper(substr($admin->lastName, 0, 1)) ?? '?' }}
                            </span>
                        </div>
                    @endif
                </button>
                <div id="profileDropdown" class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-slate-200 z-50 transition-all duration-200 ease-in-out transform opacity-0 -translate-y-2 invisible">
                    <div class="p-2">
                        <div class="px-3 py-2">
                            <p class="text-sm font-semibold text-slate-800">{{ $admin->firstName }} {{ $admin->lastName }}</p>
                            <p class="text-xs text-slate-500 truncate">{{ $admin->email }}</p>
                        </div>
                        <hr class="my-1 border-slate-200">
                        <a href="{{ route('admin.settings') }}" class="flex items-center gap-3 px-3 py-2 text-sm text-slate-700 hover:bg-slate-100 rounded-md transition-colors">
                            <i data-lucide="settings" class="w-4 h-4"></i>
                            <span>Account Settings</span>
                        </a>
                        <a href="#" class="flex items-center gap-3 px-3 py-2 text-sm text-slate-700 hover:bg-slate-100 rounded-md transition-colors">
                            <i data-lucide="activity" class="w-4 h-4"></i>
                            <span>Activity Log</span>
                        </a>
                        <hr class="my-1 border-slate-200">
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center gap-3 w-full px-3 py-2 text-sm text-red-600 hover:bg-red-50 rounded-md transition-colors">
                                <i data-lucide="log-out" class="w-4 h-4"></i>
                                <span>Log Out</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>


            <!-- Scrollable Content -->
            <main class="flex-1 p-4 sm:p-6 overflow-y-auto">
                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-slate-900">Dashboard Overview</h1>
                    <p class="text-sm text-slate-500">Welcome back, {{ $admin->firstName }}. Here's what's happening today.</p>
                </div>
                
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4 sm:gap-6 mb-6">
                    <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm transition-all hover:shadow-md hover:-translate-y-1">
                        <div class="flex justify-between items-start">
                            
                            <div class="flex flex-col">
                                <a href="{{ route('admin.articles.all') }}">
                                    <p class="text-sm font-medium text-slate-500 mb-1">Total Articles</p>
                               <p class="text-3xl font-bold text-slate-900">{{ $totalArticles }}</p>
                                
                                <p class="text-xs text-green-500 mt-1 flex items-center gap-1">+2 since yesterday</p>
                                </a>
                                
                            </div>
                            <div class="bg-blue-100 text-blue-600 w-12 h-12 rounded-full flex items-center justify-center">
                                <i data-lucide="file-text" class="w-6 h-6"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm transition-all hover:shadow-md hover:-translate-y-1">
                        <div class="flex justify-between items-start">
                            <div class="flex flex-col">
                                <p class="text-sm font-medium text-slate-500 mb-1">Pending Review</p>
                                <a href="{{ route('admin.articles.pending') }}">
                                        <p class="text-3xl font-bold text-slate-900">{{ $pendingReview }}</p>
                                </a>
                
                                
                                 <p class="text-xs text-slate-500 mt-1 flex items-center gap-1">No change</p>
                            </div>
                            <div class="bg-amber-100 text-amber-600 w-12 h-12 rounded-full flex items-center justify-center">
                                <i data-lucide="clock" class="w-6 h-6"></i>
                            </div>
                        </div>
                    </div>
                                <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm transition-all hover:shadow-md hover:-translate-y-1 sm:col-span-2 xl:col-span-1">
                    <div class="flex justify-between items-start">
                        <div class="flex flex-col">
                            <p class="text-sm font-medium text-slate-500 mb-1">New Users This Month</p>
                            <a href="{{ route('admin.users.newThisMonth') }}">
                            <p class="text-3xl font-bold text-slate-900 hover:text-blue-600">{{ $newUsersThisMonth }}</p>
                                </a>

                            <p class="text-xs text-green-500 mt-1 flex items-center gap-1">+{{ $newUsersThisMonth }} new users</p>
                        </div>
                        <div class="bg-green-100 text-green-600 w-12 h-12 rounded-full flex items-center justify-center">
                            <i data-lucide="user-plus" class="w-6 h-6"></i>
                        </div>
                    </div>
                </div>

                </div>

                <!-- Charts Section -->
                <div class="bg-white p-4 sm:p-6 rounded-xl border border-slate-200 shadow-sm mb-6">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4">
                        <div>
                            <h2 class="text-lg font-semibold text-slate-800">Analytics Overview</h2>
                            <p class="text-sm text-slate-500">Visual representation of key metrics.</p>
                        </div>
                        <div class="mt-3 sm:mt-0 flex-shrink-0 bg-slate-100 p-1 rounded-lg flex gap-1">
                            <button id="articlesBtn" class="px-3 py-1 text-sm font-medium bg-white text-blue-600 rounded-md shadow-sm transition-all">Articles</button>
                            <button id="usersBtn" class="px-3 py-1 text-sm font-medium text-slate-600 hover:text-blue-600 rounded-md transition-all">Users</button>
                        </div>
                    </div>
                    <div id="articlesChartSection" class="relative h-72 w-full">
                        <canvas id="articleChart"></canvas>
                    </div>
                    <div id="usersChartSection" class="relative h-72 w-full hidden">
                        <canvas id="userChart"></canvas>
                    </div>
                </div>

                <!-- Two Column Layout -->
                <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
                    <!-- Articles Pending Review -->
                    <section class="lg:col-span-3">
                        <div class="bg-white border border-slate-200 rounded-xl shadow-sm h-full">
                            <div class="flex justify-between items-center px-4 sm:px-6 py-4 border-b border-slate-200">
                                <h2 class="text-lg font-semibold text-slate-800">Articles Pending Review</h2>
                                <a href="{{ route('admin.articles.index') }}" class="text-sm font-medium text-blue-600 hover:underline">
                                    View All
                                </a>
                            </div>
                            <div class="divide-y divide-slate-100 max-h-[28rem] overflow-y-auto">
                                @forelse ($articles as $article)
                                    <div class="flex items-center justify-between px-4 sm:px-6 py-4 hover:bg-slate-50 transition-colors">
                                        <div class="flex items-center gap-4 min-w-0">
                                            @if($article->user && $article->user->photo)
                                            <img src="{{ asset('storage/' . $article->user->photo) }}" class="w-10 h-10 rounded-full object-cover hidden sm:block" alt="Author Photo">
                                            @else
                                            <div class="w-10 h-10 rounded-full bg-slate-200 flex-shrink-0 items-center justify-center hidden sm:flex">
                                                <i data-lucide="user" class="w-5 h-5 text-slate-400"></i>
                                            </div>
                                            @endif
                                            <div class="min-w-0">
                                                <a href="#" title="{{ $article->title }}" class="font-semibold text-sm text-slate-800 truncate block hover:text-blue-600">{{ $article->title }}</a>
                                                <p class="text-xs text-slate-500">By {{ $article->user->firstName ?? $article->author->name ?? 'Unknown' }} • {{ $article->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                        <a href="#" class="ml-4 px-3 py-1.5 text-xs font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-full transition-colors">Review</a>
                                    </div>
                                @empty
                                    <div class="text-center py-12 px-6">
                                        <i data-lucide="inbox" class="w-12 h-12 mx-auto text-slate-300"></i>
                                        <h3 class="mt-2 text-sm font-medium text-slate-600">All caught up!</h3>
                                        <p class="mt-1 text-sm text-slate-500">There are no articles pending review.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </section>

                    <!-- Recent Activity Section -->
                    <section class="lg:col-span-2">
                        <div class="bg-white border border-slate-200 rounded-xl shadow-sm h-full">
                            <div class="px-4 sm:px-6 py-4 border-b border-slate-200">
                                <h2 class="text-lg font-semibold text-slate-800">Recent Activity</h2>
                            </div>
                            <div class="p-4 sm:p-6 max-h-[28rem] overflow-y-auto">
                                <div class="space-y-6">
                                    @forelse ($recentActivities as $activity)
                                        <div class="timeline-item">
                                            <div class="timeline-dot text-blue-500 {{ $loop->first ? 'timeline-dot-pulse' : '' }}"></div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm text-slate-700">
                                                    @if ($activity->causer instanceof \App\Models\Admin)
                                                        <span class="font-semibold text-blue-600">Admin {{ $activity->causer->firstName }}</span>
                                                    @elseif ($activity->causer instanceof \App\Models\User)
                                                        <span class="font-semibold text-green-600">User {{ $activity->causer->firstName }}</span>
                                                    @else
                                                        <span class="font-semibold text-slate-600">System</span>
                                                    @endif
                                                    {{ $activity->description }}
                                                </p>
                                                <span class="text-xs text-slate-400 block mt-0.5">
                                                    {{ $activity->created_at->diffForHumans() }}
                                                </span>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center py-12 px-6">
                                            <i data-lucide="activity" class="w-12 h-12 mx-auto text-slate-300"></i>
                                            <h3 class="mt-2 text-sm font-medium text-slate-600">No recent activity</h3>
                                            <p class="mt-1 text-sm text-slate-500">Activity will be logged here.</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        lucide.createIcons();

        // --- Mobile Sidebar & Overlay ---
        const sidebar = document.getElementById('sidebar');
        const openSidebarBtn = document.getElementById('openSidebar');
        const mobileOverlay = document.getElementById('mobileOverlay');

        const openSidebar = () => {
            sidebar.classList.remove('-translate-x-full');
            mobileOverlay.classList.remove('hidden');
        };
        const closeSidebar = () => {
            sidebar.classList.add('-translate-x-full');
            mobileOverlay.classList.add('hidden');
        };

        openSidebarBtn.addEventListener('click', openSidebar);
        mobileOverlay.addEventListener('click', closeSidebar);

        // --- Profile Dropdown ---
        const profileBtn = document.getElementById('profileBtn');
        const profileDropdown = document.getElementById('profileDropdown');

        profileBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            profileDropdown.classList.toggle('opacity-0');
            profileDropdown.classList.toggle('-translate-y-2');
            profileDropdown.classList.toggle('invisible');
        });

        document.addEventListener('click', (e) => {
            if (!profileDropdown.contains(e.target) && !profileBtn.contains(e.target)) {
                profileDropdown.classList.add('opacity-0', '-translate-y-2', 'invisible');
            }
        });

        // --- Chart Toggling ---
        const articlesBtn = document.getElementById('articlesBtn');
        const usersBtn = document.getElementById('usersBtn');
        const articlesChartSection = document.getElementById('articlesChartSection');
        const usersChartSection = document.getElementById('usersChartSection');

        articlesBtn.addEventListener('click', () => {
            articlesChartSection.classList.remove('hidden');
            usersChartSection.classList.add('hidden');
            articlesBtn.classList.add('bg-white', 'text-blue-600', 'shadow-sm');
            usersBtn.classList.remove('bg-white', 'text-blue-600', 'shadow-sm');
        });

        usersBtn.addEventListener('click', () => {
            usersChartSection.classList.remove('hidden');
            articlesChartSection.classList.add('hidden');
            usersBtn.classList.add('bg-white', 'text-blue-600', 'shadow-sm');
            articlesBtn.classList.remove('bg-white', 'text-blue-600', 'shadow-sm');
        });

        // --- Chart.js Configuration ---
        const chartDefaultOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    enabled: true,
                    backgroundColor: '#1e293b',
                    titleColor: '#f8fafc',
                    bodyColor: '#cbd5e1',
                    padding: 10,
                    cornerRadius: 6,
                    boxPadding: 4,
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { color: '#94a3b8', precision: 0 },
                    grid: { color: '#f1f5f9' }
                },
                x: {
                    ticks: { color: '#94a3b8' },
                    grid: { display: false }
                }
            },
            animation: {
                duration: 500,
                easing: 'easeInOutQuad'
            }
        };

        new Chart(document.getElementById('articleChart'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($articleStats->keys()) !!},
                datasets: [{
                    label: 'Articles',
                    data: {!! json_encode($articleStats->values()) !!},
                    backgroundColor: ['#3b82f6', '#f59e0b', '#ef4444'],
                    borderRadius: 6,
                    borderSkipped: false,
                    barPercentage: 0.6,
                    categoryPercentage: 0.7
                }]
            },
            options: chartDefaultOptions
        });

        new Chart(document.getElementById('userChart'), {
            type: 'line',
            data: {
                labels: {!! json_encode($userStats->keys()) !!},
                datasets: [{
                    label: 'New Users',
                    data: {!! json_encode($userStats->values()) !!},
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2,
                    pointRadius: 0,
                    pointHoverRadius: 6,
                    pointBackgroundColor: '#10b981',
                }]
            },
            options: chartDefaultOptions
        });

        // Handle sidebar state on window resize
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                // On desktop, ensure sidebar is always visible
                sidebar.classList.remove('-translate-x-full');
                mobileOverlay.classList.add('hidden');
            } else {
                // On mobile, ensure sidebar is hidden by default
                sidebar.classList.add('-translate-x-full');
            }
        });
    </script>
</body>

</html>