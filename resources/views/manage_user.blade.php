<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gray-100 text-gray-900 font-sans">
    <div class="min-h-screen flex relative">

        <!-- Sidebar Backdrop -->
        <div id="sidebarBackdrop" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden md:hidden"></div>

        <!-- Sidebar -->
           <div id="sidebar"
            class="sidebar bg-white border-r border-gray-200 w-60 fixed md:static inset-y-0 left-0 z-50 md:z-auto flex flex-col">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">

                        <div class="flex items-center gap-3">
                            <img
                                class="shrink-0 w-[160.64px] h-10 relative"
                                style="object-fit: cover"
                                src="/assets/askly-high-resolution-logo-transparent.png" />
                        </div>
                    </div>
                    <button id="closeSidebar" class="md:hidden p-1 rounded-lg hover:bg-gray-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <nav class="flex-1 p-6">
                <div class="space-y-6">
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-3">MAIN MENU</p>
                        <div class="space-y-1">
                            <a href="{{ route('dashboard') }}"
                                class="flex items-center gap-3 px-3 py-2 text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 5a2 2 0 012-2h4a2 2 0 012 2v.01"></path>
                                </svg>
                                <span class="font-medium text-sm">Dashboard</span>
                            </a>
                            <a href="{{ route('admin.articles.index') }}" class="flex items-center gap-3 px-3 py-2 text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z" />
                                </svg>
                                <span class="font-medium text-sm">Manage Articles</span>
                            </a>
                            <a href="{{ route('admin.manage.users') }}"
                                class="flex items-center gap-3 px-3 py-2 bg-blue-500 text-white rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                                    </path>
                                </svg>
                                <span class="font-medium text-sm">Manage Users</span>
                            </a>
                            
                        </div>
                    </div>

                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-3">SETTINGS</p>
                        <div class="space-y-1">
                            <a href="{{ route('admin.settings') }}"
                                class="flex items-center gap-3 px-3 py-2 text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span class="font-medium text-sm">Settings</span>
                            </a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            <!-- Header -->
         <header class="flex justify-between items-center mb-6">
    <div class="flex items-center gap-3">
        <button id="openSidebar" class="md:hidden p-2 rounded hover:bg-gray-200">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
        <h1 class="text-xl font-bold">Manage Users</h1>
    </div>

    <!-- Admin Profile + Search -->
  @php
    use Illuminate\Support\Facades\Auth;
    $admin = Auth::guard('admin')->user();
@endphp

<div class="relative group">
    <div tabindex="0" class="flex items-center gap-3 cursor-pointer focus:outline-none">
        @if ($admin && $admin->photo)
            <img src="{{ asset('storage/' . $admin->photo) }}" class="w-9 h-9 rounded-full object-cover" alt="Admin Photo">
        @else
            <div class="w-9 h-9 bg-blue-500 rounded-full flex items-center justify-center">
                <span class="text-white font-medium text-sm">
                    {{ strtoupper(substr($admin->firstName, 0, 1)) ?? '?' }}{{ strtoupper(substr($admin->lastName, 0, 1)) ?? '?' }}
                </span>
            </div>
        @endif
        <span class="font-medium text-sm text-gray-900 hidden sm:block">
            {{ $admin->firstName }} {{ $admin->lastName }}
        </span>
    </div>

    <!-- Dropdown (Tailwind-only with :focus-within) -->
    <div tabindex="0"
         class="absolute right-0 mt-2 w-40 bg-white rounded-md shadow-lg opacity-0 pointer-events-none group-focus-within:opacity-100 group-focus-within:pointer-events-auto transition-all duration-150">
        <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg opacity-0 pointer-events-none group-focus-within:opacity-100 group-focus-within:pointer-events-auto transition-all duration-150">
    <a href="{{ route('admin.settings') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
        Settings
    </a>
    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
        Activity Log
    </a>
    <form method="POST" action="{{ route('admin.logout') }}">
        @csrf
        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
            Log Out
        </button>
    </form>
</div>

    </div>
</div>

</header>


            <!-- User Stats -->
            <div id="filterStats" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white p-4 shadow rounded-lg border cursor-pointer filter-card" data-type="all">
                    <p class="text-sm text-gray-500">Total Users</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalUsers }}</p>
                </div>
                <div class="bg-white p-4 shadow rounded-lg border cursor-pointer filter-card" data-type="active">
                    <p class="text-sm text-gray-500">Active Users</p>
                    <p class="text-2xl font-bold text-green-600">{{ $activeUsers }}</p>
                </div>
                <div class="bg-white p-4 shadow rounded-lg border cursor-pointer filter-card" data-type="banned">
                    <p class="text-sm text-gray-500">Banned Users</p>
                    <p class="text-2xl font-bold text-red-600">{{ $bannedUsers }}</p>
                </div>
                <div class="bg-white p-4 shadow rounded-lg border cursor-pointer filter-card" data-type="admin">
                    <p class="text-sm text-gray-500">Admins</p>
                    <p class="text-2xl font-bold text-purple-600">{{ $adminCount }}</p>
                </div>
            </div>

            <!-- User Table -->
            <div class="overflow-auto bg-white shadow rounded-lg border border-gray-200">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 text-left">
                        <tr>
                            <th class="p-4">#</th>
                            <th class="p-4">Name</th>
                            <th class="p-4">Email</th>
                            <th class="p-4">Role</th>
                            <th class="p-4">Status</th>
                            <th class="p-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="userTableBody">
                        @foreach($users as $index => $user)
                            <tr class="border-t hover:bg-gray-50"
                                data-status="{{ $user->status }}"
                                data-role="{{ $user->is_admin ? 'admin' : 'user' }}">
                                <td class="p-4">{{ $index + 1 }}</td>
                                <td class="p-4">{{ $user->firstName }} {{ $user->lastName }}</td>
                                <td class="p-4">{{ $user->email }}</td>
                                <td class="p-4">{{ $user->is_admin ? 'Admin' : 'User' }}</td>
                                <td class="p-4">
                                    <span class="px-2 py-1 rounded-full text-xs {{ $user->status === 'banned' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                        {{ ucfirst($user->status) }}
                                    </span>
                                </td>
                                <td class="p-4 space-x-2">
                                   {{-- <a href="#" class="text-blue-600 hover:underline">Edit</a> --}}
                             <a href="{{ route('admin.users.edit', $user->user_id) }}" class="text-blue-600 hover:underline">Edit</a>



                                    @if ($user->status === 'banned')
                                        <form action="{{ route('admin.users.unban', ['user' => $user]) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:underline">Unban</button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.users.ban', ['user' => $user]) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-red-600 hover:underline">Ban</button>
                                        </form>
                                    @endif

                                    @if (!$user->is_admin)
                                        <form action="{{ route('admin.users.promote', ['email' => $user->email]) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-purple-600 hover:underline">Promote</button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.users.demote', ['email' => $user->email]) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-orange-600 hover:underline">Demote</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    
                </table>
            </div>
        </main>
    </div>

    <!-- Scripts -->
    <script>
        const sidebar = document.getElementById('sidebar');
        const sidebarBackdrop = document.getElementById('sidebarBackdrop');
        const openBtn = document.getElementById('openSidebar');
        const closeBtn = document.getElementById('closeSidebar');

        openBtn?.addEventListener('click', () => {
            sidebar.classList.remove('-translate-x-full');
            sidebarBackdrop.classList.remove('hidden');
        });

        closeBtn?.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            sidebarBackdrop.classList.add('hidden');
        });

        sidebarBackdrop?.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            sidebarBackdrop.classList.add('hidden');
        });

        // Reset sidebar if resizing to desktop
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768) {
                sidebar.classList.remove('-translate-x-full');
                sidebarBackdrop.classList.add('hidden');
            }
        });

       function editUser(id) {
    // Navigate to the edit page
    window.location.href = `/admin/users/${id}/edit`;

}

        // Filter Logic
        document.querySelectorAll('.filter-card').forEach(card => {
            card.addEventListener('click', () => {
                const type = card.getAttribute('data-type');
                const rows = document.querySelectorAll('#userTableBody tr');

                rows.forEach(row => {
                    const status = row.getAttribute('data-status');
                    const role = row.getAttribute('data-role');

                    if (type === 'all') {
                        row.style.display = '';
                    } else if (type === 'admin') {
                        row.style.display = role === 'admin' ? '' : 'none';
                    } else {
                        row.style.display = status === type ? '' : 'none';
                    }
                });
            });
        });
    </script>
</body>
</html>