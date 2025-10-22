<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='%2322c55e'><path fill-rule='evenodd' d='M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V4a2 2 0 00-2-2H6zm1 2a1 1 0 000 2h6a1 1 0 100-2H7zm6 7a1 1 0 00-1 1v1H7v-1a1 1 0 00-2 0v1a2 2 0 002 2h6a2 2 0 002-2v-1a1 1 0 00-1-1z' clip-rule='evenodd'/></svg>">
    <title>Tools - CalcHub Dashboard</title>
    <script>
        if (
            localStorage.getItem('color-theme') === 'dark' ||
            (!('color-theme' in localStorage) &&
            window.matchMedia('(prefers-color-scheme: dark)').matches)
        ) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
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
                    }
                }
            }
        }
    </script>
    <style>
        /* Custom scrollbar for dashboard */
        .dashboard-scroll::-webkit-scrollbar {
            width: 6px;
        }
        .dashboard-scroll::-webkit-scrollbar-track {
            background: transparent;
        }
        .dashboard-scroll::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 3px;
        }
        .dark .dashboard-scroll::-webkit-scrollbar-thumb {
            background: #4b5563;
        }
        
        /* Animation for tool cards */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fadeInUp {
            animation: fadeInUp 0.5s ease-out forwards;
        }
        
        /* Stagger animation for cards */
        .card-stagger:nth-child(1) { animation-delay: 0.1s; }
        .card-stagger:nth-child(2) { animation-delay: 0.2s; }
        .card-stagger:nth-child(3) { animation-delay: 0.3s; }
        .card-stagger:nth-child(4) { animation-delay: 0.4s; }
        .card-stagger:nth-child(5) { animation-delay: 0.5s; }
        .card-stagger:nth-child(6) { animation-delay: 0.6s; }
        .card-stagger:nth-child(7) { animation-delay: 0.7s; }
        .card-stagger:nth-child(8) { animation-delay: 0.8s; }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
    <!-- Simplified Header for Dashboard -->
    <header class="sticky top-0 z-50 bg-white/80 dark:bg-gray-800/80 backdrop-blur-md border-b border-gray-200 dark:border-gray-700">
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
                <!-- Dashboard Navigation -->
                <nav class="hidden md:flex space-x-6 mr-4">
                    <a href="{{ route('dashboard') }}" class="text-gray-600 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Dashboard</a>
                    <a href="{{ route('home') }}" class="text-primary-600 dark:text-primary-400 font-medium">Tools</a>
                    {{-- <a href="{{ route('history') }}" class="text-gray-600 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">History</a> --}}
                    {{-- <a href="{{ route('profile') }}" class="text-gray-600 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Profile</a> --}}
                </nav>
                
                <!-- Dark mode toggle -->
                <button id="theme-toggle" class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
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
                        <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">Dashboard</a>
                        {{-- <a href="{{ route('profile') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">Profile</a> --}}
                        {{-- <a href="{{ route('settings') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">Settings</a> --}}
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
    </header>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-6">
        <!-- Breadcrumb -->
        <div class="mb-6">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-primary-600 dark:text-gray-400 dark:hover:text-white">
                            <i class="fas fa-home mr-2"></i>
                            Dashboard
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Tools</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 dark:text-white mb-2">Calculator Tools</h1>
            <p class="text-gray-600 dark:text-gray-400">All your calculation tools in one place</p>
        </div>

        <!-- Recently Used Tools (if any) -->
        <div class="mb-8" id="recent-tools-section" style="display: none;">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Recently Used</h2>
                <button id="clear-recent" class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">Clear</button>
            </div>
            <div id="recent-tools" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <!-- Recent tools will be dynamically inserted here -->
            </div>
        </div>

        <!-- Search and Filter -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="relative flex-grow">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" id="tool-search" class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2.5" placeholder="Search tools...">
                </div>
                <div class="flex gap-2">
                    <button id="filter-all" class="px-4 py-2.5 text-sm font-medium rounded-lg bg-primary-600 text-white">All</button>
                    <button id="filter-favorites" class="px-4 py-2.5 text-sm font-medium rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-600">Favorites</button>
                </div>
            </div>
        </div>

        <!-- Calculator Tools Grid -->
        <div class="mb-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <!-- Currency Converter Card -->
                <div class="card-stagger animate-fadeInUp opacity-0">
                    <a href="{{ route('currency.converter') }}" class="group block tool-card" data-tool-name="Currency Converter" data-tool-category="finance">
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-lg hover:border-primary-300 dark:hover:border-primary-600 transition-all duration-300 group-hover:scale-105 h-full flex flex-col">
                            <div class="flex justify-between items-start mb-4">
                                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-exchange-alt text-blue-600 dark:text-blue-400 text-xl"></i>
                                </div>
                                <button class="favorite-btn text-gray-400 hover:text-yellow-500 transition-colors" data-tool="currency">
                                    <i class="far fa-star"></i>
                                </button>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">Currency Converter</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 flex-grow">
                                Convert between 150+ currencies with real-time exchange rates
                            </p>
                            <div class="flex items-center text-blue-600 dark:text-blue-400 font-medium">
                                <span>Use Tool</span>
                                <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform duration-300"></i>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- GPA/CGPA Calculator Card -->
                <div class="card-stagger animate-fadeInUp opacity-0">
                    <a href="{{ route('cgpa.calculator') }}" class="group block tool-card" data-tool-name="GPA/CGPA Calculator" data-tool-category="education">
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-lg hover:border-primary-300 dark:hover:border-primary-600 transition-all duration-300 group-hover:scale-105 h-full flex flex-col">
                            <div class="flex justify-between items-start mb-4">
                                <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-graduation-cap text-green-600 dark:text-green-400 text-xl"></i>
                                </div>
                                <button class="favorite-btn text-gray-400 hover:text-yellow-500 transition-colors" data-tool="cgpa">
                                    <i class="far fa-star"></i>
                                </button>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">GPA/CGPA Calculator</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 flex-grow">
                                Calculate your GPA and CGPA with ease. Perfect for students
                            </p>
                            <div class="flex items-center text-green-600 dark:text-green-400 font-medium">
                                <span>Use Tool</span>
                                <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform duration-300"></i>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Percentage Calculator Card -->
                <div class="card-stagger animate-fadeInUp opacity-0">
                    <a href="{{ route('percentage.calculator') }}" class="group block tool-card" data-tool-name="Percentage Calculator" data-tool-category="math">
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-lg hover:border-primary-300 dark:hover:border-primary-600 transition-all duration-300 group-hover:scale-105 h-full flex flex-col">
                            <div class="flex justify-between items-start mb-4">
                                <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-percent text-purple-600 dark:text-purple-400 text-xl"></i>
                                </div>
                                <button class="favorite-btn text-gray-400 hover:text-yellow-500 transition-colors" data-tool="percentage">
                                    <i class="far fa-star"></i>
                                </button>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">Percentage Calculator</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 flex-grow">
                                Calculate percentages, increases, decreases, and more
                            </p>
                            <div class="flex items-center text-purple-600 dark:text-purple-400 font-medium">
                                <span>Use Tool</span>
                                <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform duration-300"></i>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Profit & Loss Calculator Card -->
                <div class="card-stagger animate-fadeInUp opacity-0">
                    <a href="{{ route('profit-loss.calculator') }}" class="group block tool-card" data-tool-name="Profit & Loss Calculator" data-tool-category="finance">
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-lg hover:border-primary-300 dark:hover:border-primary-600 transition-all duration-300 group-hover:scale-105 h-full flex flex-col">
                            <div class="flex justify-between items-start mb-4">
                                <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-chart-line text-orange-600 dark:text-orange-400 text-xl"></i>
                                </div>
                                <button class="favorite-btn text-gray-400 hover:text-yellow-500 transition-colors" data-tool="profit-loss">
                                    <i class="far fa-star"></i>
                                </button>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">Profit & Loss Calculator</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 flex-grow">
                                Track your finances with our profit and expense calculator
                            </p>
                            <div class="flex items-center text-orange-600 dark:text-orange-400 font-medium">
                                <span>Use Tool</span>
                                <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform duration-300"></i>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Calorie Calculator Card -->
                <div class="card-stagger animate-fadeInUp opacity-0">
                    <a href="{{ route('calorie.calculator') }}" class="group block tool-card" data-tool-name="Calorie Calculator" data-tool-category="health">
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-lg hover:border-primary-300 dark:hover:border-primary-600 transition-all duration-300 group-hover:scale-105 h-full flex flex-col">
                            <div class="flex justify-between items-start mb-4">
                                <div class="w-12 h-12 bg-red-100 dark:bg-red-900 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-apple-alt text-red-600 dark:text-red-400 text-xl"></i>
                                </div>
                                <button class="favorite-btn text-gray-400 hover:text-yellow-500 transition-colors" data-tool="calorie">
                                    <i class="far fa-star"></i>
                                </button>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">Calorie Calculator</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 flex-grow">
                                Track your daily calorie intake and manage your diet effectively
                            </p>
                            <div class="flex items-center text-red-600 dark:text-red-400 font-medium">
                                <span>Use Tool</span>
                                <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform duration-300"></i>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Date & Time Calculator Card -->
                <div class="card-stagger animate-fadeInUp opacity-0">
                    <a href="{{ route('date-time.calculator') }}" class="group block tool-card" data-tool-name="Date & Time Calculator" data-tool-category="time">
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-lg hover:border-primary-300 dark:hover:border-primary-600 transition-all duration-300 group-hover:scale-105 h-full flex flex-col">
                            <div class="flex justify-between items-start mb-4">
                                <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-clock text-indigo-600 dark:text-indigo-400 text-xl"></i>
                                </div>
                                <button class="favorite-btn text-gray-400 hover:text-yellow-500 transition-colors" data-tool="date-time">
                                    <i class="far fa-star"></i>
                                </button>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">Date & Time Calculator</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 flex-grow">
                                Calculate date differences, add/subtract time, and count business days
                            </p>
                            <div class="flex items-center text-indigo-600 dark:text-indigo-400 font-medium">
                                <span>Use Tool</span>
                                <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform duration-300"></i>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- BMI Calculator Card -->
                <div class="card-stagger animate-fadeInUp opacity-0">
                    <a href="{{ route('bmi.calculator') }}" class="group block tool-card" data-tool-name="BMI Calculator" data-tool-category="health">
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-lg hover:border-primary-300 dark:hover:border-primary-600 transition-all duration-300 group-hover:scale-105 h-full flex flex-col">
                            <div class="flex justify-between items-start mb-4">
                                <div class="w-12 h-12 bg-teal-100 dark:bg-teal-900 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-weight text-teal-600 dark:text-teal-400 text-xl"></i>
                                </div>
                                <button class="favorite-btn text-gray-400 hover:text-yellow-500 transition-colors" data-tool="bmi">
                                    <i class="far fa-star"></i>
                                </button>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">BMI Calculator</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 flex-grow">
                                Calculate Body Mass Index and track your health metrics
                            </p>
                            <div class="flex items-center text-teal-600 dark:text-teal-400 font-medium">
                                <span>Use Tool</span>
                                <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform duration-300"></i>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Loan Calculator Card -->
                <div class="card-stagger animate-fadeInUp opacity-0">
                    <a href="{{ route('loan.calculator') }}" class="group block tool-card" data-tool-name="Loan Calculator" data-tool-category="finance">
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-lg hover:border-primary-300 dark:hover:border-primary-600 transition-all duration-300 group-hover:scale-105 h-full flex flex-col">
                            <div class="flex justify-between items-start mb-4">
                                <div class="w-12 h-12 bg-amber-100 dark:bg-amber-900 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-home text-amber-600 dark:text-amber-400 text-xl"></i>
                                </div>
                                <button class="favorite-btn text-gray-400 hover:text-yellow-500 transition-colors" data-tool="loan">
                                    <i class="far fa-star"></i>
                                </button>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">Loan Calculator</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 flex-grow">
                                Calculate loan payments, interest, and amortization schedules
                            </p>
                            <div class="flex items-center text-amber-600 dark:text-amber-400 font-medium">
                                <span>Use Tool</span>
                                <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform duration-300"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Other Tools Section -->
        <div class="mb-12">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">Other Tools</h2>
                <p class="text-gray-600 dark:text-gray-400">Quick utilities and tools — more coming soon.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <!-- YouTube Tag Generator Card -->
                <div class="card-stagger animate-fadeInUp opacity-0">
                    <a href="{{ route('youtube.tag-generator') }}" class="group block tool-card" data-tool-name="YouTube Tag Generator" data-tool-category="youtube">
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-lg hover:border-primary-300 dark:hover:border-primary-600 transition-all duration-300 group-hover:scale-105 h-full flex flex-col">
                            <div class="flex justify-between items-start mb-4">
                                <div class="w-12 h-12 bg-red-100 dark:bg-red-900 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                    <i class="fab fa-youtube text-red-600 dark:text-red-400 text-xl"></i>
                                </div>
                                <button class="favorite-btn text-gray-400 hover:text-yellow-500 transition-colors" data-tool="youtube-tag-generator">
                                    <i class="far fa-star"></i>
                                </button>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">YouTube Tag Generator</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 flex-grow">
                                Generate optimized tags for your YouTube videos to improve visibility
                            </p>
                            <div class="flex items-center text-red-600 dark:text-red-400 font-medium">
                                <span>Use Tool</span>
                                <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform duration-300"></i>
                            </div>
                        </div>
                    </a>
                </div>
{{-- 
                <!-- YouTube Title Generator Card -->
                <div class="card-stagger animate-fadeInUp opacity-0">
                    <a href="{{ route('') }}" class="group block tool-card" data-tool-name="YouTube Title Generator" data-tool-category="youtube">
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-lg hover:border-primary-300 dark:hover:border-primary-600 transition-all duration-300 group-hover:scale-105 h-full flex flex-col">
                            <div class="flex justify-between items-start mb-4">
                                <div class="w-12 h-12 bg-red-100 dark:bg-red-900 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                    <i class="fab fa-youtube text-red-600 dark:text-red-400 text-xl"></i>
                                </div>
                                <button class="favorite-btn text-gray-400 hover:text-yellow-500 transition-colors" data-tool="youtube-title-generator">
                                    <i class="far fa-star"></i>
                                </button>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">YouTube Title Generator</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 flex-grow">
                                Create catchy and SEO-friendly titles for your YouTube videos
                            </p>
                            <div class="flex items-center text-red-600 dark:text-red-400 font-medium">
                                <span>Use Tool</span>
                                <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform duration-300"></i>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- YouTube Description Generator Card -->
                <div class="card-stagger animate-fadeInUp opacity-0">
                    <a href="{{ route('') }}" class="group block tool-card" data-tool-name="YouTube Description Generator" data-tool-category="youtube">
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-lg hover:border-primary-300 dark:hover:border-primary-600 transition-all duration-300 group-hover:scale-105 h-full flex flex-col">
                            <div class="flex justify-between items-start mb-4">
                                <div class="w-12 h-12 bg-red-100 dark:bg-red-900 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                    <i class="fab fa-youtube text-red-600 dark:text-red-400 text-xl"></i>
                                </div>
                                <button class="favorite-btn text-gray-400 hover:text-yellow-500 transition-colors" data-tool="youtube-description-generator">
                                    <i class="far fa-star"></i>
                                </button>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">YouTube Description Generator</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 flex-grow">
                                Generate compelling descriptions with timestamps and links for your videos
                            </p>
                            <div class="flex items-center text-red-600 dark:text-red-400 font-medium">
                                <span>Use Tool</span>
                                <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform duration-300"></i>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- YouTube Thumbnail Analyzer Card -->
                <div class="card-stagger animate-fadeInUp opacity-0">
                    <a href="{{ route('') }}" class="group block tool-card" data-tool-name="YouTube Thumbnail Analyzer" data-tool-category="youtube">
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-lg hover:border-primary-300 dark:hover:border-primary-600 transition-all duration-300 group-hover:scale-105 h-full flex flex-col">
                            <div class="flex justify-between items-start mb-4">
                                <div class="w-12 h-12 bg-red-100 dark:bg-red-900 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                    <i class="fab fa-youtube text-red-600 dark:text-red-400 text-xl"></i>
                                </div>
                                <button class="favorite-btn text-gray-400 hover:text-yellow-500 transition-colors" data-tool="youtube-thumbnail-analyzer">
                                    <i class="far fa-star"></i>
                                </button>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">YouTube Thumbnail Analyzer</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 flex-grow">
                                Analyze and optimize your YouTube thumbnails for better click-through rates
                            </p>
                            <div class="flex items-center text-red-600 dark:text-red-400 font-medium">
                                <span>Use Tool</span>
                                <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform duration-300"></i>
                            </div>
                        </div>
                    </a>
                </div> --}}
            </div>
        </div>

        <!-- No Results Message -->
        <div id="no-results" class="hidden text-center py-12">
            <div class="w-24 h-24 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-search text-gray-400 text-2xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-2">No tools found</h3>
            <p class="text-gray-500 dark:text-gray-400">Try adjusting your search or filter to find what you're looking for.</p>
        </div>
    </div>

    <!-- Simplified Footer for Dashboard -->
    <footer class="bg-gray-800 dark:bg-gray-900 text-white py-8 mt-8">
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
                <div class="text-gray-400 text-sm">
                    &copy; 2023 CalcHub. All rights reserved.
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Dark mode functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-detect system theme on load
            if (
                localStorage.getItem('color-theme') === 'dark' ||
                (!('color-theme' in localStorage) &&
                window.matchMedia('(prefers-color-scheme: dark)').matches)
            ) {
                document.documentElement.classList.add('dark');
                document.getElementById('theme-toggle-dark-icon').classList.add('hidden');
                document.getElementById('theme-toggle-light-icon').classList.remove('hidden');
            } else {
                document.documentElement.classList.remove('dark');
                document.getElementById('theme-toggle-light-icon').classList.add('hidden');
                document.getElementById('theme-toggle-dark-icon').classList.remove('hidden');
            }

            // Theme toggle button
            const themeToggleBtn = document.getElementById('theme-toggle');
            const darkIcon = document.getElementById('theme-toggle-dark-icon');
            const lightIcon = document.getElementById('theme-toggle-light-icon');

            themeToggleBtn.addEventListener('click', function() {
                // toggle icons
                darkIcon.classList.toggle('hidden');
                lightIcon.classList.toggle('hidden');

                // toggle theme
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                }
            });

            // Tool search functionality
            const toolSearch = document.getElementById('tool-search');
            const toolCards = document.querySelectorAll('.tool-card');
            const noResults = document.getElementById('no-results');

            toolSearch.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                let visibleCount = 0;

                toolCards.forEach(card => {
                    const toolName = card.getAttribute('data-tool-name').toLowerCase();
                    if (toolName.includes(searchTerm)) {
                        card.parentElement.style.display = 'block';
                        visibleCount++;
                    } else {
                        card.parentElement.style.display = 'none';
                    }
                });

                // Show/hide no results message
                if (visibleCount === 0 && searchTerm.length > 0) {
                    noResults.classList.remove('hidden');
                } else {
                    noResults.classList.add('hidden');
                }
            });

            // Filter buttons
            const filterAll = document.getElementById('filter-all');
            const filterFavorites = document.getElementById('filter-favorites');

            filterAll.addEventListener('click', function() {
                filterAll.classList.add('bg-primary-600', 'text-white');
                filterAll.classList.remove('bg-gray-200', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-300');
                
                filterFavorites.classList.remove('bg-primary-600', 'text-white');
                filterFavorites.classList.add('bg-gray-200', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-300');
                
                // Show all tools
                toolCards.forEach(card => {
                    card.parentElement.style.display = 'block';
                });
                noResults.classList.add('hidden');
            });

            filterFavorites.addEventListener('click', function() {
                filterFavorites.classList.add('bg-primary-600', 'text-white');
                filterFavorites.classList.remove('bg-gray-200', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-300');
                
                filterAll.classList.remove('bg-primary-600', 'text-white');
                filterAll.classList.add('bg-gray-200', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-300');
                
                // Show only favorited tools
                let visibleCount = 0;
                toolCards.forEach(card => {
                    const toolId = card.querySelector('.favorite-btn').getAttribute('data-tool');
                    const isFavorite = localStorage.getItem(`favorite-${toolId}`) === 'true';
                    
                    if (isFavorite) {
                        card.parentElement.style.display = 'block';
                        visibleCount++;
                    } else {
                        card.parentElement.style.display = 'none';
                    }
                });

                // Show/hide no results message
                if (visibleCount === 0) {
                    noResults.classList.remove('hidden');
                } else {
                    noResults.classList.add('hidden');
                }
            });

            // Favorite functionality
            const favoriteButtons = document.querySelectorAll('.favorite-btn');
            
            favoriteButtons.forEach(button => {
                const toolId = button.getAttribute('data-tool');
                const isFavorite = localStorage.getItem(`favorite-${toolId}`) === 'true';
                
                if (isFavorite) {
                    button.innerHTML = '<i class="fas fa-star text-yellow-500"></i>';
                }
                
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    const toolId = this.getAttribute('data-tool');
                    const isCurrentlyFavorite = localStorage.getItem(`favorite-${toolId}`) === 'true';
                    
                    if (isCurrentlyFavorite) {
                        localStorage.setItem(`favorite-${toolId}`, 'false');
                        this.innerHTML = '<i class="far fa-star"></i>';
                    } else {
                        localStorage.setItem(`favorite-${toolId}`, 'true');
                        this.innerHTML = '<i class="fas fa-star text-yellow-500"></i>';
                    }
                });
            });

            // Track recently used tools
            toolCards.forEach(card => {
                card.addEventListener('click', function() {
                    const toolName = this.getAttribute('data-tool-name');
                    const toolCategory = this.getAttribute('data-tool-category');
                    const toolId = this.querySelector('.favorite-btn').getAttribute('data-tool');
                    
                    // Save to recent tools
                    let recentTools = JSON.parse(localStorage.getItem('recent-tools') || '[]');
                    
                    // Remove if already exists
                    recentTools = recentTools.filter(tool => tool.id !== toolId);
                    
                    // Add to beginning
                    recentTools.unshift({
                        id: toolId,
                        name: toolName,
                        category: toolCategory,
                        timestamp: new Date().getTime()
                    });
                    
                    // Keep only last 4 tools
                    if (recentTools.length > 4) {
                        recentTools = recentTools.slice(0, 4);
                    }
                    
                    localStorage.setItem('recent-tools', JSON.stringify(recentTools));
                });
            });

            // Display recent tools
            function displayRecentTools() {
                const recentTools = JSON.parse(localStorage.getItem('recent-tools') || '[]');
                const recentToolsContainer = document.getElementById('recent-tools');
                const recentToolsSection = document.getElementById('recent-tools-section');
                
                if (recentTools.length > 0) {
                    recentToolsSection.style.display = 'block';
                    recentToolsContainer.innerHTML = '';
                    
                    recentTools.forEach(tool => {
                        const toolCard = document.querySelector(`[data-tool="${tool.id}"]`).closest('.tool-card');
                        if (toolCard) {
                            const clone = toolCard.cloneNode(true);
                            clone.classList.add('recent-tool');
                            recentToolsContainer.appendChild(clone);
                        }
                    });
                } else {
                    recentToolsSection.style.display = 'none';
                }
            }
            
            // Clear recent tools
            document.getElementById('clear-recent').addEventListener('click', function() {
                localStorage.removeItem('recent-tools');
                displayRecentTools();
            });
            
            // Initial display of recent tools
            displayRecentTools();
        });
    </script>
</body>
</html>