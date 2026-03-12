<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Settings</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in { animation: fadeIn 0.5s ease-out; }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">
    <div class="flex min-h-screen">
       <div id="sidebar" class="w-64 fixed inset-y-0 left-0 z-50 flex flex-col bg-white border-r border-slate-200 transition-transform duration-300 ease-in-out -translate-x-full lg:translate-x-0">
    <!-- Logo -->
    <div class="px-6 py-4 border-b border-slate-200">
        <a href="#" class="flex items-center gap-2">
            <img src="/assets/askly-high-resolution-logo-transparent.png" class="h-8 object-contain" alt="Askly Logo" />
        </a>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 flex flex-col justify-between p-4 space-y-4">
        <div class="space-y-6">
            <!-- Main Menu -->
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
                    <a href="/manage_user" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-slate-600 rounded-lg hover:bg-slate-100 transition-colors">
                        <i data-lucide="users" class="w-5 h-5"></i>
                        <span>Manage Users</span>
                    </a>
                </div>
            </div>

            <!-- Settings -->
            <div>
                <p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Admin</p>
                <a href="/admin_setting"  class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium rounded-lg bg-blue-50 text-blue-600 border-l-4 border-blue-600">
                    <i data-lucide="settings" class="w-5 h-5"></i>
                    <span>Settings</span>
                </a>
            </div>
        </div>

        <!-- Profile Info -->
        <div class="pt-4 border-t border-slate-200">
            @php $admin = Auth::guard('admin')->user(); @endphp
            <div class="flex items-center gap-3">
                @if ($admin && $admin->photo)
                    <img src="{{ asset('storage/' . $admin->photo) }}" class="w-10 h-10 rounded-full object-cover" alt="Admin Photo">
                @else
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-semibold">
                        {{ strtoupper(substr($admin->firstName, 0, 1)) ?? '?' }}{{ strtoupper(substr($admin->lastName, 0, 1)) ?? '?' }}
                    </div>
                @endif
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-slate-800 truncate">{{ $admin->firstName }} {{ $admin->lastName }}</p>
                    <p class="text-xs text-slate-500 truncate">{{ $admin->email }}</p>
                </div>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="p-2 text-slate-500 hover:bg-slate-100 hover:text-red-600 rounded-lg transition-colors">
                        <i data-lucide="log-out" class="w-5 h-5"></i>
                    </button>
                </form>
            </div>
        </div>
    </nav>
</div>


        <main class="flex-1 md:ml-60 p-4 lg:p-6">
            <div class="max-w-4xl mx-auto">
                <!-- Header Section -->
                <div class="mb-8">
                    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Admin Account Settings</h1>
                    <p class="text-gray-600">Manage your account preferences and security settings</p>
                </div>

                <!-- Flash Messages -->
                @if (session('success'))
                    <div class="bg-green-50 border-l-4 border-green-400 text-green-800 px-6 py-4 rounded-lg mb-6 relative fade-in shadow-sm">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <strong class="font-semibold">Success!</strong> {{ session('success') }}
                            </div>
                        </div>
                        <button onclick="this.parentElement.remove()" class="absolute top-4 right-4 text-green-600 hover:text-green-800 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-50 border-l-4 border-red-400 text-red-800 px-6 py-4 rounded-lg mb-6 relative fade-in shadow-sm">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <strong class="font-semibold">Error!</strong> {{ session('error') }}
                            </div>
                        </div>
                        <button onclick="this.parentElement.remove()" class="absolute top-4 right-4 text-red-600 hover:text-red-800 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                @endif

                <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf

                    <!-- Profile Section -->
                    <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden fade-in">
                        <div class="px-6 py-5 border-b border-gray-200 bg-gray-50">
                            <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                                <svg class="w-6 h-6 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Profile Photo
                            </h2>
                            <p class="text-sm text-gray-600 mt-1">Update your profile picture</p>
                        </div>
                        <div class="p-6">
                            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">
                                <div class="relative">
                                    @if(Auth::guard('admin')->user()->photo)
                                        <img src="{{ asset('storage/' . Auth::guard('admin')->user()->photo) }}" 
                                             class="h-20 w-20 rounded-full object-cover border-4 border-gray-100 shadow-md">
                                    @else
                                        <div class="h-20 w-20 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 border-4 border-gray-100 shadow-md">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-blue-600 rounded-full border-2 border-white flex items-center justify-center">
                                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1 w-full">
                                    <input type="file" name="photo" 
                                           class="block w-full text-sm text-gray-500 
                                                  file:mr-4 file:py-3 file:px-4 
                                                  file:rounded-lg file:border-0 
                                                  file:text-sm file:font-medium
                                                  file:bg-blue-50 file:text-blue-700 
                                                  hover:file:bg-blue-100 file:cursor-pointer
                                                  border border-gray-300 rounded-lg
                                                  focus:ring-2 focus:ring-blue-500 focus:border-transparent
                                                  transition-all duration-200">
                                    <p class="text-xs text-gray-500 mt-2">PNG, JPG up to 2MB</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Basic Info -->
                    <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden fade-in">
                        <div class="px-6 py-5 border-b border-gray-200 bg-gray-50">
                            <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                                <svg class="w-6 h-6 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Personal Information
                            </h2>
                            <p class="text-sm text-gray-600 mt-1">Update your personal details</p>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                                    <input type="text" name="firstName" value="{{ old('firstName', Auth::guard('admin')->user()->firstName) }}"
                                        class="w-full border border-gray-300 px-4 py-3 rounded-lg shadow-sm 
                                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                                               transition-all duration-200 hover:border-gray-400">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                                    <input type="text" name="lastName" value="{{ old('lastName', Auth::guard('admin')->user()->lastName) }}"
                                        class="w-full border border-gray-300 px-4 py-3 rounded-lg shadow-sm 
                                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                                               transition-all duration-200 hover:border-gray-400">
                                </div>
                                <div class="lg:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                                    <div class="relative">
                                        <input type="email" name="email" value="{{ old('email', Auth::guard('admin')->user()->email) }}"
                                            class="w-full border border-gray-300 px-4 py-3 pl-10 rounded-lg shadow-sm 
                                                   focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                                                   transition-all duration-200 hover:border-gray-400">
                                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Password Section -->
                    <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden fade-in">
                        <div class="px-6 py-5 border-b border-gray-200 bg-gray-50">
                            <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                                <svg class="w-6 h-6 mr-3 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                Security Settings
                            </h2>
                            <p class="text-sm text-gray-600 mt-1">Update your password and security preferences</p>
                        </div>
                        <div class="p-6 space-y-6">
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                                    <div class="relative">
                                        <input type="password" name="password"
                                            class="w-full border border-gray-300 px-4 py-3 pl-10 rounded-lg shadow-sm 
                                                   focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                                                   transition-all duration-200 hover:border-gray-400">
                                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                                    <div class="relative">
                                        <input type="password" name="password_confirmation"
                                            class="w-full border border-gray-300 px-4 py-3 pl-10 rounded-lg shadow-sm 
                                                   focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                                                   transition-all duration-200 hover:border-gray-400">
                                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Current Password <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="password" name="current_password" required
                                        class="w-full border border-gray-300 px-4 py-3 pl-10 rounded-lg shadow-sm 
                                               focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent
                                               transition-all duration-200 hover:border-gray-400">
                                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Friendly Reminder: Required to save any changes</p>
                            </div>

                            <!-- 2FA Toggle Placeholder -->
                            <div class="pt-4 border-t border-gray-200">
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div class="flex items-center">
                                        <input id="two_factor" type="checkbox" name="two_factor" 
                                               class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" disabled>
                                        <label for="two_factor" class="ml-3 text-sm font-medium text-gray-700">
                                            Enable Two-Factor Authentication
                                        </label>
                                    </div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Coming Soon
                                    </span>
                                </div>
                                <p class="text-xs text-gray-500 mt-2">Add an extra layer of security to your account</p>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-6 fade-in">
                        <button type="submit"
                            class="flex-1 sm:flex-none bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg transition-all duration-200 transform hover:scale-105 shadow-md hover:shadow-lg flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Save Changes
                        </button>
                        <button type="button"
                            class="flex-1 sm:flex-none bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-3 px-8 rounded-lg transition-all duration-200 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Cancel
                        </button>
                    </div>
                </form>

                <!-- Recent Activity -->
                <div class="mt-12 fade-in">
                    <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden">
                        <div class="px-6 py-5 border-b border-gray-200 bg-gray-50">
                            <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                                <svg class="w-6 h-6 mr-3 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Recent Activity
                            </h2>
                            <p class="text-sm text-gray-600 mt-1">Your recent account activities</p>
                        </div>
                        <ul class="divide-y divide-gray-200">
                            <li class="p-6 hover:bg-gray-50 transition-colors duration-150">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900">Logged in from Chrome on macOS</p>
                                        <p class="text-sm text-gray-500">Today at 2:30 PM</p>
                                    </div>
                                </div>
                            </li>
                            <li class="p-6 hover:bg-gray-50 transition-colors duration-150">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900">Updated profile settings</p>
                                        <p class="text-sm text-gray-500">Yesterday at 4:15 PM</p>
                                    </div>
                                </div>
                            </li>
                            <li class="p-6 hover:bg-gray-50 transition-colors duration-150">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900">Approved article "AI and the Future"</p>
                                        <p class="text-sm text-gray-500">2 days ago at 10:20 AM</p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
<script>
        lucide.createIcons();

</script>
</html>