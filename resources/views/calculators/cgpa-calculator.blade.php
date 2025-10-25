<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='%2322c55e'><path fill-rule='evenodd' d='M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V4a2 2 0 00-2-2H6zm1 2a1 1 0 000 2h6a1 1 0 100-2H7zm6 7a1 1 0 00-1 1v1H7v-1a1 1 0 00-2 0v1a2 2 0 002 2h6a2 2 0 002-2v-1a1 1 0 00-1-1z' clip-rule='evenodd'/></svg>">
    <title>GPA/CGPA Calculator - CalcHub</title>
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
                        {{-- <a href="{{ route('settings') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">Settings</a> --}}
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
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">GPA Calculator</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Page Header -->
        <div class="mb-8 animate-fade-in">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 dark:text-white mb-2">GPA/CGPA Calculator 🎓</h1>
                    <p class="text-gray-600 dark:text-gray-400">Calculate your GPA and CGPA with ease. Perfect for students.</p>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="px-3 py-1 bg-primary-100 dark:bg-primary-900 text-primary-800 dark:text-primary-200 text-sm font-medium rounded-full">
                        Education
                    </span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Calculator Card -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Calculator Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 animate-scale-in">
                    <!-- Calculation Type Selector -->
                    <div class="mb-6">
                        <label for="calculationType" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                            <i class="fas fa-calculator text-primary-500 mr-2"></i>
                            Calculation Type
                        </label>
                        <select id="calculationType" class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors">
                            <option value="gpa">Calculate GPA (Single Semester)</option>
                            <option value="cgpa">Calculate CGPA (Multiple Semesters)</option>
                        </select>
                    </div>

                    <!-- Calculation Name -->
                    <div class="mb-6">
                        <label for="calculationName" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                            <i class="fas fa-tag text-primary-500 mr-2"></i>
                            Calculation Name (Optional)
                        </label>
                        <input type="text" id="calculationName" 
                               class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors" 
                               placeholder="e.g., Semester 1, Final Year CGPA, etc.">
                    </div>

                    <!-- GPA Input Fields -->
                    <div id="gpaFields" class="calculation-fields">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white flex items-center">
                                <i class="fas fa-book text-primary-500 mr-2"></i>
                                Subjects
                            </h3>
                            <button id="addSubject" class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center animate-scale-in" style="animation-delay: 0.2s">
                                <i class="fas fa-plus mr-2"></i>
                                Add Subject
                            </button>
                        </div>

                        <!-- Subjects Table -->
                        <div class="overflow-x-auto mb-6 border border-gray-200 dark:border-gray-600 rounded-lg">
                            <table class="w-full">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-700 dark:text-gray-300">Subject Name</th>
                                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-700 dark:text-gray-300">Credits</th>
                                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-700 dark:text-gray-300">Grade</th>
                                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-700 dark:text-gray-300">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="subjectsContainer" class="divide-y divide-gray-200 dark:divide-gray-600">
                                    <!-- Subjects will be added here dynamically -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- CGPA Input Fields -->
                    <div id="cgpaFields" class="calculation-fields hidden">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white flex items-center">
                                <i class="fas fa-calendar-alt text-primary-500 mr-2"></i>
                                Semesters
                            </h3>
                            <button id="addSemester" class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center animate-scale-in" style="animation-delay: 0.2s">
                                <i class="fas fa-plus mr-2"></i>
                                Add Semester
                            </button>
                        </div>

                        <!-- Semesters Table -->
                        <div class="overflow-x-auto mb-6 border border-gray-200 dark:border-gray-600 rounded-lg">
                            <table class="w-full">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-700 dark:text-gray-300">Semester Name</th>
                                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-700 dark:text-gray-300">Credits</th>
                                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-700 dark:text-gray-300">GPA</th>
                                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-700 dark:text-gray-300">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="semestersContainer" class="divide-y divide-gray-200 dark:divide-gray-600">
                                    <!-- Semesters will be added here dynamically -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Calculate Button -->
                    <button id="calculateBtn" class="w-full bg-primary-500 hover:bg-primary-600 text-white py-3 rounded-lg font-semibold transition-all duration-300 shadow-sm hover:shadow-md active:scale-95 flex items-center justify-center animate-scale-in" style="animation-delay: 0.4s">
                        <i class="fas fa-calculator mr-2"></i>
                        Calculate <span id="calculateText">GPA</span>
                    </button>

                    <!-- Result Display -->
                    <div id="result" class="mt-6 p-6 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600 hidden animate-fade-in">
                        <div class="text-center mb-6">
                            <div class="text-4xl font-bold text-primary-600 dark:text-primary-400 mb-2" id="resultValue"></div>
                            <div class="text-lg font-semibold text-gray-800 dark:text-white mb-1" id="resultTitle"></div>
                            <div class="text-sm text-gray-600 dark:text-gray-400 mb-4" id="formulaUsed"></div>
                        </div>
                        
                        <!-- Details Summary -->
                        <div class="mt-4 p-4 bg-white dark:bg-gray-600 rounded-lg border border-gray-200 dark:border-gray-500">
                            <h4 class="font-semibold text-gray-800 dark:text-white mb-3 flex items-center">
                                <i class="fas fa-info-circle text-primary-500 mr-2"></i>
                                Calculation Details:
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div class="flex justify-between">
                                    <span>Total Credits:</span>
                                    <span class="font-medium" id="totalCredits"></span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Total Grade Points:</span>
                                    <span class="font-medium" id="totalGradePoints"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Items Breakdown -->
                        <div id="itemsBreakdown" class="mt-4 space-y-2 hidden">
                            <h4 class="font-semibold text-gray-800 dark:text-white mb-2 flex items-center" id="breakdownTitle">
                                <i class="fas fa-list text-primary-500 mr-2"></i>
                                Subject-wise Breakdown:
                            </h4>
                            <div id="breakdownList" class="space-y-2"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Grade Guide -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 animate-scale-in" style="animation-delay: 0.2s">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 flex items-center">
                        <i class="fas fa-graduation-cap text-primary-500 mr-2"></i>
                        Grade Points Guide
                    </h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between items-center p-2 bg-gray-50 dark:bg-gray-700 rounded"><span>A+ / A</span><span class="font-semibold text-primary-600">4.0</span></div>
                        <div class="flex justify-between items-center p-2"><span>A-</span><span class="font-semibold text-primary-600">3.7</span></div>
                        <div class="flex justify-between items-center p-2 bg-gray-50 dark:bg-gray-700 rounded"><span>B+</span><span class="font-semibold text-primary-600">3.3</span></div>
                        <div class="flex justify-between items-center p-2"><span>B</span><span class="font-semibold text-primary-600">3.0</span></div>
                        <div class="flex justify-between items-center p-2 bg-gray-50 dark:bg-gray-700 rounded"><span>B-</span><span class="font-semibold text-primary-600">2.7</span></div>
                        <div class="flex justify-between items-center p-2"><span>C+</span><span class="font-semibold text-primary-600">2.3</span></div>
                        <div class="flex justify-between items-center p-2 bg-gray-50 dark:bg-gray-700 rounded"><span>C</span><span class="font-semibold text-primary-600">2.0</span></div>
                        <div class="flex justify-between items-center p-2"><span>C-</span><span class="font-semibold text-primary-600">1.7</span></div>
                        <div class="flex justify-between items-center p-2 bg-gray-50 dark:bg-gray-700 rounded"><span>D+</span><span class="font-semibold text-primary-600">1.3</span></div>
                        <div class="flex justify-between items-center p-2"><span>D</span><span class="font-semibold text-primary-600">1.0</span></div>
                        <div class="flex justify-between items-center p-2 bg-gray-50 dark:bg-gray-700 rounded"><span>F</span><span class="font-semibold text-red-600">0.0</span></div>
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
                        Quick Tips
                    </h3>
                    <ul class="space-y-3 text-sm text-gray-600 dark:text-gray-400">
                        <li class="flex items-start">
                            <i class="fas fa-info-circle text-primary-500 mt-1 mr-3 flex-shrink-0"></i>
                            <span>GPA is for a single semester, CGPA is cumulative</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-info-circle text-primary-500 mt-1 mr-3 flex-shrink-0"></i>
                            <span>Credits typically range from 1 to 4 per subject</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-info-circle text-primary-500 mt-1 mr-3 flex-shrink-0"></i>
                            <span>Sign in to save your calculations permanently</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-info-circle text-primary-500 mt-1 mr-3 flex-shrink-0"></i>
                            <span>Higher credits have more impact on your GPA</span>
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
            const calculationType = document.getElementById('calculationType');
            const gpaFields = document.getElementById('gpaFields');
            const cgpaFields = document.getElementById('cgpaFields');
            const calculateText = document.getElementById('calculateText');
            
            let subjectCount = 0;
            let semesterCount = 0;
            const grades = ['A+', 'A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'C-', 'D+', 'D', 'F'];

            // Load history
            loadHistory();

            // Refresh history
            document.getElementById('refreshHistory').addEventListener('click', loadHistory);

            // Calculate button
            document.getElementById('calculateBtn').addEventListener('click', calculateGPA);

            // Update fields when calculation type changes
            calculationType.addEventListener('change', updateCalculationType);
            
            // Add subject button
            document.getElementById('addSubject').addEventListener('click', function() {
                addSubjectRow();
            });

            // Add semester button
            document.getElementById('addSemester').addEventListener('click', function() {
                addSemesterRow();
            });

            // Initialize
            updateCalculationType();
            addSubjectRow(); // Add initial subject row
            addSemesterRow(); // Add initial semester row

            function updateCalculationType() {
                const type = calculationType.value;
                
                if (type === 'gpa') {
                    gpaFields.classList.remove('hidden');
                    cgpaFields.classList.add('hidden');
                    calculateText.textContent = 'GPA';
                } else {
                    gpaFields.classList.add('hidden');
                    cgpaFields.classList.remove('hidden');
                    calculateText.textContent = 'CGPA';
                }
            }

            function addSubjectRow(name = '', credits = '', grade = 'A') {
                subjectCount++;
                const container = document.getElementById('subjectsContainer');
                const row = document.createElement('tr');
                row.className = 'animate-fade-in';
                row.innerHTML = `
                    <td class="py-3 px-4">
                        <input type="text" class="subject-name w-full p-2 border border-gray-300 dark:border-gray-600 rounded focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors" 
                               placeholder="Subject name" value="${name}">
                    </td>
                    <td class="py-3 px-4">
                        <input type="number" class="subject-credits w-full p-2 border border-gray-300 dark:border-gray-600 rounded focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors" 
                               placeholder="Credits" min="0.5" max="10" step="0.5" value="${credits}">
                    </td>
                    <td class="py-3 px-4">
                        <select class="subject-grade w-full p-2 border border-gray-300 dark:border-gray-600 rounded focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors">
                            ${grades.map(g => `<option value="${g}" ${g === grade ? 'selected' : ''}>${g}</option>`).join('')}
                        </select>
                    </td>
                    <td class="py-3 px-4">
                        <button type="button" class="remove-subject text-red-500 hover:text-red-700 transition-colors p-1" ${subjectCount === 1 ? 'disabled' : ''}>
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;
                container.appendChild(row);

                // Add event listener to remove button
                row.querySelector('.remove-subject').addEventListener('click', function() {
                    if (subjectCount > 1) {
                        row.remove();
                        subjectCount--;
                        updateRemoveButtons('.remove-subject', subjectCount);
                    }
                });

                updateRemoveButtons('.remove-subject', subjectCount);
            }

            function addSemesterRow(name = '', credits = '', gpa = '') {
                semesterCount++;
                const container = document.getElementById('semestersContainer');
                const row = document.createElement('tr');
                row.className = 'animate-fade-in';
                row.innerHTML = `
                    <td class="py-3 px-4">
                        <input type="text" class="semester-name w-full p-2 border border-gray-300 dark:border-gray-600 rounded focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors" 
                               placeholder="Semester name" value="${name}">
                    </td>
                    <td class="py-3 px-4">
                        <input type="number" class="semester-credits w-full p-2 border border-gray-300 dark:border-gray-600 rounded focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors" 
                               placeholder="Credits" min="1" max="50" step="1" value="${credits}">
                    </td>
                    <td class="py-3 px-4">
                        <input type="number" class="semester-gpa w-full p-2 border border-gray-300 dark:border-gray-600 rounded focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors" 
                               placeholder="GPA" min="0" max="4.0" step="0.01" value="${gpa}">
                    </td>
                    <td class="py-3 px-4">
                        <button type="button" class="remove-semester text-red-500 hover:text-red-700 transition-colors p-1" ${semesterCount === 1 ? 'disabled' : ''}>
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;
                container.appendChild(row);

                // Add event listener to remove button
                row.querySelector('.remove-semester').addEventListener('click', function() {
                    if (semesterCount > 1) {
                        row.remove();
                        semesterCount--;
                        updateRemoveButtons('.remove-semester', semesterCount);
                    }
                });

                updateRemoveButtons('.remove-semester', semesterCount);
            }

            function updateRemoveButtons(selector, count) {
                const removeButtons = document.querySelectorAll(selector);
                removeButtons.forEach(btn => {
                    btn.disabled = count === 1;
                    if (btn.disabled) {
                        btn.classList.add('opacity-50', 'cursor-not-allowed');
                    } else {
                        btn.classList.remove('opacity-50', 'cursor-not-allowed');
                    }
                });
            }

            function calculateGPA() {
                const type = calculationType.value;
                let data = {};

                if (type === 'gpa') {
                    data = getSubjectsData();
                    if (!data.valid) {
                        alert('Please fill in all subject names and credits correctly.');
                        return;
                    }
                } else {
                    data = getSemestersData();
                    if (!data.valid) {
                        alert('Please fill in all semester names, credits, and GPA correctly.');
                        return;
                    }
                }

                const calculationName = document.getElementById('calculationName').value;

                // Show loading
                const calculateBtn = document.getElementById('calculateBtn');
                calculateBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Calculating...';
                calculateBtn.disabled = true;

                // Simulate calculation (replace with actual API call)
                setTimeout(() => {
                    const result = simulateCalculation(type, data);
                    displayResult(result);
                    saveToHistory(calculationName, type, data, result);
                    calculateBtn.innerHTML = `<i class="fas fa-calculator mr-2"></i>Calculate ${type.toUpperCase()}`;
                    calculateBtn.disabled = false;
                }, 1000);
            }

            function simulateCalculation(type, data) {
                if (type === 'gpa') {
                    return calculateGPAFromSubjects(data.subjects);
                } else {
                    return calculateCGPAFromSemesters(data.semesters);
                }
            }

            function calculateGPAFromSubjects(subjects) {
                let totalCredits = 0;
                let totalGradePoints = 0;
                const breakdown = [];

                subjects.forEach(subject => {
                    const gradePoint = getGradePoint(subject.grade);
                    const points = subject.credits * gradePoint;
                    totalCredits += subject.credits;
                    totalGradePoints += points;
                    breakdown.push({
                        name: subject.name,
                        credits: subject.credits,
                        grade: subject.grade,
                        gradePoint: gradePoint,
                        points: points
                    });
                });

                const gpa = totalGradePoints / totalCredits;

                return {
                    result: gpa.toFixed(2),
                    total_credits: totalCredits,
                    total_grade_points: totalGradePoints,
                    formula: `GPA = Total Grade Points ÷ Total Credits\n= ${totalGradePoints.toFixed(2)} ÷ ${totalCredits} = ${gpa.toFixed(2)}`,
                    breakdown: breakdown,
                    type: 'gpa'
                };
            }

            function calculateCGPAFromSemesters(semesters) {
                let totalCredits = 0;
                let totalGradePoints = 0;
                const breakdown = [];

                semesters.forEach(semester => {
                    const points = semester.credits * semester.gpa;
                    totalCredits += semester.credits;
                    totalGradePoints += points;
                    breakdown.push({
                        name: semester.name,
                        credits: semester.credits,
                        gpa: semester.gpa,
                        points: points
                    });
                });

                const cgpa = totalGradePoints / totalCredits;

                return {
                    result: cgpa.toFixed(2),
                    total_credits: totalCredits,
                    total_grade_points: totalGradePoints,
                    formula: `CGPA = Total (Credits × GPA) ÷ Total Credits\n= ${totalGradePoints.toFixed(2)} ÷ ${totalCredits} = ${cgpa.toFixed(2)}`,
                    breakdown: breakdown,
                    type: 'cgpa'
                };
            }

            function getSubjectsData() {
                const subjects = [];
                const rows = document.querySelectorAll('#subjectsContainer tr');
                let valid = true;
                
                rows.forEach(row => {
                    const name = row.querySelector('.subject-name').value.trim();
                    const credits = row.querySelector('.subject-credits').value;
                    const grade = row.querySelector('.subject-grade').value;

                    if (!name || !credits || credits <= 0) {
                        valid = false;
                        if (!name) row.querySelector('.subject-name').classList.add('border-red-500');
                        if (!credits || credits <= 0) row.querySelector('.subject-credits').classList.add('border-red-500');
                    } else {
                        row.querySelector('.subject-name').classList.remove('border-red-500');
                        row.querySelector('.subject-credits').classList.remove('border-red-500');
                        subjects.push({ name, credits: parseFloat(credits), grade });
                    }
                });

                return { valid, subjects };
            }

            function getSemestersData() {
                const semesters = [];
                const rows = document.querySelectorAll('#semestersContainer tr');
                let valid = true;
                
                rows.forEach(row => {
                    const name = row.querySelector('.semester-name').value.trim();
                    const credits = row.querySelector('.semester-credits').value;
                    const gpa = row.querySelector('.semester-gpa').value;

                    if (!name || !credits || credits <= 0 || !gpa || gpa < 0 || gpa > 4.0) {
                        valid = false;
                        if (!name) row.querySelector('.semester-name').classList.add('border-red-500');
                        if (!credits || credits <= 0) row.querySelector('.semester-credits').classList.add('border-red-500');
                        if (!gpa || gpa < 0 || gpa > 4.0) row.querySelector('.semester-gpa').classList.add('border-red-500');
                    } else {
                        row.querySelector('.semester-name').classList.remove('border-red-500');
                        row.querySelector('.semester-credits').classList.remove('border-red-500');
                        row.querySelector('.semester-gpa').classList.remove('border-red-500');
                        semesters.push({ name, credits: parseFloat(credits), gpa: parseFloat(gpa) });
                    }
                });

                return { valid, semesters };
            }

            function displayResult(data) {
                const resultDiv = document.getElementById('result');
                const resultValue = document.getElementById('resultValue');
                const resultTitle = document.getElementById('resultTitle');
                const formulaUsed = document.getElementById('formulaUsed');
                const totalCredits = document.getElementById('totalCredits');
                const totalGradePoints = document.getElementById('totalGradePoints');
                const breakdownList = document.getElementById('breakdownList');
                const breakdownTitle = document.getElementById('breakdownTitle');
                const itemsBreakdown = document.getElementById('itemsBreakdown');

                resultValue.textContent = data.result;
                resultTitle.textContent = data.type === 'gpa' ? 'Your GPA' : 'Your CGPA';
                formulaUsed.textContent = data.formula;
                totalCredits.textContent = data.total_credits;
                totalGradePoints.textContent = data.total_grade_points.toFixed(2);

                // Create breakdown
                breakdownList.innerHTML = '';
                if (data.type === 'gpa') {
                    breakdownTitle.innerHTML = '<i class="fas fa-book text-primary-500 mr-2"></i>Subject-wise Breakdown:';
                    data.breakdown.forEach(subject => {
                        const div = document.createElement('div');
                        div.className = 'flex justify-between text-sm p-3 bg-white dark:bg-gray-600 rounded border border-gray-200 dark:border-gray-500';
                        div.innerHTML = `
                            <div>
                                <div class="font-medium">${subject.name}</div>
                                <div class="text-xs text-gray-500">${subject.credits} credits</div>
                            </div>
                            <div class="text-right">
                                <div class="font-semibold">${subject.grade} (${subject.gradePoint})</div>
                                <div class="text-xs text-gray-500">${subject.points.toFixed(2)} points</div>
                            </div>
                        `;
                        breakdownList.appendChild(div);
                    });
                } else {
                    breakdownTitle.innerHTML = '<i class="fas fa-calendar-alt text-primary-500 mr-2"></i>Semester-wise Breakdown:';
                    data.breakdown.forEach(semester => {
                        const div = document.createElement('div');
                        div.className = 'flex justify-between text-sm p-3 bg-white dark:bg-gray-600 rounded border border-gray-200 dark:border-gray-500';
                        div.innerHTML = `
                            <div>
                                <div class="font-medium">${semester.name}</div>
                                <div class="text-xs text-gray-500">${semester.credits} credits</div>
                            </div>
                            <div class="text-right">
                                <div class="font-semibold">GPA: ${semester.gpa}</div>
                                <div class="text-xs text-gray-500">${semester.points.toFixed(2)} points</div>
                            </div>
                        `;
                        breakdownList.appendChild(div);
                    });
                }

                itemsBreakdown.classList.remove('hidden');
                resultDiv.classList.remove('hidden');
                
                // Scroll to result
                resultDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }

            function getGradePoint(grade) {
                const gradePoints = {
                    'A+': 4.0, 'A': 4.0, 'A-': 3.7,
                    'B+': 3.3, 'B': 3.0, 'B-': 2.7,
                    'C+': 2.3, 'C': 2.0, 'C-': 1.7,
                    'D+': 1.3, 'D': 1.0, 'F': 0.0
                };
                return gradePoints[grade] || 0.0;
            }

            function saveToHistory(name, type, inputs, result) {
                const history = JSON.parse(localStorage.getItem('gpaHistory') || '[]');
                history.push({
                    id: Date.now(),
                    name: name || `${type.toUpperCase()} Calculation`,
                    type: type,
                    inputs: inputs,
                    result: result.result,
                    total_credits: result.total_credits,
                    items_count: type === 'gpa' ? inputs.subjects.length : inputs.semesters.length,
                    timestamp: new Date().toISOString()
                });
                localStorage.setItem('gpaHistory', JSON.stringify(history));
                loadHistory();
            }

            function loadHistory() {
                // Simulate loading history from localStorage
                const history = JSON.parse(localStorage.getItem('gpaHistory') || '[]');
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
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 border border-gray-200 dark:border-gray-600 animate-fade-in">
                        <div class="flex justify-between items-start mb-2">
                            <div class="font-medium text-gray-800 dark:text-white text-sm">${calc.name}</div>
                            <button class="delete-calculation text-red-500 hover:text-red-700 transition-colors p-1" data-id="${calc.id}">
                                <i class="fas fa-trash text-xs"></i>
                            </button>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-primary-600 dark:text-primary-400 font-semibold">${calc.type.toUpperCase()}: ${calc.result}</span>
                            <span class="text-gray-500 dark:text-gray-400 text-xs">${new Date(calc.timestamp).toLocaleDateString()}</span>
                        </div>
                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            ${calc.total_credits} credits • ${calc.items_count} ${calc.type === 'gpa' ? 'subjects' : 'semesters'}
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

            function deleteCalculation(id) {
                if (!confirm('Are you sure you want to delete this calculation?')) {
                    return;
                }

                const history = JSON.parse(localStorage.getItem('gpaHistory') || '[]');
                const updatedHistory = history.filter(calc => calc.id != id);
                localStorage.setItem('gpaHistory', JSON.stringify(updatedHistory));
                loadHistory();
            }
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

                    // Mobile menu toggle
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
            }
        });
    </script>
</body>
</html>