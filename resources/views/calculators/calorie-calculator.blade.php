<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='%2322c55e'><path fill-rule='evenodd' d='M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V4a2 2 0 00-2-2H6zm1 2a1 1 0 000 2h6a1 1 0 100-2H7zm6 7a1 1 0 00-1 1v1H7v-1a1 1 0 00-2 0v1a2 2 0 002 2h6a2 2 0 002-2v-1a1 1 0 00-1-1z' clip-rule='evenodd'/></svg>">
    <title>Calorie Calculator - CalcHub</title>
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
            
            <!-- Dashboard Navigation -->
            <nav class="hidden md:flex space-x-6 mr-4">
                <a href="{{ route('dashboard') }}" class="text-gray-600 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition-smooth">Dashboard</a>
                <a href="{{ route('home') }}" class="text-gray-600 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition-smooth">Tools</a>
                {{-- <a href="{{ route('history') }}" class="text-gray-600 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition-smooth">History</a> --}}
                {{-- <a href="{{ route('profile') }}" class="text-gray-600 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition-smooth">Profile</a> --}}
            </nav>
            
            <div class="flex items-center space-x-4">
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
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Calorie Calculator</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Page Header -->
        <div class="mb-8 animate-fade-in">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 dark:text-white mb-2">Calorie Calculator 🍎</h1>
                    <p class="text-gray-600 dark:text-gray-400">Track your daily calorie intake and manage your diet effectively</p>
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
                        <label for="calculationName" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Calculation Name (Optional)
                        </label>
                        <input type="text" id="calculationName" 
                               class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors" 
                               placeholder="e.g., My Diet Plan, Weight Loss Goal, etc.">
                    </div>

                    <!-- Input Fields -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Age -->
                        <div class="animate-slide-up" style="animation-delay: 0.1s">
                            <label for="age" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-birthday-cake text-primary-500 mr-2"></i>
                                Age
                            </label>
                            <input type="number" id="age" 
                                   class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors" 
                                   placeholder="Enter age" min="15" max="100" value="25">
                        </div>

                        <!-- Gender -->
                        <div class="animate-slide-up" style="animation-delay: 0.2s">
                            <label for="gender" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-user text-primary-500 mr-2"></i>
                                Gender
                            </label>
                            <select id="gender" class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors">
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>

                        <!-- Weight -->
                        <div class="animate-slide-up" style="animation-delay: 0.3s">
                            <label for="weight" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-weight text-primary-500 mr-2"></i>
                                Weight (kg)
                            </label>
                            <input type="number" id="weight" 
                                   class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors" 
                                   placeholder="Enter weight in kg" step="0.1" min="30" max="300" value="70">
                        </div>

                        <!-- Height -->
                        <div class="animate-slide-up" style="animation-delay: 0.4s">
                            <label for="height" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-ruler-vertical text-primary-500 mr-2"></i>
                                Height (cm)
                            </label>
                            <input type="number" id="height" 
                                   class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors" 
                                   placeholder="Enter height in cm" step="0.1" min="100" max="250" value="175">
                        </div>

                        <!-- Activity Level -->
                        <div class="animate-slide-up" style="animation-delay: 0.5s">
                            <label for="activity_level" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-running text-primary-500 mr-2"></i>
                                Activity Level
                            </label>
                            <select id="activity_level" class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors">
                                <option value="sedentary">Sedentary (Little or no exercise)</option>
                                <option value="light">Light (Exercise 1-3 days/week)</option>
                                <option value="moderate" selected>Moderate (Exercise 3-5 days/week)</option>
                                <option value="active">Active (Exercise 6-7 days/week)</option>
                                <option value="very_active">Very Active (Hard exercise daily)</option>
                            </select>
                        </div>

                        <!-- Goal -->
                        <div class="animate-slide-up" style="animation-delay: 0.6s">
                            <label for="goal" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-bullseye text-primary-500 mr-2"></i>
                                Goal
                            </label>
                            <select id="goal" class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors">
                                <option value="lose">Lose Weight</option>
                                <option value="maintain" selected>Maintain Weight</option>
                                <option value="gain">Gain Weight</option>
                            </select>
                        </div>
                    </div>

                    <!-- Calculate Button -->
                    <button id="calculateBtn" class="w-full bg-primary-500 hover:bg-primary-600 text-white py-3 rounded-lg font-semibold transition-all duration-300 shadow-sm hover:shadow-md active:scale-95 flex items-center justify-center animate-scale-in" style="animation-delay: 0.7s">
                        <i class="fas fa-calculator mr-2"></i>
                        Calculate Calories
                    </button>

                    <!-- Result Display -->
                    <div id="result" class="mt-6 p-6 bg-gray-50 dark:bg-gray-700 rounded-lg hidden animate-fade-in">
                        <div class="text-center mb-6">
                            <div class="text-4xl font-bold text-primary-600 dark:text-primary-400 mb-2" id="calorieTarget"></div>
                            <div class="text-lg font-semibold text-gray-800 dark:text-white mb-1">Daily Calorie Target</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400" id="goalText"></div>
                        </div>
                        
                        <!-- Calorie Breakdown -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div class="bg-white dark:bg-gray-600 p-4 rounded-lg border border-gray-200 dark:border-gray-500">
                                <div class="text-sm text-gray-600 dark:text-gray-400">BMR (Basal Metabolic Rate)</div>
                                <div class="text-xl font-semibold text-blue-600 dark:text-blue-400" id="bmrValue"></div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">Calories at rest</div>
                            </div>
                            <div class="bg-white dark:bg-gray-600 p-4 rounded-lg border border-gray-200 dark:border-gray-500">
                                <div class="text-sm text-gray-600 dark:text-gray-400">TDEE (Total Daily Energy Expenditure)</div>
                                <div class="text-xl font-semibold text-green-600 dark:text-green-400" id="tdeeValue"></div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">Calories with activity</div>
                            </div>
                        </div>

                        <!-- Formula Used -->
                        <div class="mt-4 p-4 bg-white dark:bg-gray-600 rounded-lg border border-gray-200 dark:border-gray-500">
                            <h4 class="font-semibold text-gray-800 dark:text-white mb-3 flex items-center">
                                <i class="fas fa-calculator mr-2 text-primary-500"></i>
                                Calculation Steps:
                            </h4>
                            <div id="formulaUsed" class="text-sm text-gray-600 dark:text-gray-400 whitespace-pre-line"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Quick Examples -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 animate-scale-in" style="animation-delay: 0.2s">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 flex items-center">
                        <i class="fas fa-users text-primary-500 mr-2"></i>
                        Common Profiles
                    </h3>
                    <div class="space-y-3 text-sm">
                        <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors border border-gray-200 dark:border-gray-600" onclick="loadExample('average_male')">
                            <div class="font-medium text-gray-800 dark:text-white">Average Male</div>
                            <div class="text-gray-600 dark:text-gray-400 text-xs">25 years, 70kg, 175cm, Moderate activity</div>
                        </div>
                        <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors border border-gray-200 dark:border-gray-600" onclick="loadExample('average_female')">
                            <div class="font-medium text-gray-800 dark:text-white">Average Female</div>
                            <div class="text-gray-600 dark:text-gray-400 text-xs">25 years, 60kg, 165cm, Moderate activity</div>
                        </div>
                        <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors border border-gray-200 dark:border-gray-600" onclick="loadExample('weight_loss')">
                            <div class="font-medium text-gray-800 dark:text-white">Weight Loss Goal</div>
                            <div class="text-gray-600 dark:text-gray-400 text-xs">30 years, 80kg, 170cm, Light activity</div>
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

                <!-- Quick Tips -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 animate-scale-in" style="animation-delay: 0.6s">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 flex items-center">
                        <i class="fas fa-lightbulb text-primary-500 mr-2"></i>
                        Nutrition Tips
                    </h3>
                    <ul class="space-y-3 text-sm text-gray-600 dark:text-gray-400">
                        <li class="flex items-start">
                            <i class="fas fa-apple-alt text-primary-500 mt-1 mr-3 flex-shrink-0"></i>
                            <span>BMR is calories burned at complete rest</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-running text-primary-500 mt-1 mr-3 flex-shrink-0"></i>
                            <span>TDEE includes your daily activity level</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-balance-scale text-primary-500 mt-1 mr-3 flex-shrink-0"></i>
                            <span>500 calorie deficit/surplus = 1lb loss/gain per week</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-glass-whiskey text-primary-500 mt-1 mr-3 flex-shrink-0"></i>
                            <span>Stay hydrated - water helps with metabolism</span>
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
            // Load history
            loadHistory();

            // Refresh history
            document.getElementById('refreshHistory').addEventListener('click', loadHistory);

            // Calculate button
            document.getElementById('calculateBtn').addEventListener('click', calculateCalories);

            function calculateCalories() {
                const inputs = {
                    age: document.getElementById('age').value,
                    gender: document.getElementById('gender').value,
                    weight: document.getElementById('weight').value,
                    height: document.getElementById('height').value,
                    activity_level: document.getElementById('activity_level').value,
                    goal: document.getElementById('goal').value
                };

                // Validate inputs
                for (const [key, value] of Object.entries(inputs)) {
                    if (!value) {
                        alert(`Please enter a valid ${key.replace('_', ' ')}`);
                        return;
                    }
                }

                const calculationName = document.getElementById('calculationName').value;

                // Show loading
                const calculateBtn = document.getElementById('calculateBtn');
                calculateBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Calculating...';
                calculateBtn.disabled = true;

                // Simulate API call (replace with actual fetch)
                setTimeout(() => {
                    const result = calculateCalorieResult(inputs);
                    displayResult(result);
                    saveToHistory(calculationName, inputs, result);
                    calculateBtn.innerHTML = '<i class="fas fa-calculator mr-2"></i>Calculate Calories';
                    calculateBtn.disabled = false;
                }, 1000);
            }

            function calculateCalorieResult(inputs) {
                // Mifflin-St Jeor Equation for BMR
                let bmr;
                if (inputs.gender === 'male') {
                    bmr = 10 * inputs.weight + 6.25 * inputs.height - 5 * inputs.age + 5;
                } else {
                    bmr = 10 * inputs.weight + 6.25 * inputs.height - 5 * inputs.age - 161;
                }

                // Activity multipliers
                const activityMultipliers = {
                    sedentary: 1.2,
                    light: 1.375,
                    moderate: 1.55,
                    active: 1.725,
                    very_active: 1.9
                };

                const tdee = bmr * activityMultipliers[inputs.activity_level];

                // Goal adjustments
                let calorieTarget;
                switch(inputs.goal) {
                    case 'lose':
                        calorieTarget = tdee - 500;
                        break;
                    case 'gain':
                        calorieTarget = tdee + 500;
                        break;
                    default:
                        calorieTarget = tdee;
                }

                return {
                    calorie_target: Math.round(calorieTarget),
                    bmr: Math.round(bmr),
                    tdee: Math.round(tdee),
                    formula: `BMR Calculation (Mifflin-St Jeor):\n${inputs.gender === 'male' ? '10 × weight + 6.25 × height - 5 × age + 5' : '10 × weight + 6.25 × height - 5 × age - 161'}\n\nTDEE Calculation:\nBMR × ${activityMultipliers[inputs.activity_level]} (${inputs.activity_level} activity)\n\nTarget Calories:\nTDEE ${inputs.goal === 'lose' ? '- 500' : inputs.goal === 'gain' ? '+ 500' : ''} = ${Math.round(calorieTarget)} calories/day`
                };
            }

            function displayResult(data) {
                const resultDiv = document.getElementById('result');
                const calorieTarget = document.getElementById('calorieTarget');
                const goalText = document.getElementById('goalText');
                const bmrValue = document.getElementById('bmrValue');
                const tdeeValue = document.getElementById('tdeeValue');
                const formulaUsed = document.getElementById('formulaUsed');

                const goalTexts = {
                    'lose': 'for weight loss (500 calorie deficit)',
                    'maintain': 'to maintain current weight',
                    'gain': 'for weight gain (500 calorie surplus)'
                };

                calorieTarget.textContent = `${data.calorie_target.toLocaleString()} calories/day`;
                goalText.textContent = goalTexts[document.getElementById('goal').value];
                bmrValue.textContent = `${data.bmr.toLocaleString()} calories`;
                tdeeValue.textContent = `${data.tdee.toLocaleString()} calories`;
                formulaUsed.textContent = data.formula;

                resultDiv.classList.remove('hidden');
                
                // Scroll to result
                resultDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }

            function loadHistory() {
                // Simulate loading history from localStorage
                const history = JSON.parse(localStorage.getItem('calorieHistory') || '[]');
                const historyList = document.getElementById('historyList');
                
                if (history.length === 0) {
                    historyList.innerHTML = `
                        <div class="text-center text-gray-500 dark:text-gray-400 py-4">
                            <i class="fas fa-clock text-2xl mb-2"></i>
                            <div>No calculation history yet</div>
                        </div>
                    `;
                    return;
                }

                historyList.innerHTML = history.slice(-5).reverse().map(calc => `
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 border border-gray-200 dark:border-gray-600">
                        <div class="flex justify-between items-start mb-2">
                            <div class="font-medium text-gray-800 dark:text-white text-sm">${calc.name || 'Unnamed Calculation'}</div>
                            <button class="delete-calculation text-red-500 hover:text-red-700 transition-colors p-1" data-id="${calc.id}">
                                <i class="fas fa-trash text-xs"></i>
                            </button>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-primary-600 dark:text-primary-400 font-semibold">
                                ${calc.result.calorie_target.toLocaleString()} cal
                            </span>
                            <span class="text-gray-500 dark:text-gray-400 text-xs">${new Date(calc.timestamp).toLocaleDateString()}</span>
                        </div>
                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            ${calc.inputs.gender}, ${calc.inputs.age}y, ${calc.inputs.weight}kg
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
            }

            function saveToHistory(name, inputs, result) {
                const history = JSON.parse(localStorage.getItem('calorieHistory') || '[]');
                history.push({
                    id: Date.now(),
                    name: name,
                    inputs: inputs,
                    result: result,
                    timestamp: new Date().toISOString()
                });
                localStorage.setItem('calorieHistory', JSON.stringify(history));
                loadHistory();
            }

            function deleteCalculation(id) {
                if (!confirm('Are you sure you want to delete this calculation?')) {
                    return;
                }

                const history = JSON.parse(localStorage.getItem('calorieHistory') || '[]');
                const updatedHistory = history.filter(calc => calc.id != id);
                localStorage.setItem('calorieHistory', JSON.stringify(updatedHistory));
                loadHistory();
            }

            // Example loader function
            window.loadExample = function(type) {
                const examples = {
                    'average_male': { age: 25, gender: 'male', weight: 70, height: 175, activity_level: 'moderate', goal: 'maintain' },
                    'average_female': { age: 25, gender: 'female', weight: 60, height: 165, activity_level: 'moderate', goal: 'maintain' },
                    'weight_loss': { age: 30, gender: 'male', weight: 80, height: 170, activity_level: 'light', goal: 'lose' }
                };
                
                const example = examples[type];
                if (example) {
                    Object.entries(example).forEach(([key, value]) => {
                        const element = document.getElementById(key);
                        if (element) {
                            element.value = value;
                        }
                    });
                }
            };
        });

        // Dark mode functionality (same as before)
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
        });
    </script>
</body>
</html>