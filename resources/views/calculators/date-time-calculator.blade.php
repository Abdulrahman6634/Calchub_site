<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='%2322c55e'><path fill-rule='evenodd' d='M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V4a2 2 0 00-2-2H6zm1 2a1 1 0 000 2h6a1 1 0 100-2H7zm6 7a1 1 0 00-1 1v1H7v-1a1 1 0 00-2 0v1a2 2 0 002 2h6a2 2 0 002-2v-1a1 1 0 00-1-1z' clip-rule='evenodd'/></svg>">
    <title>Date & Time Calculator - CalcHub</title>
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
</head>
<body class="bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
    <!-- Header/Navigation -->
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
                    <button class="flex items-center space-x-2 bg-gray-100 dark:bg-gray-700 rounded-lg px-3 py-2">
                        <div class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-white font-medium">
                            J
                        </div>
                        <span class="text-gray-700 dark:text-gray-300 font-medium">John</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 border border-gray-200 dark:border-gray-700">
                        <a href="{{ route('profile') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"><i class="fas fa-user mr-2"></i>Profile</a>
                        <div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>
                        <form method="POST" action="#">
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
    <div class="container mx-auto px-4 py-8">
        <!-- Welcome Section -->
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-2">Date & Time Calculator ⏰</h1>
            <p class="text-gray-600 dark:text-gray-400">Calculate date differences, add/subtract time, and count business days</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 max-w-7xl mx-auto">
            <!-- Calculator Card -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <!-- Calculation Type Selector -->
                    <div class="mb-6">
                        <label for="calculationType" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Calculation Type
                        </label>
                        <select id="calculationType" class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors">
                            <option value="difference">Date Difference 📅</option>
                            <option value="add">Add to Date ➕</option>
                            <option value="subtract">Subtract from Date ➖</option>
                            <option value="business_days">Business Days 💼</option>
                        </select>
                    </div>

                    <!-- Calculation Name -->
                    <div class="mb-6">
                        <label for="calculationName" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Calculation Name (Optional)
                        </label>
                        <input type="text" id="calculationName" 
                               class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors" 
                               placeholder="e.g., Project Timeline, Vacation Days, etc.">
                    </div>

                    <!-- Dynamic Input Fields -->
                    <div id="inputFields" class="space-y-4 mb-6">
                        <!-- Date Difference Fields -->
                        <div id="differenceFields" class="calculation-fields">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Start Date & Time</label>
                                    <div class="space-y-2">
                                        <input type="date" id="start_date" class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors" value="{{ date('Y-m-d') }}">
                                        <input type="time" id="start_time" class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors" value="00:00">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">End Date & Time</label>
                                    <div class="space-y-2">
                                        <input type="date" id="end_date" class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors" value="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                        <input type="time" id="end_time" class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors" value="00:00">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Add/Subtract Fields -->
                        <div id="addSubtractFields" class="calculation-fields hidden">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Base Date & Time</label>
                                    <div class="space-y-2">
                                        <input type="date" id="base_date" class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors" value="{{ date('Y-m-d') }}">
                                        <input type="time" id="base_time" class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors" value="00:00">
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3">
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Years</label>
                                    <input type="number" id="add_years" class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors" min="0" value="0">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Months</label>
                                    <input type="number" id="add_months" class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors" min="0" value="0">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Days</label>
                                    <input type="number" id="add_days" class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors" min="0" value="0">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Hours</label>
                                    <input type="number" id="add_hours" class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors" min="0" value="0">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Minutes</label>
                                    <input type="number" id="add_minutes" class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors" min="0" value="0">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Seconds</label>
                                    <input type="number" id="add_seconds" class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors" min="0" value="0">
                                </div>
                            </div>
                        </div>

                        <!-- Business Days Fields -->
                        <div id="businessDaysFields" class="calculation-fields hidden">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Start Date</label>
                                    <input type="date" id="business_start_date" class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors" value="{{ date('Y-m-d') }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">End Date</label>
                                    <input type="date" id="business_end_date" class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors" value="{{ date('Y-m-d', strtotime('+7 days')) }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Calculate Button -->
                    <button id="calculateBtn" class="w-full bg-primary-500 hover:bg-primary-600 text-white py-3 rounded-lg font-semibold transition-all duration-300 shadow-sm hover:shadow-md active:scale-95 flex items-center justify-center">
                        <i class="fas fa-calculator mr-2"></i>
                        Calculate Date & Time
                    </button>

                    <!-- Result Display -->
                    <div id="result" class="mt-6 p-6 bg-gray-50 dark:bg-gray-700 rounded-lg hidden">
                        <div class="text-center mb-6">
                            <div class="text-4xl font-bold text-primary-600 dark:text-primary-400 mb-2" id="mainResult"></div>
                            <div class="text-lg font-semibold text-gray-800 dark:text-white mb-1" id="resultTitle"></div>
                        </div>
                        
                        <!-- Detailed Results -->
                        <div id="detailedResults" class="space-y-4"></div>

                        <!-- Formula Used -->
                        <div class="mt-4 p-4 bg-white dark:bg-gray-600 rounded-lg">
                            <h4 class="font-semibold text-gray-800 dark:text-white mb-3">Calculation Steps:</h4>
                            <div id="formulaUsed" class="text-sm text-gray-600 dark:text-gray-400 whitespace-pre-line"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Quick Examples -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Quick Examples</h3>
                    <div class="space-y-3 text-sm">
                        <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors" onclick="loadExample('difference', 'one_week')">
                            <div class="font-medium text-gray-800 dark:text-white">1 Week Difference</div>
                            <div class="text-gray-600 dark:text-gray-400 text-xs">Calculate 7 days difference</div>
                        </div>
                        <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors" onclick="loadExample('add', 'add_month')">
                            <div class="font-medium text-gray-800 dark:text-white">Add 1 Month</div>
                            <div class="text-gray-600 dark:text-gray-400 text-xs">Add 30 days to current date</div>
                        </div>
                        <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors" onclick="loadExample('business_days', 'work_week')">
                            <div class="font-medium text-gray-800 dark:text-white">Business Week</div>
                            <div class="text-gray-600 dark:text-gray-400 text-xs">5 business days calculation</div>
                        </div>
                    </div>
                </div>

                <!-- Calculation History -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Recent Calculations</h3>
                        <button id="refreshHistory" class="text-primary-500 hover:text-primary-600 transition-colors">
                            <i class="fas fa-refresh"></i>
                        </button>
                    </div>
                    <div id="historyList" class="space-y-3 max-h-96 overflow-y-auto">
                        <!-- History items will be loaded here -->
                        <div class="text-center text-gray-500 dark:text-gray-400 py-4">
                            No calculation history yet
                        </div>
                    </div>
                </div>

                <!-- Quick Tips -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Quick Tips</h3>
                    <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                        <li class="flex items-start">
                            <i class="fas fa-lightbulb text-primary-500 mt-1 mr-2 flex-shrink-0"></i>
                            <span>Business days exclude weekends (Saturday & Sunday)</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-lightbulb text-primary-500 mt-1 mr-2 flex-shrink-0"></i>
                            <span>Date difference includes years, months, days, and time</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-lightbulb text-primary-500 mt-1 mr-2 flex-shrink-0"></i>
                            <span>Add/subtract supports any combination of time units</span>
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
                <div class="text-gray-400 text-sm">
                    &copy; 2023 CalcHub. All rights reserved.
                </div>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calculationType = document.getElementById('calculationType');
            const inputFields = document.getElementById('inputFields');
            
            // Load history
            loadHistory();

            // Refresh history
            document.getElementById('refreshHistory').addEventListener('click', loadHistory);

            // Calculate button
            document.getElementById('calculateBtn').addEventListener('click', calculateDateTime);

            // Update input fields when calculation type changes
            calculationType.addEventListener('change', updateInputFields);
            
            // Initialize input fields
            updateInputFields();

            function updateInputFields() {
                const type = calculationType.value;
                
                // Hide all fields first
                document.querySelectorAll('.calculation-fields').forEach(field => {
                    field.classList.add('hidden');
                });

                // Show relevant fields
                switch (type) {
                    case 'difference':
                        document.getElementById('differenceFields').classList.remove('hidden');
                        break;
                    case 'add':
                    case 'subtract':
                        document.getElementById('addSubtractFields').classList.remove('hidden');
                        break;
                    case 'business_days':
                        document.getElementById('businessDaysFields').classList.remove('hidden');
                        break;
                }
            }

            function calculateDateTime() {
                const type = calculationType.value;
                const inputs = getInputValues(type);

                if (!validateInputs(type, inputs)) {
                    alert('Please fill in all required fields correctly.');
                    return;
                }

                const calculationName = document.getElementById('calculationName').value;

                // Show loading
                const calculateBtn = document.getElementById('calculateBtn');
                calculateBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Calculating...';
                calculateBtn.disabled = true;

                fetch("{{ route('date-time.calculate') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        calculation_type: type,
                        ...inputs,
                        calculation_name: calculationName
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displayResult(data);
                        loadHistory(); // Refresh history
                    } else {
                        alert(data.error || 'Calculation failed. Please try again.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                })
                .finally(() => {
                    calculateBtn.innerHTML = '<i class="fas fa-calculator mr-2"></i>Calculate Date & Time';
                    calculateBtn.disabled = false;
                });
            }

            function getInputValues(type) {
                const inputs = {};
                
                switch (type) {
                    case 'difference':
                        inputs.start_date = document.getElementById('start_date').value;
                        inputs.start_time = document.getElementById('start_time').value;
                        inputs.end_date = document.getElementById('end_date').value;
                        inputs.end_time = document.getElementById('end_time').value;
                        break;
                    case 'add':
                        inputs.base_date = document.getElementById('base_date').value;
                        inputs.base_time = document.getElementById('base_time').value;
                        inputs.add_years = document.getElementById('add_years').value;
                        inputs.add_months = document.getElementById('add_months').value;
                        inputs.add_days = document.getElementById('add_days').value;
                        inputs.add_hours = document.getElementById('add_hours').value;
                        inputs.add_minutes = document.getElementById('add_minutes').value;
                        inputs.add_seconds = document.getElementById('add_seconds').value;
                        break;
                    case 'subtract':
                        inputs.base_date = document.getElementById('base_date').value;
                        inputs.base_time = document.getElementById('base_time').value;
                        inputs.subtract_years = document.getElementById('add_years').value;
                        inputs.subtract_months = document.getElementById('add_months').value;
                        inputs.subtract_days = document.getElementById('add_days').value;
                        inputs.subtract_hours = document.getElementById('add_hours').value;
                        inputs.subtract_minutes = document.getElementById('add_minutes').value;
                        inputs.subtract_seconds = document.getElementById('add_seconds').value;
                        break;
                    case 'business_days':
                        inputs.start_date = document.getElementById('business_start_date').value;
                        inputs.end_date = document.getElementById('business_end_date').value;
                        break;
                }
                
                return inputs;
            }

            function validateInputs(type, inputs) {
                switch (type) {
                    case 'difference':
                        return inputs.start_date && inputs.end_date && inputs.start_time && inputs.end_time;
                    case 'add':
                    case 'subtract':
                        return inputs.base_date && inputs.base_time;
                    case 'business_days':
                        return inputs.start_date && inputs.end_date;
                    default:
                        return false;
                }
            }

            function displayResult(data) {
                const resultDiv = document.getElementById('result');
                const mainResult = document.getElementById('mainResult');
                const resultTitle = document.getElementById('resultTitle');
                const detailedResults = document.getElementById('detailedResults');
                const formulaUsed = document.getElementById('formulaUsed');

                const type = data.calculation_type;
                const results = data.results;

                // Set main result and title
                switch (type) {
                    case 'difference':
                        mainResult.textContent = `${results.total_days} days`;
                        resultTitle.textContent = 'Total Difference';
                        break;
                    case 'add':
                    case 'subtract':
                        mainResult.textContent = new Date(results.result_date).toLocaleString();
                        resultTitle.textContent = type === 'add' ? 'Result Date (After Addition)' : 'Result Date (After Subtraction)';
                        break;
                    case 'business_days':
                        mainResult.textContent = `${results.business_days} days`;
                        resultTitle.textContent = 'Business Days';
                        break;
                }

                // Create detailed results
                detailedResults.innerHTML = '';
                if (type === 'difference') {
                    const breakdown = `
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            <div class="bg-white dark:bg-gray-600 p-3 rounded-lg text-center">
                                <div class="text-2xl font-bold text-blue-600">${results.years}</div>
                                <div class="text-xs text-gray-600 dark:text-gray-400">Years</div>
                            </div>
                            <div class="bg-white dark:bg-gray-600 p-3 rounded-lg text-center">
                                <div class="text-2xl font-bold text-blue-600">${results.months}</div>
                                <div class="text-xs text-gray-600 dark:text-gray-400">Months</div>
                            </div>
                            <div class="bg-white dark:bg-gray-600 p-3 rounded-lg text-center">
                                <div class="text-2xl font-bold text-blue-600">${results.days}</div>
                                <div class="text-xs text-gray-600 dark:text-gray-400">Days</div>
                            </div>
                            <div class="bg-white dark:bg-gray-600 p-3 rounded-lg text-center">
                                <div class="text-2xl font-bold text-blue-600">${results.total_weeks}</div>
                                <div class="text-xs text-gray-600 dark:text-gray-400">Weeks</div>
                            </div>
                            <div class="bg-white dark:bg-gray-600 p-3 rounded-lg text-center">
                                <div class="text-2xl font-bold text-green-600">${results.total_hours.toLocaleString()}</div>
                                <div class="text-xs text-gray-600 dark:text-gray-400">Hours</div>
                            </div>
                            <div class="bg-white dark:bg-gray-600 p-3 rounded-lg text-center">
                                <div class="text-2xl font-bold text-green-600">${results.total_minutes.toLocaleString()}</div>
                                <div class="text-xs text-gray-600 dark:text-gray-400">Minutes</div>
                            </div>
                            <div class="bg-white dark:bg-gray-600 p-3 rounded-lg text-center">
                                <div class="text-2xl font-bold text-green-600">${results.total_seconds.toLocaleString()}</div>
                                <div class="text-xs text-gray-600 dark:text-gray-400">Seconds</div>
                            </div>
                        </div>
                    `;
                    detailedResults.innerHTML = breakdown;
                } else if (type === 'business_days') {
                    const breakdown = `
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-white dark:bg-gray-600 p-4 rounded-lg text-center">
                                <div class="text-2xl font-bold text-primary-600">${results.business_days}</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">Business Days</div>
                            </div>
                            <div class="bg-white dark:bg-gray-600 p-4 rounded-lg text-center">
                                <div class="text-2xl font-bold text-blue-600">${results.total_days}</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">Total Days</div>
                            </div>
                            <div class="bg-white dark:bg-gray-600 p-4 rounded-lg text-center">
                                <div class="text-2xl font-bold text-orange-600">${results.weekend_days}</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">Weekend Days</div>
                            </div>
                        </div>
                    `;
                    detailedResults.innerHTML = breakdown;
                }

                formulaUsed.textContent = data.formula;
                resultDiv.classList.remove('hidden');
                
                // Scroll to result
                resultDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }

            function loadHistory() {
                fetch("{{ route('date-time.history') }}")
                    .then(response => response.json())
                    .then(data => {
                        const historyList = document.getElementById('historyList');
                        
                        if (data.calculations.length === 0) {
                            historyList.innerHTML = '<div class="text-center text-gray-500 dark:text-gray-400 py-4">No calculation history yet</div>';
                            return;
                        }

                        historyList.innerHTML = data.calculations.map(calc => {
                            let resultText = '';
                            switch (calc.type) {
                                case 'difference':
                                    resultText = `${calc.results.total_days} days difference`;
                                    break;
                                case 'add':
                                case 'subtract':
                                    resultText = new Date(calc.results.result_date).toLocaleDateString();
                                    break;
                                case 'business_days':
                                    resultText = `${calc.results.business_days} business days`;
                                    break;
                            }

                            return `
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3">
                                    <div class="flex justify-between items-start mb-2">
                                        <div class="font-medium text-gray-800 dark:text-white text-sm">${calc.name}</div>
                                        <button class="delete-calculation text-red-500 hover:text-red-700 transition-colors" data-id="${calc.id}">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </div>
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="text-primary-600 dark:text-primary-400 font-semibold">
                                            ${calc.type_icon} ${resultText}
                                        </span>
                                        <span class="text-gray-500 dark:text-gray-400 text-xs">${calc.date}</span>
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        ${calc.type_name}
                                    </div>
                                </div>
                            `;
                        }).join('');

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

            function deleteCalculation(id) {
                if (!confirm('Are you sure you want to delete this calculation?')) {
                    return;
                }

                fetch(`/calculators/date-time/${id}`, {
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
                    } else {
                        alert('Failed to delete calculation.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while deleting.');
                });
            }

            // Example loader function
            window.loadExample = function(type, example) {
                calculationType.value = type;
                updateInputFields();
                
                const examples = {
                    'difference': {
                        'one_week': {
                            start_date: '{{ date("Y-m-d") }}',
                            end_date: '{{ date("Y-m-d", strtotime("+7 days")) }}',
                            start_time: '00:00',
                            end_time: '00:00'
                        }
                    },
                    'add': {
                        'add_month': {
                            base_date: '{{ date("Y-m-d") }}',
                            base_time: '00:00',
                            add_years: 0,
                            add_months: 1,
                            add_days: 0,
                            add_hours: 0,
                            add_minutes: 0,
                            add_seconds: 0
                        }
                    },
                    'business_days': {
                        'work_week': {
                            business_start_date: '{{ date("Y-m-d") }}',
                            business_end_date: '{{ date("Y-m-d", strtotime("+4 days")) }}'
                        }
                    }
                };
                
                const exampleData = examples[type]?.[example];
                if (exampleData) {
                    Object.entries(exampleData).forEach(([key, value]) => {
                        const element = document.getElementById(key);
                        if (element) {
                            element.value = value;
                        }
                    });
                }
            };
        });

        // Mobile menu toggle
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
            }

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
        });
    </script>
</body>
</html>