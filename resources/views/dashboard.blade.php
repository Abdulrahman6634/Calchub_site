<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='%2322c55e'><path fill-rule='evenodd' d='M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V4a2 2 0 00-2-2H6zm1 2a1 1 0 000 2h6a1 1 0 100-2H7zm6 7a1 1 0 00-1 1v1H7v-1a1 1 0 00-2 0v1a2 2 0 002 2h6a2 2 0 002-2v-1a1 1 0 00-1-1z' clip-rule='evenodd'/></svg>">
    <title>Dashboard - CalcHub</title>
    <script>
        // Theme detection - moved to top for immediate execution
        (function() {
            const isDark = localStorage.getItem('color-theme') === 'dark' || 
                          (!('color-theme' in localStorage) && 
                           window.matchMedia('(prefers-color-scheme: dark)').matches);
            document.documentElement.classList.toggle('dark', isDark);
        })();
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
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
        
        /* Optimize scrolling performance */
        .scroll-optimized {
            transform: translateZ(0);
            backface-visibility: hidden;
            perspective: 1000;
        }
        
        /* Smooth transitions for dark mode */
        .transition-all-300 {
            transition: all 0.3s ease;
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
                <!-- Mobile menu button (hidden on desktop) -->
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
                        <a href="#" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">Profile</a>
                        <a href="#" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">Settings</a>
                        <div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button 
                                type="submit" 
                                class="w-full text-left px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                Sign Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="md:hidden hidden bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 px-4 py-2">
            <nav class="flex flex-col space-y-2">
                <a href="#" class="py-2 text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Dashboard</a>
                <a href="/tools" class="py-2 text-primary-600 dark:text-primary-400 font-medium">Tools</a>
                <a href="#" class="py-2 text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">History</a>
                <a href="#" class="py-2 text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Profile</a>
            </nav>
        </div>
    </header>

    <!-- Dashboard Content -->
    <main class="flex-grow container mx-auto px-4 py-6">
        <!-- Welcome Section -->
        <div class="mb-8 animate-fade-in">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 dark:text-white mb-2">Welcome back, {{ Auth::user()->name }}! 👋</h1>
            <p class="text-gray-600 dark:text-gray-400">Ready to calculate something amazing today?</p>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-8">
            <!-- Calculations This Week -->
            <div class="bg-white dark:bg-gray-800 rounded-xl p-4 sm:p-6 shadow-sm border border-gray-200 dark:border-gray-700 animate-slide-up" style="animation-delay: 0.1s">
                <div class="flex items-center">
                    <div class="p-2 sm:p-3 rounded-lg bg-primary-100 dark:bg-primary-900 mr-3 sm:mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6 text-primary-600 dark:text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Calculations This Week</p>
                        <p class="text-xl sm:text-2xl font-bold text-gray-800 dark:text-white">
                            {{ $quickStats['calculationsThisWeek'] }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Favorite Calculator -->
            <div class="bg-white dark:bg-gray-800 rounded-xl p-4 sm:p-6 shadow-sm border border-gray-200 dark:border-gray-700 animate-slide-up" style="animation-delay: 0.2s">
                <div class="flex items-center">
                    <div class="p-2 sm:p-3 rounded-lg bg-primary-100 dark:bg-primary-900 mr-3 sm:mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6 text-primary-600 dark:text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Favorite Calculator</p>
                        <p class="text-xl sm:text-2xl font-bold text-gray-800 dark:text-white truncate">
                            {{ $quickStats['favoriteCalculator'] }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Time Saved -->
            <div class="bg-white dark:bg-gray-800 rounded-xl p-4 sm:p-6 shadow-sm border border-gray-200 dark:border-gray-700 animate-slide-up" style="animation-delay: 0.3s">
                <div class="flex items-center">
                    <div class="p-2 sm:p-3 rounded-lg bg-primary-100 dark:bg-primary-900 mr-3 sm:mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6 text-primary-600 dark:text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
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

        <!-- Recent Calculations -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 mb-8 animate-scale-in">
            <div class="p-4 sm:p-6 border-b border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                <h2 class="text-lg sm:text-xl font-bold text-gray-800 dark:text-white">Recent Calculations</h2>
                <a href="#" class="text-primary-600 dark:text-primary-400 hover:underline text-sm font-medium self-end sm:self-auto">
                    View All
                </a>
            </div>

            <div class="p-4 sm:p-6">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm table-auto min-w-[600px]">
                        <thead>
                            <tr class="text-left text-gray-500 dark:text-gray-400 border-b border-gray-200 dark:border-gray-700">
                                <th class="pb-3 font-medium w-[15%]">Calculator</th>
                                <th class="pb-3 font-medium w-[35%]">Inputs / Question</th>
                                <th class="pb-3 font-medium w-[30%]">Description</th>
                                <th class="pb-3 font-medium w-[10%]">Result</th>
                                <th class="pb-3 font-medium w-[10%]">Date</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($recentCalculations as $calc)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors align-top">
                                    <td class="py-3 font-medium text-gray-800 dark:text-gray-200 break-words">
                                        {{ $calc['type'] }}
                                    </td>

                                    <td class="py-3 text-gray-600 dark:text-gray-400 break-words whitespace-pre-line max-w-xs truncate">
                                        {{ $calc['question'] }}
                                    </td>

                                    <td class="py-3 text-gray-600 dark:text-gray-400 break-words whitespace-pre-line max-w-xs truncate">
                                        {{ $calc['description'] ?? 'N/A' }}
                                    </td>

                                    <td class="py-3 font-semibold text-gray-900 dark:text-gray-100 break-words">
                                        {{ $calc['result'] }}
                                    </td>

                                    <td class="py-3 text-gray-500 dark:text-gray-400 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($calc['date'])->diffForHumans() }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-6 text-center text-gray-500 dark:text-gray-400">
                                        No recent calculations found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Calculator Grid -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                <h2 class="text-xl sm:text-2xl font-bold text-gray-800 dark:text-white">Your Calculators</h2>
                <div class="relative w-full sm:w-64">
                    <input type="text" placeholder="Search calculators..." class="pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors w-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 absolute left-3 top-2.5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                <!-- Calculator Cards with staggered animation -->
                @php
                    $calculatorCards = [
                        [
                            'title' => 'CGPA Calculator',
                            'description' => 'Calculate your GPA and CGPA with ease. Perfect for students.',
                            'url' => '/cgpa',
                            'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z',
                            'badge' => 'Popular'
                        ],
                        [
                            'title' => 'Currency Converter',
                            'description' => 'Convert between 150+ currencies with real-time exchange rates.',
                            'url' => '/currency',
                            'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1',
                            'badge' => 'Live Rates'
                        ],
                        [
                            'title' => 'Percentage Calculator',
                            'description' => 'Calculate percentages, increases, decreases, and more.',
                            'url' => '/percentage',
                            'icon' => 'M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z'
                        ],
                        [
                            'title' => 'Profit & Expense',
                            'description' => 'Track your finances with our profit and expense calculator.',
                            'url' => '/profit-loss',
                            'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
                        ],
                        [
                            'title' => 'Calorie Calculator',
                            'description' => 'Track your daily calorie intake and manage your diet effectively.',
                            'url' => '/calorie',
                            'icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z'
                        ]
                    ];
                @endphp

                @foreach($calculatorCards as $index => $card)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden transition-transform hover:scale-105 animate-scale-in" style="animation-delay: {{ 0.1 * $index }}s">
                    <div class="p-4 sm:p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-primary-100 dark:bg-primary-900 rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6 text-primary-600 dark:text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}" />
                                </svg>
                            </div>
                            @if(isset($card['badge']))
                            <span class="bg-primary-100 dark:bg-primary-900 text-primary-800 dark:text-primary-200 text-xs font-medium px-2.5 py-0.5 rounded">{{ $card['badge'] }}</span>
                            @endif
                        </div>
                        <h3 class="text-lg sm:text-xl font-semibold text-gray-800 dark:text-white mb-2">{{ $card['title'] }}</h3>
                        <p class="text-gray-600 dark:text-gray-300 text-sm mb-4">{{ $card['description'] }}</p>
                        <a href="{{ $card['url'] }}" class="inline-flex items-center text-primary-600 dark:text-primary-400 font-medium hover:underline text-sm sm:text-base">
                            Calculate Now
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>
                @endforeach

                <!-- View All Calculators -->
                <div class="bg-gradient-to-br from-primary-500 to-primary-600 rounded-xl shadow-sm overflow-hidden transition-transform hover:scale-105 animate-scale-in" style="animation-delay: 0.6s">
                    <div class="p-4 sm:p-6 h-full flex flex-col justify-center items-center text-center text-white">
                        <div class="w-12 h-12 sm:w-16 sm:h-16 bg-white/20 rounded-full flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 sm:h-8 sm:w-8" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <h3 class="text-lg sm:text-xl font-semibold mb-2">More Calculators</h3>
                        <p class="mb-4 opacity-90 text-sm sm:text-base">Explore all our calculation tools</p>
                        <a href="/tools" class="bg-white text-primary-600 hover:bg-gray-100 font-medium py-2 px-4 rounded-lg transition-colors text-sm sm:text-base">
                            View All
                        </a>
                    </div>
                </div>
            </div>
        </div>
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

    <script>
        // Dark mode toggle functionality
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
                // Toggle icons
                themeToggleDarkIcon.classList.toggle('hidden');
                themeToggleLightIcon.classList.toggle('hidden');

                // Toggle theme
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

            // Search functionality for calculators
            const searchInput = document.querySelector('input[type="text"]');
            if (searchInput) {
                searchInput.addEventListener('input', function(e) {
                    const searchTerm = e.target.value.toLowerCase();
                    const calculatorCards = document.querySelectorAll('.bg-white.rounded-xl.shadow-sm'); // Select calculator cards
                    
                    calculatorCards.forEach(card => {
                        const title = card.querySelector('h3').textContent.toLowerCase();
                        const description = card.querySelector('p').textContent.toLowerCase();
                        
                        if (title.includes(searchTerm) || description.includes(searchTerm)) {
                            card.style.display = 'block';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            }
            
            // Lazy loading for images (if added in future)
            if ('IntersectionObserver' in window) {
                const imageObserver = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            img.src = img.dataset.src;
                            img.classList.remove('lazy');
                            imageObserver.unobserve(img);
                        }
                    });
                });

                document.querySelectorAll('img[data-src]').forEach(img => {
                    imageObserver.observe(img);
                });
            }
        });
    </script>
</body>
</html>