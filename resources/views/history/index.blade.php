<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='%2322c55e'><path fill-rule='evenodd' d='M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V4a2 2 0 00-2-2H6zm1 2a1 1 0 000 2h6a1 1 0 100-2H7zm6 7a1 1 0 00-1 1v1H7v-1a1 1 0 00-2 0v1a2 2 0 002 2h6a2 2 0 002-2v-1a1 1 0 00-1-1z' clip-rule='evenodd'/></svg>">
    <title>Calculation History - CalcHub</title>
    <script>
        // Theme detection
        (function() {
            const isDark = localStorage.getItem('color-theme') === 'dark' || 
                          (!('color-theme' in localStorage) && 
                           window.matchMedia('(prefers-color-scheme: dark)').matches);
            document.documentElement.classList.toggle('dark', isDark);
        })();
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            200: '#bbf7d0',
                            300: '#86efac',
                            400: '#4ade80',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                            800: '#166534',
                            900: '#14532d',
                        }
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-up': 'slideUp 0.6s ease-out',
                        'scale-in': 'scaleIn 0.4s ease-out',
                    }
                }
            }
        }
    </script>
    <style>
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes slideUp {
            from { 
                opacity: 0;
                transform: translateY(20px);
            }
            to { 
                opacity: 1;
                transform: translateY(0);
            }
        }
        @keyframes scaleIn {
            from { 
                opacity: 0;
                transform: scale(0.9);
            }
            to { 
                opacity: 1;
                transform: scale(1);
            }
        }
        
        .scroll-optimized {
            transform: translateZ(0);
            backface-visibility: hidden;
            perspective: 1000;
        }
        
        .transition-all-300 {
            transition: all 0.3s ease;
        }

        /* Custom scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
        
        .dark .custom-scrollbar::-webkit-scrollbar-track {
            background: #374151;
        }
        
        .dark .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #6b7280;
        }
        
        .dark .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }

        /* Pagination styles */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
        }
        
        .page-item {
            display: inline-block;
        }
        
        .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 2.5rem;
            height: 2.5rem;
            padding: 0 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            color: #374151;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        
        .page-link:hover {
            background-color: #f3f4f6;
            border-color: #9ca3af;
        }
        
        .page-item.active .page-link {
            background-color: #22c55e;
            border-color: #22c55e;
            color: white;
        }
        
        .page-item.disabled .page-link {
            color: #9ca3af;
            cursor: not-allowed;
            background-color: #f9fafb;
        }
        
        .dark .page-link {
            border-color: #4b5563;
            color: #d1d5db;
            background-color: #374151;
        }
        
        .dark .page-link:hover {
            background-color: #4b5563;
            border-color: #6b7280;
        }
        
        .dark .page-item.active .page-link {
            background-color: #22c55e;
            border-color: #22c55e;
            color: white;
        }
        
        .dark .page-item.disabled .page-link {
            color: #6b7280;
            background-color: #1f2937;
        }

        /* Active filter badge */
        .filter-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background-color: #dcfce7;
            color: #166534;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        .dark .filter-badge {
            background-color: #14532d;
            color: #86efac;
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 transition-colors duration-300 min-h-screen flex flex-col">
    <!-- Header/Navigation -->
    <header class="sticky top-0 z-50 bg-white/80 dark:bg-gray-800/80 backdrop-blur-md border-b border-gray-200 dark:border-gray-700 scroll-optimized">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <div class="w-8 h-8 bg-primary-500 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V4a2 2 0 00-2-2H6zm1 2a1 1 0 000 2h6a1 1 0 100-2H7zm6 7a1 1 0 00-1 1v1H7v-1a1 1 0 00-2 0v1a2 2 0 002 2h6a2 2 0 002-2v-1a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <span class="text-xl font-bold text-gray-800 dark:text-white">CalcHub</span>
            </div>

            <div class="flex items-center space-x-4">
                <!-- Navigation -->
                <nav class="hidden md:flex space-x-6 mr-4">
                    <a href="{{ route('dashboard') }}" class="text-gray-600 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition-smooth">Dashboard</a>
                    <a href="{{ route('home') }}" class="text-gray-600 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition-smooth">Tools</a>
                    <a href="{{ route('history.index') }}" class="text-primary-600 dark:text-primary-400 font-medium">History</a>
                </nav>

                <!-- Mobile menu button -->
                <button id="mobile-menu-button" class="md:hidden p-2 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                    </svg>
                </button>
                
                <!-- Dark mode toggle -->
                <button id="theme-toggle" class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 transition-all-300">
                    <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                    </svg>
                    <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path>
                    </svg>
                </button>
                
                <!-- User Menu -->
                <div class="relative group">
                    <button class="flex items-center space-x-2 bg-gray-100 dark:bg-gray-700 rounded-lg px-3 py-2 transition-all-300">
                        <div class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-white font-medium">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <span class="text-gray-700 dark:text-gray-300 font-medium hidden sm:inline">{{ Auth::user()->name }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 border border-gray-200 dark:border-gray-700">
                        {{-- <a href="{{ route('home') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"><i class="fas fa-calculator mr-2"></i>Tools</a> --}}
                        <a href="{{ route('profile') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"><i class="fas fa-user mr-2"></i>Profile</a>
                        <div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                <i class="fas fa-sign-out-alt mr-2"></i>Sign Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="md:hidden hidden bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 px-4 py-2">
            <nav class="flex flex-col space-y-2">
                <a href="{{ route('dashboard') }}" class="py-2 text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Dashboard</a>
                <a href="{{ route('home') }}" class="py-2 text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Tools</a>
                <a href="{{ route('history.index') }}" class="py-2 text-primary-600 dark:text-primary-400 font-medium">History</a>
            </nav>
        </div>
    </header>

    <!-- History Content -->
    <main class="flex-grow container mx-auto px-4 py-6">
        <!-- Welcome Section -->
        <div class="mb-8 animate-fade-in">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 dark:text-white mb-2">Calculation History 📊</h1>
            <p class="text-gray-600 dark:text-gray-400">Track and manage all your past calculations in one place</p>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
            <!-- Total Calculations -->
            <div class="bg-white dark:bg-gray-800 rounded-xl p-4 sm:p-6 shadow-sm border border-gray-200 dark:border-gray-700 animate-slide-up" style="animation-delay: 0.1s">
                <div class="flex items-center">
                    <div class="p-2 sm:p-3 rounded-lg bg-primary-100 dark:bg-primary-900 mr-3 sm:mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6 text-primary-600 dark:text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Calculations</p>
                        <p class="text-xl sm:text-2xl font-bold text-gray-800 dark:text-white">
                            {{ $quickStats['totalCalculations'] }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- This Week -->
            <div class="bg-white dark:bg-gray-800 rounded-xl p-4 sm:p-6 shadow-sm border border-gray-200 dark:border-gray-700 animate-slide-up" style="animation-delay: 0.2s">
                <div class="flex items-center">
                    <div class="p-2 sm:p-3 rounded-lg bg-primary-100 dark:bg-primary-900 mr-3 sm:mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6 text-primary-600 dark:text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">This Week</p>
                        <p class="text-xl sm:text-2xl font-bold text-gray-800 dark:text-white">
                            {{ $quickStats['calculationsThisWeek'] }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Favorite Calculator -->
            <div class="bg-white dark:bg-gray-800 rounded-xl p-4 sm:p-6 shadow-sm border border-gray-200 dark:border-gray-700 animate-slide-up" style="animation-delay: 0.3s">
                <div class="flex items-center">
                    <div class="p-2 sm:p-3 rounded-lg bg-primary-100 dark:bg-primary-900 mr-3 sm:mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6 text-primary-600 dark:text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Favorite Tool</p>
                        <p class="text-xl sm:text-2xl font-bold text-gray-800 dark:text-white truncate">
                            {{ $quickStats['favoriteCalculator'] }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Time Saved -->
            <div class="bg-white dark:bg-gray-800 rounded-xl p-4 sm:p-6 shadow-sm border border-gray-200 dark:border-gray-700 animate-slide-up" style="animation-delay: 0.4s">
                <div class="flex items-center">
                    <div class="p-2 sm:p-3 rounded-lg bg-primary-100 dark:bg-primary-900 mr-3 sm:mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6 text-primary-600 dark:text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Time Saved</p>
                        <p class="text-xl sm:text-2xl font-bold text-gray-800 dark:text-white">
                            {{ $quickStats['timeSaved'] }}h
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Bar -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 mb-6 p-4 sm:p-6 animate-scale-in">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="flex items-center space-x-4">
                    <h2 class="text-lg sm:text-xl font-bold text-gray-800 dark:text-white">All Calculations</h2>
                    <span class="bg-primary-100 dark:bg-primary-900 text-primary-800 dark:text-primary-200 text-sm font-medium px-3 py-1 rounded-full">
                        {{ $paginator->total() }} records
                    </span>
                    
                    <!-- Active Filters -->
                    @if(request('search') || (request('type') && request('type') !== 'all'))
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Active filters:</span>
                        @if(request('search'))
                        <span class="filter-badge">
                            Search: "{{ request('search') }}"
                            <button onclick="clearSearch()" class="text-red-500 hover:text-red-700">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </span>
                        @endif
                        @if(request('type') && request('type') !== 'all')
                        <span class="filter-badge">
                            Type: {{ request('type') }}
                            <button onclick="clearFilter()" class="text-red-500 hover:text-red-700">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </span>
                        @endif
                    </div>
                    @endif
                </div>
                
                <div class="flex flex-wrap gap-3">
                    <!-- Search Form -->
                    <form method="GET" action="{{ route('history.index') }}" class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search calculations..." class="pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors w-full sm:w-64">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 absolute left-3 top-2.5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                        @if(request('type'))
                        <input type="hidden" name="type" value="{{ request('type') }}">
                        @endif
                        @if(request('per_page'))
                        <input type="hidden" name="per_page" value="{{ request('per_page') }}">
                        @endif
                    </form>

                    <!-- Filter Dropdown -->
                    <div class="relative group">
                        <button class="flex items-center space-x-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-lg transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                            </svg>
                            <span>Filter</span>
                        </button>
                        <div class="absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-lg shadow-lg py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 border border-gray-200 dark:border-gray-700 max-h-96 overflow-y-auto">
                            <a href="{{ request()->fullUrlWithQuery(['type' => 'all', 'page' => 1]) }}" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors {{ !request('type') || request('type') == 'all' ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400' : '' }}">
                                All Types
                            </a>
                            @foreach($calculatorTypes as $type)
                            <a href="{{ request()->fullUrlWithQuery(['type' => $type, 'page' => 1]) }}" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors {{ request('type') == $type ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400' : '' }}">
                                {{ $type }}
                            </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Delete All Dropdown -->
                    <div class="relative group">
                        <button class="flex items-center space-x-2 bg-red-100 dark:bg-red-900/20 hover:bg-red-200 dark:hover:bg-red-900/30 text-red-700 dark:text-red-400 px-4 py-2 rounded-lg transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            <span>Delete</span>
                        </button>
                        <div class="absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-lg shadow-lg py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 border border-gray-200 dark:border-gray-700">
                            <a href="#" class="block px-4 py-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors" onclick="deleteAll('all')">
                                <i class="fas fa-trash mr-2"></i>Delete All Calculations
                            </a>
                            <div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>
                            <a href="#" class="block px-4 py-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors" onclick="deleteAll('BmiCalculation')">BMI Calculations</a>
                            <a href="#" class="block px-4 py-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors" onclick="deleteAll('CalorieCalculation')">Calorie Calculations</a>
                            <a href="#" class="block px-4 py-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors" onclick="deleteAll('CgpaCalculation')">CGPA Calculations</a>
                            <a href="#" class="block px-4 py-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors" onclick="deleteAll('CurrencyConversion')">Currency Conversions</a>
                            <a href="#" class="block px-4 py-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors" onclick="deleteAll('DateTimeCalculation')">Date Time Calculations</a>
                            <a href="#" class="block px-4 py-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors" onclick="deleteAll('LoanCalculation')">Loan Calculations</a>
                            <a href="#" class="block px-4 py-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors" onclick="deleteAll('PercentageCalculation')">Percentage Calculations</a>
                            <a href="#" class="block px-4 py-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors" onclick="deleteAll('ProfitLossCalculation')">Profit Loss Calculations</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Calculations Table -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 mb-6 animate-scale-in">
            <div class="p-4 sm:p-6">
                <div class="overflow-x-auto custom-scrollbar">
                    <table class="w-full text-sm table-auto min-w-[800px]">
                        <thead>
                            <tr class="text-left text-gray-500 dark:text-gray-400 border-b border-gray-200 dark:border-gray-700">
                                <th class="pb-3 font-medium w-[15%]">Calculator</th>
                                <th class="pb-3 font-medium w-[25%]">Name / Inputs</th>
                                <th class="pb-3 font-medium w-[25%]">Details</th>
                                <th class="pb-3 font-medium w-[15%]">Result</th>
                                <th class="pb-3 font-medium w-[15%]">Date</th>
                                <th class="pb-3 font-medium w-[5%]">Actions</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700" id="calculationsTableBody">
                            @forelse ($paginator as $calc)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors align-top calculation-row" data-type="{{ $calc['type'] }}">
                                    <td class="py-3 font-medium text-gray-800 dark:text-gray-200 break-words">
                                        <div class="flex items-center space-x-2">
                                            <span class="bg-primary-100 dark:bg-primary-900 text-primary-800 dark:text-primary-200 text-xs font-medium px-2.5 py-0.5 rounded">
                                                {{ $calc['type'] }}
                                            </span>
                                        </div>
                                    </td>

                                    <td class="py-3 text-gray-600 dark:text-gray-400 break-words">
                                        <div class="font-medium text-gray-800 dark:text-gray-200 mb-1">{{ $calc['name'] }}</div>
                                        <div class="text-sm whitespace-pre-line">{{ $calc['question'] }}</div>
                                    </td>

                                    <td class="py-3 text-gray-600 dark:text-gray-400 break-words">
                                        {{ $calc['description'] ?? 'N/A' }}
                                    </td>

                                    <td class="py-3 font-semibold text-gray-900 dark:text-gray-100 break-words">
                                        {{ $calc['result'] }}
                                    </td>

                                    <td class="py-3 text-gray-500 dark:text-gray-400 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($calc['date'])->diffForHumans() }}
                                    </td>

                                    <td class="py-3">
                                        <button class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 transition-colors delete-btn"
                                                data-model="{{ $calc['model'] }}" 
                                                data-id="{{ $calc['model_id'] }}"
                                                title="Delete calculation">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-8 text-center text-gray-500 dark:text-gray-400">
                                        <div class="flex flex-col items-center space-y-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <div class="text-lg font-medium text-gray-600 dark:text-gray-400">
                                                @if(request('search') || (request('type') && request('type') !== 'all'))
                                                    No calculations found matching your criteria
                                                @else
                                                    No calculations yet
                                                @endif
                                            </div>
                                            <p class="text-gray-500 dark:text-gray-400">
                                                @if(request('search') || (request('type') && request('type') !== 'all'))
                                                    Try adjusting your search or filter
                                                @else
                                                    Your calculation history will appear here
                                                @endif
                                            </p>
                                            <a href="{{ route('history.index') }}" class="text-primary-600 dark:text-primary-400 hover:underline font-medium">
                                                @if(request('search') || (request('type') && request('type') !== 'all'))
                                                    Clear filters
                                                @else
                                                    Start calculating →
                                                @endif
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        @if($paginator->hasPages())
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 sm:p-6 animate-scale-in">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    Showing 
                    <span class="font-medium">{{ $paginator->firstItem() ?? 0 }}</span>
                    to 
                    <span class="font-medium">{{ $paginator->lastItem() ?? 0 }}</span>
                    of 
                    <span class="font-medium">{{ $paginator->total() }}</span>
                    results
                </div>
                
                <nav class="pagination">
                    <!-- Previous Page Link -->
                    @if ($paginator->onFirstPage())
                        <span class="page-item disabled">
                            <span class="page-link">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" class="page-link">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @endif

                    <!-- Pagination Elements -->
                    @foreach ($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="page-item active">
                                <span class="page-link">{{ $page }}</span>
                            </span>
                        @else
                            <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                        @endif
                    @endforeach

                    <!-- Next Page Link -->
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" class="page-link">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @else
                        <span class="page-item disabled">
                            <span class="page-link">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    @endif
                </nav>

                <!-- Page Size Selector -->
                <div class="flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-400">
                    <span>Show:</span>
                    <select onchange="updatePageSize(this.value)" class="border border-gray-300 dark:border-gray-600 rounded px-2 py-1 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                        <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                    </select>
                    <span>per page</span>
                </div>
            </div>
        </div>
        @endif
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 dark:bg-gray-900 text-white py-6 sm:py-8">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center space-x-2 mb-4 md:mb-0">
                    <div class="w-6 h-6 bg-primary-500 rounded flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V4a2 2 0 00-2-2H6zm1 2a1 1 0 000 2h6a1 1 0 100-2H7zm6 7a1 1 0 00-1 1v1H7v-1a1 1 0 00-2 0v1a2 2 0 002 2h6a2 2 0 002-2v-1a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <span class="text-lg font-bold">CalcHub</span>
                </div>
                <div class="text-gray-400 text-sm text-center md:text-left">
                    &copy; 2023 CalcHub. All rights reserved.
                </div>
            </div>
        </div>
    </footer>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 m-4 max-w-sm w-full animate-scale-in">
            <div class="text-center">
                <div class="w-12 h-12 bg-red-100 dark:bg-red-900 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-2">Delete Calculation</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6">Are you sure you want to delete this calculation? This action cannot be undone.</p>
                <div class="flex space-x-3">
                    <button onclick="hideDeleteModal()" class="flex-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 py-2 px-4 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                        Cancel
                    </button>
                    <button id="confirmDelete" class="flex-1 bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition-colors">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Theme and mobile menu functionality
        document.addEventListener('DOMContentLoaded', function() {
            const themeToggle = document.getElementById('theme-toggle');
            const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
            const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');

            // Initialize theme icons
            if (document.documentElement.classList.contains('dark')) {
                themeToggleLightIcon.classList.remove('hidden');
            } else {
                themeToggleDarkIcon.classList.remove('hidden');
            }

            // Theme toggle
            themeToggle.addEventListener('click', function() {
                themeToggleDarkIcon.classList.toggle('hidden');
                themeToggleLightIcon.classList.toggle('hidden');
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                }
            });

            // Mobile menu toggle
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
            }

            // Auto-submit search form on input
            const searchInput = document.querySelector('input[name="search"]');
            if (searchInput) {
                let searchTimeout;
                searchInput.addEventListener('input', function(e) {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        this.form.submit();
                    }, 500);
                });
            }
        });

        // Update page size
        function updatePageSize(size) {
            const url = new URL(window.location.href);
            url.searchParams.set('per_page', size);
            url.searchParams.set('page', 1); // Reset to first page
            window.location.href = url.toString();
        }

        // Clear search
        function clearSearch() {
            const url = new URL(window.location.href);
            url.searchParams.delete('search');
            url.searchParams.set('page', 1);
            window.location.href = url.toString();
        }

        // Clear filter
        function clearFilter() {
            const url = new URL(window.location.href);
            url.searchParams.delete('type');
            url.searchParams.set('page', 1);
            window.location.href = url.toString();
        }

        // Delete functionality
        let deleteModel = '';
        let deleteId = '';

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('delete-btn') || e.target.closest('.delete-btn')) {
                const btn = e.target.classList.contains('delete-btn') ? e.target : e.target.closest('.delete-btn');
                deleteModel = btn.getAttribute('data-model');
                deleteId = btn.getAttribute('data-id');
                showDeleteModal();
            }
        });

        function showDeleteModal() {
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function hideDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        document.getElementById('confirmDelete').addEventListener('click', function() {
            deleteEntry(deleteModel, deleteId);
        });

        function deleteEntry(model, id) {
            fetch('{{ route("history.delete") }}', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    model: model,
                    id: id
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('Calculation deleted successfully', 'success');
                    // Remove the row from the table
                    const row = document.querySelector(`[data-model="${model}"][data-id="${id}"]`).closest('tr');
                    row.remove();
                    hideDeleteModal();
                    // Reload page if no rows left
                    if (document.querySelectorAll('.calculation-row').length === 0) {
                        setTimeout(() => location.reload(), 1000);
                    }
                } else {
                    showToast('Error deleting calculation', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Error deleting calculation', 'error');
            });
        }

        function deleteAll(type) {
            let message = '';
            if (type === 'all') {
                message = 'Are you sure you want to delete ALL your calculation history? This action cannot be undone.';
            } else {
                const modelNames = {
                    'BmiCalculation': 'BMI Calculations',
                    'CalorieCalculation': 'Calorie Calculations',
                    'CgpaCalculation': 'CGPA Calculations',
                    'CurrencyConversion': 'Currency Conversions',
                    'DateTimeCalculation': 'Date Time Calculations',
                    'LoanCalculation': 'Loan Calculations',
                    'PercentageCalculation': 'Percentage Calculations',
                    'ProfitLossCalculation': 'Profit Loss Calculations'
                };
                message = `Are you sure you want to delete all ${modelNames[type]}? This action cannot be undone.`;
            }
            
            if (confirm(message)) {
                fetch('{{ route("history.delete-all") }}', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        model: type
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast('All calculations deleted successfully', 'success');
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        showToast('Error deleting calculations', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Error deleting calculations', 'error');
                });
            }
        }

        function showToast(message, type = 'info') {
            const toast = document.createElement('div');
            toast.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 animate-slide-up ${
                type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
            }`;
            toast.innerHTML = `
                <div class="flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    <span>${message}</span>
                </div>
            `;
            
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.remove();
            }, 3000);
        }
    </script>
</body>
</html>