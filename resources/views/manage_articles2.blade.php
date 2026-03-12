<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Manage Articles - Admin Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
        
        /* Modern Laravel Pagination Styles */
        .pagination { display: flex; list-style-type: none; }
        .pagination li a, .pagination li span {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            margin: 0 2px;
            border: 1px solid #e5e7eb;
            color: #4b5563;
            background-color: #fff;
            min-width: 2.25rem;
            height: 2.25rem;
            font-size: 0.875rem;
            font-weight: 500;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
        }
        .pagination li a:hover {
            border-color: #3b82f6;
            background-color: #eff6ff;
            color: #2563eb;
        }
        .pagination li.active span {
            z-index: 1;
            color: #fff;
            background-color: #3b82f6;
            border-color: #3b82f6;
        }
        .pagination li.disabled span {
            color: #9ca3af;
            background-color: #f9fafb;
            cursor: not-allowed;
        }

        /* Professional Button Animations */
        .btn-approve {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            position: relative;
            overflow: hidden;
        }
        .btn-approve::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        .btn-approve:hover::before {
            left: 100%;
        }

        .btn-reject {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            position: relative;
            overflow: hidden;
        }
        .btn-reject::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        .btn-reject:hover::before {
            left: 100%;
        }

        .btn-approved {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            position: relative;
        }
        .btn-approved::after {
            content: '✓';
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            font-weight: bold;
        }

        /* Loading spinner */
        .spinner {
            border: 2px solid #f3f4f6;
            border-top: 2px solid #3b82f6;
            border-radius: 50%;
            width: 16px;
            height: 16px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Professional confirmation modal */
        .modal-backdrop {
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
        }

        .modal-content {
            transform: scale(0.9);
            opacity: 0;
            transition: all 0.3s ease;
        }

        .modal-content.show {
            transform: scale(1);
            opacity: 1;
        }

        /* Status badge animations */
        .status-badge {
            transition: all 0.3s ease;
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
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.6s;
        }
        .status-badge:hover::before {
            left: 100%;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800">
    <!-- Confirmation Modal -->
    <div id="confirmationModal" class="fixed inset-0 z-50 hidden">
        <div class="modal-backdrop absolute inset-0"></div>
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="modal-content bg-white rounded-2xl shadow-2xl max-w-md w-full border border-slate-200">
                <div class="p-6">
                    <div class="flex items-center justify-center w-12 h-12 mx-auto mb-4 rounded-full" id="modalIcon">
                        <!-- Icon will be inserted here -->
                    </div>
                    <h3 class="text-lg font-semibold text-slate-900 text-center mb-2" id="modalTitle"></h3>
                    <p class="text-sm text-slate-600 text-center mb-6" id="modalMessage"></p>
                    <div class="flex gap-3">
                        <button id="modalCancel" class="flex-1 px-4 py-2.5 text-sm font-medium text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-lg transition-colors">
                            Cancel
                        </button>
                        <button id="modalConfirm" class="flex-1 px-4 py-2.5 text-sm font-medium text-white rounded-lg transition-colors">
                            Confirm
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                            <a href="{{ route('admin.articles.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium rounded-lg bg-blue-50 text-blue-600 border-l-4 border-blue-600">
                                <i data-lucide="file-text" class="w-5 h-5"></i>
                                <span>Manage Articles</span>
                            </a>
                            <a href="/manage_user" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-slate-600 rounded-lg hover:bg-slate-100 transition-colors">
                                <i data-lucide="users" class="w-5 h-5"></i>
                                <span>Manage Users</span>
                            </a>
                             <div>
                        <p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Admin</p>
                        <a href="{{ route('admin.settings') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-slate-600 rounded-lg hover:bg-slate-100 transition-colors">
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
        <div class="flex-1 lg:ml-64 flex flex-col">
            <!-- Header -->
            <header class="h-16 bg-white/80 backdrop-blur-sm border-b border-slate-200 px-4 sm:px-6 flex items-center justify-between sticky top-0 z-30">
                 <div class="flex items-center gap-4">
                    <button id="openSidebar" aria-label="Open sidebar" class="lg:hidden p-2 -ml-2 text-slate-600 hover:bg-slate-100 rounded-lg">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </button>
                    <div>
                        <h1 class="text-xl font-bold text-slate-900">Manage Articles</h1>
                        <p class="text-sm text-slate-500 hidden sm:block">Review, approve, or reject user-submitted articles.</p>
                    </div>
                </div>
                <!-- Profile and Actions -->
                @php $admin = Auth::guard('admin')->user(); @endphp
                <div class="flex items-center gap-4">
                <form method="GET" action="{{ route('admin.articles.index') }}" class="relative hidden sm:block w-64">
                        <i data-lucide="search" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input
                            type="search"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search articles..."
                            class="w-full pl-9 pr-4 py-2 text-sm bg-slate-100 border border-transparent rounded-lg focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all"
                        />
                    </form>

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
                                <div class="px-3 py-2">
                                    <p class="text-sm font-semibold text-slate-800">{{ $admin->firstName }} {{ $admin->lastName }}</p>
                                    <p class="text-xs text-slate-500 truncate">{{ $admin->email }}</p>
                                </div>
                                <hr class="my-1 border-slate-200">
                                <a href="{{ route('admin.settings') }}" class="flex items-center gap-3 px-3 py-2 text-sm text-slate-700 hover:bg-slate-100 rounded-md transition-colors"><i data-lucide="settings" class="w-4 h-4"></i><span>Account Settings</span></a>
                                <form method="POST" action="{{ route('admin.logout') }}">@csrf<button type="submit" class="flex items-center gap-3 w-full px-3 py-2 text-sm text-red-600 hover:bg-red-50 rounded-md transition-colors"><i data-lucide="log-out" class="w-4 h-4"></i><span>Log Out</span></button></form>
                            </div>
                        </div>
                    </div>

                    
                </div>
                
            </header>

            <!-- Scrollable Content -->
            <main class="flex-1 p-4 sm:p-6 overflow-y-auto">
                <!-- Filters and Actions -->
               <div class="p-4  mb-6">
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
        <!-- Left Side: Statused Articles Button -->
        <div class="w-full lg:w-auto">
            <a href="{{ route('admin.articles.statused') }}"
               class="inline-block w-full lg:w-auto text-center px-5 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                View Statused Articles
            </a>
        </div>

        <!-- Right Side: Filters -->
        <form method="GET" action="{{ route('admin.articles.index') }}" class="flex flex-col sm:flex-row items-start sm:items-center gap-4 w-full lg:w-auto">
            <div class="w-full sm:w-60">
                <label for="category" class="block text-sm font-medium text-slate-700 mb-1">Filter by Category:</label>
                <select name="category" id="category" onchange="this.form.submit()"
                        class="block w-full text-sm rounded-lg border border-slate-300 focus:ring-blue-500 focus:border-blue-500 px-4 py-2">
                    <option value="">All Categories</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>
</div>


                <!-- Articles List Container -->
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                    <!-- Desktop Table -->
                    <div class="hidden lg:block">
                        <table class="w-full text-sm text-left text-slate-500">
                            <thead class="text-xs text-slate-700 uppercase bg-slate-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Title</th>
                                    <th scope="col" class="px-6 py-3">Author</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                    <th scope="col" class="px-6 py-3">Submitted</th>
                                    <th scope="col" class="px-6 py-3 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200">
                                @forelse ($articles as $article)
                                <tr class="bg-white hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4 font-medium text-slate-900 max-w-sm truncate">{{ $article->title }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            @if($article->user && $article->user->photo)
                                                <img src="{{ asset('storage/' . $article->user->photo) }}" class="w-8 h-8 rounded-full object-cover" alt="">
                                            @else
                                                <div class="w-8 h-8 rounded-full bg-slate-200 flex-shrink-0 items-center justify-center flex"><i data-lucide="user" class="w-4 h-4 text-slate-400"></i></div>
                                            @endif
                                            <span>{{ $article->user->firstName ?? 'N/A' }} {{ $article->user->lastName ?? '' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $statusClasses = [
                                                'pending' => 'bg-amber-100 text-amber-800 border-amber-200', 
                                                'approved' => 'bg-green-100 text-green-800 border-green-200', 
                                                'rejected' => 'bg-red-100 text-red-800 border-red-200',
                                            ];
                                        @endphp
                                        <span class="status-badge px-3 py-1 text-xs font-semibold rounded-full border {{ $statusClasses[$article->status] ?? 'bg-slate-100 text-slate-800 border-slate-200' }}">
                                            {{ ucfirst($article->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-slate-600">{{ $article->created_at->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center items-center gap-2">
                                            @if($article->status === 'approved')
                                                <button type="button" disabled class="btn-approved px-4 py-2 text-sm font-semibold text-white rounded-lg shadow-sm cursor-not-allowed transition-all duration-200">
                                                    <span class="flex items-center gap-2">
                                                        <i data-lucide="check" class="w-4 h-4"></i>
                                                        Approved
                                                    </span>
                                                </button>
                                            @else
                                                <form method="POST" action="{{ route('admin.articles.approve', $article->id) }}" class="approve-form">
                                                    @csrf
                                                    <button type="submit" class="btn-approve px-4 py-2 text-sm font-semibold text-white rounded-lg shadow-sm hover:shadow-md transform hover:scale-105 transition-all duration-200">
                                                        <span class="flex items-center gap-2">
                                                            <i data-lucide="check" class="w-4 h-4"></i>
                                                            Approve
                                                        </span>
                                                    </button>
                                                </form>
                                            @endif

                                            <form method="POST" action="{{ route('admin.articles.reject', $article->id) }}" class="reject-form">
                                                @csrf
                                                <button type="submit" class="btn-reject px-4 py-2 text-sm font-semibold text-white rounded-lg shadow-sm hover:shadow-md transform hover:scale-105 transition-all duration-200">
                                                    <span class="flex items-center gap-2">
                                                        <i data-lucide="x" class="w-4 h-4"></i>
                                                        Reject
                                                    </span>
                                                </button>
                                            </form>
                                            
                                            <a href="{{ route('admin.articles.show', $article->id) }}" class="p-2 text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-lg transition-colors" title="View Article">
                                                <i data-lucide="eye" class="w-4 h-4"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="5" class="text-center py-12 text-slate-500">No articles found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Card View -->
                    <div class="block lg:hidden divide-y divide-slate-100">
                        @forelse ($articles as $article)
                        <div class="p-4 hover:bg-slate-50 transition-colors">
                            <div class="flex justify-between items-start gap-3 mb-3">
                                <h3 class="font-semibold text-slate-800 text-base">{{ $article->title }}</h3>
                                <span class="status-badge px-3 py-1 text-xs font-semibold rounded-full border shrink-0 {{ $statusClasses[$article->status] ?? 'bg-slate-100 text-slate-800 border-slate-200' }}">
                                    {{ ucfirst($article->status) }}
                                </span>
                            </div>
                            <div class="text-sm text-slate-500 mb-4">
                                By {{ $article->user->firstName ?? 'N/A' }} • {{ $article->created_at->diffForHumans() }}
                            </div>
                            <div class="flex gap-2">
                                @if($article->status === 'approved')
                                    <button type="button" disabled class="btn-approved flex-1 px-4 py-2.5 text-sm font-semibold text-white rounded-lg shadow-sm cursor-not-allowed">
                                        <span class="flex items-center justify-center gap-2">
                                            <i data-lucide="check" class="w-4 h-4"></i>
                                            Approved
                                        </span>
                                    </button>
                                @else
                                    <form method="POST" action="{{ route('admin.articles.approve', $article->id) }}" class="approve-form flex-1">
                                        @csrf
                                        <button type="submit" class="btn-approve w-full px-4 py-2.5 text-sm font-semibold text-white rounded-lg shadow-sm hover:shadow-md transform hover:scale-105 transition-all duration-200">
                                            <span class="flex items-center justify-center gap-2">
                                                <i data-lucide="check" class="w-4 h-4"></i>
                                                Approve
                                            </span>
                                        </button>
                                    </form>
                                @endif

                                <form method="POST" action="{{ route('admin.articles.reject', $article->id) }}" class="reject-form flex-1">
                                    @csrf
                                    <button type="submit" class="btn-reject w-full px-4 py-2.5 text-sm font-semibold text-white rounded-lg shadow-sm hover:shadow-md transform hover:scale-105 transition-all duration-200">
                                        <span class="flex items-center justify-center gap-2">
                                            <i data-lucide="x" class="w-4 h-4"></i>
                                            Reject
                                        </span>
                                    </button>
                                </form>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-12 text-slate-500">No articles found.</div>
                        @endforelse
                    </div>
                </div>

                <!-- Pagination -->
                @if ($articles->hasPages())
                <div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4 text-sm text-slate-500">
                    <div>Showing {{ $articles->firstItem() }} to {{ $articles->lastItem() }} of {{ $articles->total() }} results</div>
                    <div class="pagination">{{ $articles->links() }}</div>
                </div>
                @endif
            </main>
        </div>
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

        // --- Professional Confirmation Modal ---
        const modal = document.getElementById('confirmationModal');
        const modalIcon = document.getElementById('modalIcon');
        const modalTitle = document.getElementById('modalTitle');
        const modalMessage = document.getElementById('modalMessage');
        const modalConfirm = document.getElementById('modalConfirm');
        const modalCancel = document.getElementById('modalCancel');
        const modalContent = modal.querySelector('.modal-content');

        let currentForm = null;

        function showModal(type, title, message, confirmText, confirmClass) {
            currentForm = null;
            modalTitle.textContent = title;
            modalMessage.textContent = message;
            modalConfirm.textContent = confirmText;
            modalConfirm.className = `flex-1 px-4 py-2.5 text-sm font-medium text-white rounded-lg transition-colors ${confirmClass}`;
            
            if (type === 'approve') {
                modalIcon.innerHTML = '<i data-lucide="check-circle" class="w-6 h-6 text-green-600"></i>';
                modalIcon.className = 'flex items-center justify-center w-12 h-12 mx-auto mb-4 rounded-full bg-green-100';
            } else {
                modalIcon.innerHTML = '<i data-lucide="alert-triangle" class="w-6 h-6 text-red-600"></i>';
                modalIcon.className = 'flex items-center justify-center w-12 h-12 mx-auto mb-4 rounded-full bg-red-100';
            }
            
            lucide.createIcons();
            modal.classList.remove('hidden');
            setTimeout(() => modalContent.classList.add('show'), 10);
        }

        function hideModal() {
            modalContent.classList.remove('show');
            setTimeout(() => modal.classList.add('hidden'), 300);
        }

        modalCancel.addEventListener('click', hideModal);
        modal.addEventListener('click', (e) => {
            if (e.target === modal) hideModal();
        });

        modalConfirm.addEventListener('click', () => {
            if (currentForm) {
                hideModal();
                disableButtons(currentForm);
                currentForm.submit();
            }
        });

        // --- Form Submission Handlers ---
        document.querySelectorAll('.approve-form').forEach(form => {
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                currentForm = form;
                showModal(
                    'approve',
                    'Approve Article',
                    'Are you sure you want to approve this article? It will be published and visible to all users.',
                    'Approve Article',
                    'bg-green-600 hover:bg-green-700'
                );
            });
        });

        document.querySelectorAll('.reject-form').forEach(form => {
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                currentForm = form;
                showModal(
                    'reject',
                    'Reject Article',
                    'Are you sure you want to reject this article? This action cannot be undone and the author will be notified.',