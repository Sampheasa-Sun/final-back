  <div id="sidebar" class="bg-white border-r border-gray-200 w-60 flex-shrink-0 fixed lg:relative h-full lg:h-auto z-30 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out shadow-lg lg:shadow-none">
            <!-- Logo -->
            <div class="p-4 lg:p-6 border-b border-gray-200">
                <div class="flex items-center gap-3">
                    <div class="bg-blue-500 rounded-lg p-2">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2L3 7v11h4v-6h6v6h4V7l-7-5z" />
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-gray-800">Askly</span>
                </div>
            </div>

            <!-- Navigation -->
            <div class="px-4 lg:px-6 py-4 flex-1 overflow-y-auto">
                <div class="mb-6">
                    <div class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-3">
                        MAIN MENU
                    </div>
                    <nav class="space-y-1">
                        <a href="{{route('dashboard')}}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition-all">
                            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" />
                            </svg>
                            Dashboard
                        </a>
                        <a href="{{ route('admin.articles.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition-all">
                            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2v1a1 1 0 001 1h6a1 1 0 001-1V3a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                            </svg>
                            Manage Articles
                        </a>
                        <a href="/manage_user" class="flex items-center gap-3 px-3 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition-all">
                            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z" />
                            </svg>
                            Manage Users
                        </a>
                    </nav>
                </div>

                <div>
                    <div class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-3">
                        SETTINGS
                    </div>
                    <nav class="space-y-1">
                        <a href="#" class="flex items-center gap-3 px-3 py-2 text-sm font-medium text-white bg-blue-500 rounded-lg">
                            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                            </svg>
                            Settings
                        </a>
                    </nav>
                </div>
            </div>
        </div>