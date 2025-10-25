<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='%2322c55e'><path fill-rule='evenodd' d='M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z' clip-rule='evenodd'/></svg>">
    <title>BMI Calculator - CalcHub</title>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                        'fade-in': 'fadeIn 0.5s ease-out',
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
                transform: scale(0.95);
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
        
        .transition-smooth {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .bmi-progress-bar {
            height: 8px;
            border-radius: 4px;
            background: linear-gradient(90deg, 
                #3b82f6 0%, 
                #10b981 25%, 
                #f59e0b 50%, 
                #ef4444 75%, 
                #dc2626 100%);
        }

        .bmi-marker {
            transition: all 0.3s ease;
        }

        .bmi-marker.active {
            transform: scale(1.2);
            font-weight: bold;
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 transition-colors duration-300 min-h-screen">
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

                <!-- Dashboard Navigation -->
                <nav class="hidden md:flex space-x-6 mr-4">
                    <a href="{{ route('dashboard') }}" class="text-gray-600 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition-smooth">Dashboard</a>
                    <a href="{{ route('home') }}" class="text-gray-600 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition-smooth">Tools</a>
                    <a href="{{ route('history.index') }}" class="text-gray-600 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition-smooth">History</a>
                    {{-- <a href="{{ route('profile') }}" class="text-gray-600 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition-smooth">Profile</a> --}}
                </nav>

                <!-- Mobile menu button (hidden on desktop) -->
                <button id="mobile-menu-button" class="md:hidden p-2 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                    </svg>
                </button>

                <!-- Dark mode toggle -->
                <button id="theme-toggle" class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 transition-smooth">
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
                        <a href="{{ route('profile') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"><i class="fas fa-user mr-2"></i>Profile</a>
                        <div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button 
                                type="submit" 
                                class="w-full text-left px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
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
                <a href="{{ route('home') }}" class="py-2 text-primary-600 dark:text-primary-400 font-medium">Tools</a>
                <a href="{{ route('history.index') }}" class="py-2 text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">History</a>
                {{-- <a href="{{ route('profile') }}" class="py-2 text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Profile</a> --}}
            </nav>
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
                    <li class="inline-flex items-center">
                        <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        <a href="{{ route('home') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-primary-600 dark:text-gray-400 dark:hover:text-white">
                            Tools
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">BMI Calculator</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Page Header -->
        <div class="mb-8 animate-fade-in">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 dark:text-white mb-2">BMI Calculator 🏥</h1>
                    <p class="text-gray-600 dark:text-gray-400">Calculate your Body Mass Index and track your health journey.</p>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="px-3 py-1 bg-primary-100 dark:bg-primary-900 text-primary-800 dark:text-primary-200 text-sm font-medium rounded-full">
                        Health & Fitness
                    </span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Calculator Card -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Calculator Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 animate-scale-in">
                    <!-- Calculation Name -->
                    <div class="mb-6">
                        <label for="calculationName" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                            <i class="fas fa-tag text-primary-500 mr-2"></i>
                            Calculation Name (Optional)
                        </label>
                        <input type="text" id="calculationName" 
                               class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors" 
                               placeholder="e.g., Monthly Checkup, Fitness Goal, etc.">
                    </div>

                    <!-- Personal Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label for="age" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                <i class="fas fa-birthday-cake text-primary-500 mr-2"></i>
                                Age (Optional)
                            </label>
                            <input type="number" id="age" min="1" max="120"
                                   class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors" 
                                   placeholder="Your age">
                        </div>
                        <div>
                            <label for="gender" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                <i class="fas fa-user text-primary-500 mr-2"></i>
                                Gender (Optional)
                            </label>
                            <select id="gender" class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors">
                                <option value="">Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </div>

                    <!-- Height Input -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                            <i class="fas fa-ruler-vertical text-primary-500 mr-2"></i>
                            Height
                        </label>
                        <div class="flex gap-4">
                            <input type="number" id="height" step="0.1" min="0.1" max="300"
                                   class="flex-1 p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors" 
                                   placeholder="Enter height" value="170">
                            <select id="heightUnit" class="w-32 p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors">
                                <option value="cm">cm</option>
                                <option value="m">m</option>
                                <option value="ft">ft</option>
                                <option value="in">in</option>
                            </select>
                        </div>
                    </div>

                    <!-- Weight Input -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                            <i class="fas fa-weight text-primary-500 mr-2"></i>
                            Weight
                        </label>
                        <div class="flex gap-4">
                            <input type="number" id="weight" step="0.1" min="0.1" max="500"
                                   class="flex-1 p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors" 
                                   placeholder="Enter weight" value="70">
                            <select id="weightUnit" class="w-32 p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors">
                                <option value="kg">kg</option>
                                <option value="lbs">lbs</option>
                            </select>
                        </div>
                    </div>

                    <!-- Calculate Button -->
                    <button id="calculateBtn" class="w-full bg-primary-500 hover:bg-primary-600 text-white py-3 rounded-lg font-semibold transition-all duration-300 shadow-sm hover:shadow-md active:scale-95 flex items-center justify-center animate-scale-in" style="animation-delay: 0.4s">
                        <i class="fas fa-calculator mr-2"></i>
                        Calculate BMI
                    </button>

                    <!-- Result Display -->
                    <div id="result" class="mt-6 p-6 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600 hidden animate-fade-in">
                        <div class="text-center mb-6">
                            <div class="text-4xl font-bold text-primary-600 dark:text-primary-400 mb-2" id="resultValue"></div>
                            <div class="text-lg font-semibold text-gray-800 dark:text-white mb-1" id="resultCategory"></div>
                            <div class="text-sm text-gray-600 dark:text-gray-400" id="resultDescription"></div>
                        </div>

                        <!-- BMI Scale -->
                        <div class="mb-6">
                            <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mb-2">
                                <span>Underweight</span>
                                <span>Normal</span>
                                <span>Overweight</span>
                                <span>Obese</span>
                            </div>
                            <div class="bmi-progress-bar relative">
                                <div id="bmiMarker" class="absolute top-0 w-4 h-4 bg-white border-2 border-gray-800 rounded-full -mt-1 transform -translate-x-2 transition-all duration-500"></div>
                            </div>
                            <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mt-1">
                                <span>18.5</span>
                                <span>25</span>
                                <span>30</span>
                                <span>35</span>
                                <span>40</span>
                            </div>
                        </div>

                        <!-- Health Advice -->
                        <div class="mt-4 p-4 bg-white dark:bg-gray-600 rounded-lg border border-gray-200 dark:border-gray-500">
                            <h4 class="font-semibold text-gray-800 dark:text-white mb-3 flex items-center">
                                <i class="fas fa-heartbeat text-primary-500 mr-2"></i>
                                Health Advice:
                            </h4>
                            <p id="healthAdvice" class="text-sm text-gray-700 dark:text-gray-300"></p>
                        </div>

                        <!-- Ideal Weight Range -->
                        <div class="mt-4 p-4 bg-white dark:bg-gray-600 rounded-lg border border-gray-200 dark:border-gray-500">
                            <h4 class="font-semibold text-gray-800 dark:text-white mb-3 flex items-center">
                                <i class="fas fa-balance-scale text-primary-500 mr-2"></i>
                                Ideal Weight Range:
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div class="flex justify-between">
                                    <span>In Kilograms:</span>
                                    <span class="font-medium" id="idealWeightKg"></span>
                                </div>
                                <div class="flex justify-between">
                                    <span>In Pounds:</span>
                                    <span class="font-medium" id="idealWeightLbs"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Progress Chart -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 animate-scale-in">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 flex items-center">
                        <i class="fas fa-chart-line text-primary-500 mr-2"></i>
                        Your BMI Progress
                    </h3>
                    <div class="h-64">
                        <canvas id="progressChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- BMI Categories -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 animate-scale-in" style="animation-delay: 0.2s">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 flex items-center">
                        <i class="fas fa-list text-primary-500 mr-2"></i>
                        BMI Categories
                    </h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between items-center p-3 bg-red-50 dark:bg-red-900/20 rounded border border-red-200 dark:border-red-800">
                            <span class="font-medium">Underweight</span>
                            <span class="font-semibold text-red-600">&lt; 18.5</span>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-green-50 dark:bg-green-900/20 rounded border border-green-200 dark:border-green-800">
                            <span class="font-medium">Normal weight</span>
                            <span class="font-semibold text-green-600">18.5 - 24.9</span>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-yellow-50 dark:bg-yellow-900/20 rounded border border-yellow-200 dark:border-yellow-800">
                            <span class="font-medium">Overweight</span>
                            <span class="font-semibold text-yellow-600">25 - 29.9</span>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-orange-50 dark:bg-orange-900/20 rounded border border-orange-200 dark:border-orange-800">
                            <span class="font-medium">Obesity Class I</span>
                            <span class="font-semibold text-orange-600">30 - 34.9</span>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-red-50 dark:bg-red-900/20 rounded border border-red-200 dark:border-red-800">
                            <span class="font-medium">Obesity Class II</span>
                            <span class="font-semibold text-red-600">35 - 39.9</span>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-red-100 dark:bg-red-900/40 rounded border border-red-300 dark:border-red-700">
                            <span class="font-medium">Obesity Class III</span>
                            <span class="font-semibold text-red-700">≥ 40</span>
                        </div>
                    </div>
                </div>

                <!-- Calculation History -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 animate-scale-in" style="animation-delay: 0.4s">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white flex items-center">
                            <i class="fas fa-history text-primary-500 mr-2"></i>
                            Recent Calculations
                        </h3>
                        <button id="refreshHistory" class="text-primary-500 hover:text-primary-600 transition-colors p-1">
                            <i class="fas fa-refresh"></i>
                        </button>
                    </div>
                    <div id="historyList" class="space-y-3 max-h-80 overflow-y-auto">
                        <!-- History items will be loaded here -->
                        <div class="text-center text-gray-500 dark:text-gray-400 py-4">
                            <i class="fas fa-clock text-2xl mb-2"></i>
                            <div>No calculation history yet</div>
                        </div>
                    </div>
                </div>

                <!-- Health Tips -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 animate-scale-in" style="animation-delay: 0.6s">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 flex items-center">
                        <i class="fas fa-lightbulb text-primary-500 mr-2"></i>
                        Health Tips
                    </h3>
                    <ul class="space-y-3 text-sm text-gray-600 dark:text-gray-400">
                        <li class="flex items-start">
                            <i class="fas fa-utensils text-primary-500 mt-1 mr-3 flex-shrink-0"></i>
                            <span>Eat balanced meals with plenty of fruits and vegetables</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-running text-primary-500 mt-1 mr-3 flex-shrink-0"></i>
                            <span>Aim for at least 30 minutes of exercise daily</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-glass-whiskey text-primary-500 mt-1 mr-3 flex-shrink-0"></i>
                            <span>Stay hydrated - drink 8 glasses of water daily</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-bed text-primary-500 mt-1 mr-3 flex-shrink-0"></i>
                            <span>Get 7-9 hours of quality sleep each night</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-stethoscope text-primary-500 mt-1 mr-3 flex-shrink-0"></i>
                            <span>Consult healthcare professionals for personalized advice</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 dark:bg-gray-900 text-white py-8 mt-12">
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
        document.addEventListener('DOMContentLoaded', function() {
            let progressChart = null;

            // Load history and progress
            loadHistory();
            loadProgress();

            // Refresh history
            document.getElementById('refreshHistory').addEventListener('click', loadHistory);

            // Calculate button
            document.getElementById('calculateBtn').addEventListener('click', calculateBMI);

            // Unit conversion helpers
            function convertHeightToMeters(height, unit) {
                switch(unit) {
                    case 'cm': return height / 100;
                    case 'm': return height;
                    case 'ft': return height * 0.3048;
                    case 'in': return height * 0.0254;
                    default: return height;
                }
            }

            function convertWeightToKg(weight, unit) {
                switch(unit) {
                    case 'kg': return weight;
                    case 'lbs': return weight * 0.453592;
                    default: return weight;
                }
            }

            function calculateBMI() {
                const height = parseFloat(document.getElementById('height').value);
                const heightUnit = document.getElementById('heightUnit').value;
                const weight = parseFloat(document.getElementById('weight').value);
                const weightUnit = document.getElementById('weightUnit').value;
                const age = document.getElementById('age').value ? parseInt(document.getElementById('age').value) : null;
                const gender = document.getElementById('gender').value;
                const calculationName = document.getElementById('calculationName').value;

                // Validation
                if (!height || height <= 0) {
                    alert('Please enter a valid height.');
                    return;
                }
                if (!weight || weight <= 0) {
                    alert('Please enter a valid weight.');
                    return;
                }

                // Show loading
                const calculateBtn = document.getElementById('calculateBtn');
                calculateBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Calculating...';
                calculateBtn.disabled = true;

                // Send calculation request
                fetch('{{ route("bmi.calculate") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        height: height,
                        height_unit: heightUnit,
                        weight: weight,
                        weight_unit: weightUnit,
                        age: age,
                        gender: gender,
                        calculation_name: calculationName
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displayResult(data);
                        loadHistory();
                        loadProgress();
                    } else {
                        alert(data.error || 'Calculation failed. Please try again.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                })
                .finally(() => {
                    calculateBtn.innerHTML = '<i class="fas fa-calculator mr-2"></i>Calculate BMI';
                    calculateBtn.disabled = false;
                });
            }

            function displayResult(data) {
                const resultDiv = document.getElementById('result');
                const resultValue = document.getElementById('resultValue');
                const resultCategory = document.getElementById('resultCategory');
                const resultDescription = document.getElementById('resultDescription');
                const healthAdvice = document.getElementById('healthAdvice');
                const idealWeightKg = document.getElementById('idealWeightKg');
                const idealWeightLbs = document.getElementById('idealWeightLbs');
                const bmiMarker = document.getElementById('bmiMarker');

                resultValue.textContent = data.bmi;
                resultCategory.textContent = data.category;
                resultDescription.textContent = `Based on your height and weight`;
                healthAdvice.textContent = data.health_advice;
                idealWeightKg.textContent = `${data.ideal_weight.min_kg} - ${data.ideal_weight.max_kg} kg`;
                idealWeightLbs.textContent = `${data.ideal_weight.min_lbs} - ${data.ideal_weight.max_lbs} lbs`;

                // Position BMI marker on scale
                const bmi = parseFloat(data.bmi);
                let position = (bmi / 40) * 100; // Scale up to 40 for visualization
                if (position > 100) position = 100;
                bmiMarker.style.left = `${position}%`;

                // Update marker color based on BMI category
                if (bmi < 18.5) {
                    bmiMarker.style.borderColor = '#3b82f6'; // Blue for underweight
                } else if (bmi < 25) {
                    bmiMarker.style.borderColor = '#10b981'; // Green for normal
                } else if (bmi < 30) {
                    bmiMarker.style.borderColor = '#f59e0b'; // Yellow for overweight
                } else {
                    bmiMarker.style.borderColor = '#ef4444'; // Red for obese
                }

                resultDiv.classList.remove('hidden');
                resultDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }

            function loadHistory() {
                fetch('{{ route("bmi.history") }}')
                    .then(response => response.json())
                    .then(data => {
                        const historyList = document.getElementById('historyList');
                        
                        if (data.calculations.length === 0) {
                            historyList.innerHTML = `
                                <div class="text-center text-gray-500 dark:text-gray-400 py-4">
                                    <i class="fas fa-clock text-2xl mb-2"></i>
                                    <div>No calculation history yet</div>
                                </div>
                            `;
                            return;
                        }

                        historyList.innerHTML = data.calculations.slice(0, 5).map(calc => `
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 border border-gray-200 dark:border-gray-600 animate-fade-in">
                                <div class="flex justify-between items-start mb-2">
                                    <div class="font-medium text-gray-800 dark:text-white text-sm">${calc.name}</div>
                                    <button class="delete-calculation text-red-500 hover:text-red-700 transition-colors p-1" data-id="${calc.id}">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </div>
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-primary-600 dark:text-primary-400 font-semibold">BMI: ${calc.bmi}</span>
                                    <span class="text-gray-500 dark:text-gray-400 text-xs">${calc.date}</span>
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    ${calc.height} • ${calc.weight} • ${calc.category}
                                </div>
                            </div>
                        `).join('');

                        // Add event listeners to delete buttons
                        document.querySelectorAll('.delete-calculation').forEach(btn => {
                            btn.addEventListener('click', function() {
                                const id = this.getAttribute('data-id');
                                deleteCalculation(id);
                            });
                        });
                    })
                    .catch(error => {
                        console.error('Error loading history:', error);
                    });
            }

            function loadProgress() {
                fetch('{{ route("bmi.progress") }}')
                    .then(response => response.json())
                    .then(data => {
                        if (data.progress.length === 0) return;

                        const ctx = document.getElementById('progressChart').getContext('2d');
                        
                        if (progressChart) {
                            progressChart.destroy();
                        }

                        progressChart = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: data.progress.map(p => p.month),
                                datasets: [{
                                    label: 'BMI',
                                    data: data.progress.map(p => p.bmi),
                                    borderColor: '#22c55e',
                                    backgroundColor: 'rgba(34, 197, 94, 0.1)',
                                    borderWidth: 2,
                                    fill: true,
                                    tension: 0.4
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                scales: {
                                    y: {
                                        beginAtZero: false,
                                        grid: {
                                            color: 'rgba(156, 163, 175, 0.2)'
                                        },
                                        ticks: {
                                            color: '#6b7280'
                                        }
                                    },
                                    x: {
                                        grid: {
                                            color: 'rgba(156, 163, 175, 0.2)'
                                        },
                                        ticks: {
                                            color: '#6b7280'
                                        }
                                    }
                                },
                                plugins: {
                                    legend: {
                                        labels: {
                                            color: '#6b7280'
                                        }
                                    }
                                }
                            }
                        });
                    })
                    .catch(error => {
                        console.error('Error loading progress:', error);
                    });
            }

            function deleteCalculation(id) {
                if (!confirm('Are you sure you want to delete this calculation?')) {
                    return;
                }

                fetch(`/bmi-calculator/history/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        loadHistory();
                        loadProgress();
                    }
                })
                .catch(error => {
                    console.error('Error deleting calculation:', error);
                });
            }
        });

                // Mobile menu toggle
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
            }

        // Dark mode functionality
        document.addEventListener('DOMContentLoaded', function() {
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

            const themeToggleBtn = document.getElementById('theme-toggle');
            const darkIcon = document.getElementById('theme-toggle-dark-icon');
            const lightIcon = document.getElementById('theme-toggle-light-icon');

            themeToggleBtn.addEventListener('click', function() {
                darkIcon.classList.toggle('hidden');
                lightIcon.classList.toggle('hidden');

                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                }
            });
        });
    </script>
</body>
</html>