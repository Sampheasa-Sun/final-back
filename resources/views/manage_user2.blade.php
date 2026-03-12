<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Admin Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
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
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #9ca3af; }

        .active-filter {
            border-color: #3b82f6;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.3);
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800">
    <div id="mobileOverlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden sidebar-overlay"></div>

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside id="sidebar" class="w-64 fixed inset-y-0 left-0 z-50 flex flex-col bg-white border-r border-slate-200 transition-transform duration-300 ease-in-out -translate-x-full lg:translate-x-0">
            <div class="px-6 py-4 border-b border-slate-200">
                <a href="#" class="flex items-center gap-2">
                    <img src="/assets/askly-high-resolution-logo-transparent.png" class="h-8 object-contain" alt="Askly Logo" />
                </a>
            </div>
            
            <nav class="flex-1 p-4">
                <div class="space-y-6">
                    <div>
                        <p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Menu</p>
                        <div class="space-y-1">
                            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-slate-600 rounded-lg hover:bg-slate-100 transition-colors">
                                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                                <span>Dashboard</span>
                            </a>
                            <a href="{{ route('admin.articles.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-slate-600 rounded-lg hover:bg-slate-100 transition-colors">
                                <i data-lucide="file-text" class="w-5 h-5"></i>
                                <span>Manage Articles</span>
                            </a>
                            <a href="{{ route('admin.manage.users') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium rounded-lg bg-blue-50 text-blue-600 border-l-4 border-blue-600">
                                <i data-lucide="users" class="w-5 h-5"></i>
                                <span>Manage Users</span>
                            </a>
                             <div>
                        <p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Admin</p>
                        <a href="/admin_setting" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-slate-600 rounded-lg hover:bg-slate-100 transition-colors">
                            <i data-lucide="settings" class="w-5 h-5"></i>
                            <span>Settings</span>
                        </a>
                    </div>
                        </div>
                    </div>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 lg:ml-64 flex flex-col">
            <!-- Header -->
            <header class="h-16 bg-white/80 backdrop-blur-sm border-b border-slate-200 px-4 sm:px-6 flex items-center justify-between sticky top-0 z-30">
                 <div class="flex items-center gap-4">
                    <button id="openSidebar" aria-label="Open sidebar" class="lg:hidden p-2 -ml-2 text-slate-600 hover:bg-slate-100 rounded-lg">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </button>
                    <div>
                        <h1 class="text-xl font-bold text-slate-900">User Management</h1>
                        <p class="text-sm text-slate-500 hidden sm:block">Administer user roles, status, and permissions.</p>
                    </div>
                </div>
                <!-- Profile and Actions -->
                @php $admin = Auth::guard('admin')->user(); @endphp
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <button id="profileBtn" class="flex items-center gap-2 p-1 rounded-full hover:bg-slate-100 transition-colors">
                            @if ($admin && $admin->photo)
                                <img src="{{ asset('storage/' . $admin->photo) }}" class="w-9 h-9 rounded-full object-cover ring-2 ring-white" alt="Admin Photo">
                            @else
                                <div class="w-9 h-9 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center ring-2 ring-white">
                                    <span class="text-white text-sm font-medium">{{ strtoupper(substr($admin->firstName, 0, 1)) ?? '?' }}{{ strtoupper(substr($admin->lastName, 0, 1)) ?? '?' }}</span>
                                </div>
                            @endif
                        </button>
                         <div id="profileDropdown" class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-slate-200 z-50 transition-all duration-200 ease-in-out transform opacity-0 -translate-y-2 invisible">
                            <div class="p-2">
                                <div class="px-3 py-2"><p class="text-sm font-semibold text-slate-800">{{ $admin->firstName }} {{ $admin->lastName }}</p><p class="text-xs text-slate-500 truncate">{{ $admin->email }}</p></div><hr class="my-1 border-slate-200">
                                <a href="{{ route('admin.settings') }}" class="flex items-center gap-3 px-3 py-2 text-sm text-slate-700 hover:bg-slate-100 rounded-md transition-colors"><i data-lucide="settings" class="w-4 h-4"></i><span>Account Settings</span></a>
                                <form method="POST" action="{{ route('admin.logout') }}">@csrf<button type="submit" class="flex items-center gap-3 w-full px-3 py-2 text-sm text-red-600 hover:bg-red-50 rounded-md transition-colors"><i data-lucide="log-out" class="w-4 h-4"></i><span>Log Out</span></button></form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Scrollable Content -->
            <div class="flex-1 p-4 sm:p-6 overflow-y-auto">
                <!-- User Stats -->
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 sm:gap-6 mb-6">
                    <div class="filter-card bg-white p-5 rounded-xl border border-slate-200 shadow-sm transition-all hover:shadow-md hover:-translate-y-1 cursor-pointer active-filter" data-type="all">
                        <div class="flex justify-between items-start"><div class="flex flex-col"><p class="text-sm font-medium text-slate-500">Total Users</p><p class="text-3xl font-bold text-slate-900">{{ $totalUsers }}</p></div><div class="bg-blue-100 text-blue-600 w-12 h-12 rounded-full flex items-center justify-center"><i data-lucide="users" class="w-6 h-6"></i></div></div>
                    </div>
                    <div class="filter-card bg-white p-5 rounded-xl border border-slate-200 shadow-sm transition-all hover:shadow-md hover:-translate-y-1 cursor-pointer" data-type="active">
                        <div class="flex justify-between items-start"><div class="flex flex-col"><p class="text-sm font-medium text-slate-500">Active Users</p><p class="text-3xl font-bold text-green-600">{{ $activeUsers }}</p></div><div class="bg-green-100 text-green-600 w-12 h-12 rounded-full flex items-center justify-center"><i data-lucide="user-check" class="w-6 h-6"></i></div></div>
                    </div>
                    <div class="filter-card bg-white p-5 rounded-xl border border-slate-200 shadow-sm transition-all hover:shadow-md hover:-translate-y-1 cursor-pointer" data-type="banned">
                        <div class="flex justify-between items-start"><div class="flex flex-col"><p class="text-sm font-medium text-slate-500">Banned Users</p><p class="text-3xl font-bold text-red-600">{{ $bannedUsers }}</p></div><div class="bg-red-100 text-red-600 w-12 h-12 rounded-full flex items-center justify-center"><i data-lucide="user-x" class="w-6 h-6"></i></div></div>
                    </div>
                    <div class="filter-card bg-white p-5 rounded-xl border border-slate-200 shadow-sm transition-all hover:shadow-md hover:-translate-y-1 cursor-pointer" data-type="admin">
                        <div class="flex justify-between items-start"><div class="flex flex-col"><p class="text-sm font-medium text-slate-500">Admins</p><p class="text-3xl font-bold text-sky-600">{{ $adminCount }}</p></div><div class="bg-sky-100 text-sky-600 w-12 h-12 rounded-full flex items-center justify-center"><i data-lucide="shield" class="w-6 h-6"></i></div></div>
                    </div>
                </div>
                
                <!-- Search and Actions -->
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm mb-6 flex flex-col sm:flex-row justify-between items-center gap-4">
                     <div class="relative w-full sm:w-auto sm:flex-1">
                        <i data-lucide="search" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input type="search" id="userSearch" placeholder="Search by name or email..." class="w-full max-w-sm pl-9 pr-4 py-2 text-sm bg-slate-100 border border-transparent rounded-lg focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                    </div>
                </div>

                <!-- Users List Container -->
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                    <!-- Desktop Table -->
                    <div class="hidden lg:block">
    <table class="w-full text-sm text-left text-slate-500">
        <thead class="text-xs text-slate-700 uppercase bg-slate-50">
            <tr class="text-left">
                <th class="px-6 py-3">User</th>
                <th class="px-6 py-3">Role</th>
                <th class="px-6 py-3">Status</th>
                <th class="px-6 py-3">Joined Date</th>
                <th class="px-6 py-3 text-center">Actions</th>
            </tr>
        </thead>
        <tbody id="userTableBody" class="divide-y divide-slate-200">
            @forelse($users as $user)
                <tr class="user-row bg-white hover:bg-slate-50"
                    data-status="{{ $user->status }}"
                    data-role="{{ $user->is_admin ? 'admin' : 'user' }}"
                    data-name="{{ strtolower($user->firstName . ' ' . $user->lastName) }}"
                    data-email="{{ strtolower($user->email) }}">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-slate-200 flex-shrink-0 items-center justify-center flex">
                                <i data-lucide="user" class="w-5 h-5 text-slate-400"></i>
                            </div>
                            <div class="font-medium text-slate-900">
                                {{ $user->firstName }} {{ $user->lastName }}
                                <div class="font-normal text-slate-500">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        @if($user->is_admin)
                            <span class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-sky-100 text-sky-800">Admin</span>
                        @else
                            <span class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-slate-100 text-slate-800">User</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-0.5 text-xs font-medium rounded-full {{ $user->status === 'banned' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                            {{ ucfirst($user->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">{{ $user->created_at->format('M d, Y') }}</td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center gap-2 flex-wrap">
                            <a href="{{ route('admin.users.edit', $user->user_id) }}"
                                class="px-3 py-1 text-sm font-medium text-slate-600 bg-slate-50 hover:bg-slate-100 rounded-lg">
                                Edit
                            </a>

                            @if ($user->status !== 'banned')
                                <form action="{{ route('admin.users.ban', $user) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to ban this user?');">
                                    @csrf
                                    <button type="submit"
                                        class="px-3 py-1 text-sm font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-lg">
                                        Ban
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('admin.users.unban', $user) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="px-3 py-1 text-sm font-medium text-green-600 bg-green-50 hover:bg-green-100 rounded-lg">
                                        Unban
                                    </button>
                                </form>
                            @endif

                            @if (!$user->is_admin)
                                <form action="{{ route('admin.users.promote', $user->email) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to promote this user to Admin?');">
                                    @csrf
                                    <button type="submit"
                                        class="px-3 py-1 text-sm font-medium text-sky-600 bg-sky-50 hover:bg-sky-100 rounded-lg">
                                        Promote
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('admin.users.demote', $user->email) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to demote this admin to a User?');">
                                    @csrf
                                    <button type="submit"
                                        class="px-3 py-1 text-sm font-medium text-orange-600 bg-orange-50 hover:bg-orange-100 rounded-lg">
                                        Demote
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-12">
                        <div class="text-center text-slate-500">
                            <i data-lucide="users" class="w-12 h-12 mx-auto text-slate-300"></i>
                            <h3 class="mt-2 text-sm font-medium text-slate-600">No Users Found</h3>
                            <p class="mt-1 text-sm text-slate-500">No users match the current filters.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

                    <!-- Mobile Card View -->
<div id="userCardList" class="block lg:hidden divide-y divide-slate-100">
    @forelse($users as $user)
    <div class="user-row p-4"
        data-status="{{ $user->status }}"
        data-role="{{ $user->is_admin ? 'admin' : 'user' }}"
        data-name="{{ strtolower($user->firstName . ' ' . $user->lastName) }}"
        data-email="{{ strtolower($user->email) }}">
        
        <div class="flex items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-slate-200 flex-shrink-0 items-center justify-center flex">
                    <i data-lucide="user" class="w-5 h-5 text-slate-400"></i>
                </div>
                <div>
                    <p class="font-semibold text-slate-800">{{ $user->firstName }} {{ $user->lastName }}</p>
                    <p class="text-sm text-slate-500">{{ $user->email }}</p>
                </div>
            </div>
            <span class="px-2.5 py-0.5 text-xs font-medium rounded-full shrink-0 {{ $user->status === 'banned' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                {{ ucfirst($user->status) }}
            </span>
        </div>

        <div class="mt-4 flex flex-wrap gap-2">
            <a href="{{ route('admin.users.edit', $user->user_id) }}"
                class="flex-1 text-center bg-slate-100 text-slate-700 rounded-lg px-3 py-2 text-sm font-medium transition-colors hover:bg-slate-200">
                Edit
            </a>

            @if ($user->status !== 'banned')
            <form action="{{ route('admin.users.ban', $user) }}" method="POST"
                onsubmit="return confirm('Are you sure you want to ban this user?');" class="flex-1">
                @csrf
                <button type="submit"
                    class="w-full text-center bg-red-100 text-red-700 rounded-lg px-3 py-2 text-sm font-medium transition-colors hover:bg-red-200">
                    Ban
                </button>
            </form>
            @else
            <form action="{{ route('admin.users.unban', $user) }}" method="POST" class="flex-1">
                @csrf
                <button type="submit"
                    class="w-full text-center bg-green-100 text-green-700 rounded-lg px-3 py-2 text-sm font-medium transition-colors hover:bg-green-200">
                    Unban
                </button>
            </form>
            @endif

            @if (!$user->is_admin)
            <form action="{{ route('admin.users.promote', $user->email) }}" method="POST"
                onsubmit="return confirm('Promote this user to admin?');" class="flex-1">
                @csrf
                <button type="submit"
                    class="w-full text-center bg-sky-100 text-sky-700 rounded-lg px-3 py-2 text-sm font-medium transition-colors hover:bg-sky-200">
                    Promote
                </button>
            </form>
            @else
            <form action="{{ route('admin.users.demote', $user->email) }}" method="POST"
                onsubmit="return confirm('Demote this admin to user?');" class="flex-1">
                @csrf
                <button type="submit"
                    class="w-full text-center bg-orange-100 text-orange-700 rounded-lg px-3 py-2 text-sm font-medium transition-colors hover:bg-orange-200">
                    Demote
                </button>
            </form>
            @endif
        </div>
    </div>
    @empty
    <div class="text-center py-12 text-slate-500">
        <i data-lucide="users" class="w-12 h-12 mx-auto text-slate-300"></i>
        <h3 class="mt-2 text-sm font-medium text-slate-600">No Users Found</h3>
    </div>
    @endforelse
</div>

                </div>
            </div>
        </main>
    </div>

    <script>
        lucide.createIcons();

        // --- Mobile Sidebar & Overlay ---
        const sidebar = document.getElementById('sidebar');
        const openSidebarBtn = document.getElementById('openSidebar');
        const mobileOverlay = document.getElementById('mobileOverlay');

        const openSidebar = () => { sidebar.classList.remove('-translate-x-full'); mobileOverlay.classList.remove('hidden'); };
        const closeSidebar = () => { sidebar.classList.add('-translate-x-full'); mobileOverlay.classList.add('hidden'); };

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

        // --- User Filtering and Searching ---
        const filterCards = document.querySelectorAll('.filter-card');
        const searchInput = document.getElementById('userSearch');
        const userRows = document.querySelectorAll('.user-row');

        function applyFilters() {
            const activeFilterCard = document.querySelector('.filter-card.active-filter');
            const filterType = activeFilterCard ? activeFilterCard.dataset.type : 'all';
            const searchTerm = searchInput.value.toLowerCase();

            userRows.forEach(row => {
                const status = row.dataset.status;
                const role = row.dataset.role;
                const name = row.dataset.name;
                const email = row.dataset.email;

                const filterMatch = (filterType === 'all') ||
                                  (filterType === 'admin' && role === 'admin') ||
                                  (status === filterType);

                const searchMatch = name.includes(searchTerm) || email.includes(searchTerm);

                if (filterMatch && searchMatch) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        filterCards.forEach(card => {
            card.addEventListener('click', () => {
                filterCards.forEach(c => c.classList.remove('active-filter'));
                card.classList.add('active-filter');
                applyFilters();
            });
        });

        searchInput.addEventListener('input', applyFilters);

        // Initial filter apply on page load
        applyFilters();

    </script>
</body>
</html>