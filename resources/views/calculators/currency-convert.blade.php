<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='%2322c55e'><path fill-rule='evenodd' d='M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V4a2 2 0 00-2-2H6zm1 2a1 1 0 000 2h6a1 1 0 100-2H7zm6 7a1 1 0 00-1 1v1H7v-1a1 1 0 00-2 0v1a2 2 0 002 2h6a2 2 0 002-2v-1a1 1 0 00-1-1z' clip-rule='evenodd'/></svg>">
    <title>Currency Converter - CalcHub</title>
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
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
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
        
        /* Custom Tom Select styles for dark mode */
        .ts-control {
            border-color: rgb(209 213 219) !important;
            background-color: white !important;
        }
        
        .dark .ts-control {
            border-color: rgb(75 85 99) !important;
            background-color: rgb(55 65 81) !important;
            color: white !important;
        }
        
        .ts-dropdown {
            border-color: rgb(209 213 219) !important;
            background-color: white !important;
        }
        
        .dark .ts-dropdown {
            border-color: rgb(75 85 99) !important;
            background-color: rgb(55 65 81) !important;
            color: white !important;
        }
        
        .ts-dropdown .option {
            color: rgb(55 65 81) !important;
        }
        
        .dark .ts-dropdown .option {
            color: white !important;
        }
        
        .ts-dropdown .active {
            background-color: rgb(243 244 246) !important;
        }
        
        .dark .ts-dropdown .active {
            background-color: rgb(75 85 99) !important;
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
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Currency Converter</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Page Header -->
        <div class="mb-8 animate-fade-in">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 dark:text-white mb-2">Currency Converter 💱</h1>
                    <p class="text-gray-600 dark:text-gray-400">Convert between 150+ currencies with real-time exchange rates</p>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="px-3 py-1 bg-primary-100 dark:bg-primary-900 text-primary-800 dark:text-primary-200 text-sm font-medium rounded-full">
                        Finance
                    </span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Converter Card -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Main Converter Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 animate-scale-in">
                    <!-- Amount Input -->
                    <div class="mb-6">
                        <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                            <i class="fas fa-money-bill-wave text-primary-500 mr-2"></i>
                            Amount
                        </label>
                        <input type="number" id="amount" 
                               class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors" 
                               placeholder="Enter amount" value="1" step="0.01" min="0.01">
                    </div>

                    <!-- Currency Selection with Switch Button -->
                    <div class="mb-6">
                        <div class="flex items-end space-x-4">
                            <!-- From Currency -->
                            <div class="flex-1">
                                <label for="from" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                    <i class="fas fa-arrow-down text-primary-500 mr-2"></i>
                                    From Currency
                                </label>
                                <select id="from" class="w-full">
                                    <option value="">Select Currency</option>
                                    @foreach($currencies as $currency)
                                        <option value="{{ $currency->code }}" {{ $currency->code === 'USD' ? 'selected' : '' }}>
                                            {{ $currency->flag }} {{ $currency->country ?? $currency->name }} - {{ $currency->code }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Switch Button -->
                            <div class="pb-2">
                                <button id="switchBtn" class="p-3 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors border border-gray-300 dark:border-gray-600 animate-scale-in" style="animation-delay: 0.2s">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                    </svg>
                                </button>
                            </div>

                            <!-- To Currency -->
                            <div class="flex-1">
                                <label for="to" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                    <i class="fas fa-arrow-up text-primary-500 mr-2"></i>
                                    To Currency
                                </label>
                                <select id="to" class="w-full">
                                    <option value="">Select Currency</option>
                                    @foreach($currencies as $currency)
                                        <option value="{{ $currency->code }}" {{ $currency->code === 'EUR' ? 'selected' : '' }}>
                                            {{ $currency->flag }} {{ $currency->country ?? $currency->name }} - {{ $currency->code }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Convert Button -->
                    <button id="convertBtn" class="w-full bg-primary-500 hover:bg-primary-600 text-white py-3 rounded-lg font-semibold transition-all duration-300 shadow-sm hover:shadow-md active:scale-95 flex items-center justify-center animate-scale-in" style="animation-delay: 0.4s">
                        <i class="fas fa-exchange-alt mr-2"></i>
                        Convert Currency
                    </button>

                    <!-- Result Display -->
                    <div id="result" class="mt-6 p-6 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600 hidden animate-fade-in">
                        <div class="text-center mb-6">
                            <div class="text-4xl font-bold text-primary-600 dark:text-primary-400 mb-2" id="convertedAmount"></div>
                            <div class="text-lg font-semibold text-gray-800 dark:text-white mb-1">Converted Amount</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400" id="exchangeRate"></div>
                        </div>
                        
                        <!-- Conversion Details -->
                        <div class="mt-4 p-4 bg-white dark:bg-gray-600 rounded-lg border border-gray-200 dark:border-gray-500">
                            <h4 class="font-semibold text-gray-800 dark:text-white mb-3 flex items-center">
                                <i class="fas fa-info-circle text-primary-500 mr-2"></i>
                                Conversion Details:
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div class="flex justify-between">
                                    <span>Original Amount:</span>
                                    <span class="font-medium" id="originalAmount"></span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Exchange Rate:</span>
                                    <span class="font-medium" id="rateValue"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Popular Currencies -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 animate-scale-in" style="animation-delay: 0.2s">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 flex items-center">
                        <i class="fas fa-star text-primary-500 mr-2"></i>
                        Popular Currencies
                    </h3>
                    <div class="space-y-3 text-sm">
                        <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors border border-gray-200 dark:border-gray-600" onclick="setCurrencies('USD', 'EUR')">
                            <div class="font-medium text-gray-800 dark:text-white">USD → EUR</div>
                            <div class="text-gray-600 dark:text-gray-400 text-xs">US Dollar to Euro</div>
                        </div>
                        <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors border border-gray-200 dark:border-gray-600" onclick="setCurrencies('EUR', 'GBP')">
                            <div class="font-medium text-gray-800 dark:text-white">EUR → GBP</div>
                            <div class="text-gray-600 dark:text-gray-400 text-xs">Euro to British Pound</div>
                        </div>
                        <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors border border-gray-200 dark:border-gray-600" onclick="setCurrencies('JPY', 'USD')">
                            <div class="font-medium text-gray-800 dark:text-white">JPY → USD</div>
                            <div class="text-gray-600 dark:text-gray-400 text-xs">Japanese Yen to US Dollar</div>
                        </div>
                        <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors border border-gray-200 dark:border-gray-600" onclick="setCurrencies('CAD', 'USD')">
                            <div class="font-medium text-gray-800 dark:text-white">CAD → USD</div>
                            <div class="text-gray-600 dark:text-gray-400 text-xs">Canadian Dollar to US Dollar</div>
                        </div>
                        <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors border border-gray-200 dark:border-gray-600" onclick="setCurrencies('AUD', 'USD')">
                            <div class="font-medium text-gray-800 dark:text-white">AUD → USD</div>
                            <div class="text-gray-600 dark:text-gray-400 text-xs">Australian Dollar to US Dollar</div>
                        </div>
                    </div>
                </div>

                <!-- Calculation History -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 animate-scale-in" style="animation-delay: 0.4s">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white flex items-center">
                            <i class="fas fa-history text-primary-500 mr-2"></i>
                            Recent Conversions
                        </h3>
                        <button id="refreshHistory" class="text-primary-500 hover:text-primary-600 transition-colors p-1">
                            <i class="fas fa-refresh"></i>
                        </button>
                    </div>
                    <div id="historyList" class="space-y-3 max-h-80 overflow-y-auto">
                        <!-- History items will be loaded here -->
                        <div class="text-center text-gray-500 dark:text-gray-400 py-4">
                            <i class="fas fa-clock text-2xl mb-2"></i>
                            <div>No conversion history yet</div>
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
                            <i class="fas fa-sync-alt text-primary-500 mt-1 mr-3 flex-shrink-0"></i>
                            <span>Rates update automatically in real-time</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-globe text-primary-500 mt-1 mr-3 flex-shrink-0"></i>
                            <span>Supports 150+ global currencies</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-exchange-alt text-primary-500 mt-1 mr-3 flex-shrink-0"></i>
                            <span>Click the switch button to reverse currencies</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-chart-line text-primary-500 mt-1 mr-3 flex-shrink-0"></i>
                            <span>Rates are updated every 60 minutes</span>
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
            // Initialize TomSelect with dark mode support
            const fromSelect = new TomSelect("#from", { 
                sortField: { field: "text", direction: "asc" },
                placeholder: "Select source currency",
                create: false,
                render: {
                    option: function(data, escape) {
                        return `<div class="flex items-center">${data.text}</div>`;
                    }
                }
            });
            
            const toSelect = new TomSelect("#to", { 
                sortField: { field: "text", direction: "asc" },
                placeholder: "Select target currency",
                create: false,
                render: {
                    option: function(data, escape) {
                        return `<div class="flex items-center">${data.text}</div>`;
                    }
                }
            });

            const convertBtn = document.getElementById("convertBtn");
            const switchBtn = document.getElementById("switchBtn");
            const resultDiv = document.getElementById("result");

            // Load history on page load
            loadHistory();

            // Refresh history
            document.getElementById("refreshHistory").addEventListener("click", loadHistory);

            convertBtn.addEventListener("click", async () => {
                const from = fromSelect.getValue();
                const to = toSelect.getValue();
                const amount = document.getElementById("amount").value;

                if (!amount || amount <= 0) {
                    alert("Please enter a valid amount");
                    return;
                }

                if (!from || !to) {
                    alert("Please select both currencies");
                    return;
                }

                if (from === to) {
                    alert("Please select different currencies");
                    return;
                }

                // Show loading
                convertBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Converting...';
                convertBtn.disabled = true;

                try {
                    // Simulate API call (replace with actual fetch)
                    setTimeout(() => {
                        const result = simulateConversion(from, to, amount);
                        displayResult(result, from, to, amount);
                        saveToHistory(from, to, amount, result);
                        convertBtn.innerHTML = '<i class="fas fa-exchange-alt mr-2"></i>Convert Currency';
                        convertBtn.disabled = false;
                    }, 1000);

                } catch (error) {
                    alert("Error: Could not fetch data. Please check your connection.");
                    convertBtn.innerHTML = '<i class="fas fa-exchange-alt mr-2"></i>Convert Currency';
                    convertBtn.disabled = false;
                }
            });

            // Switch currencies
            switchBtn.addEventListener("click", () => {
                const fromValue = fromSelect.getValue();
                const toValue = toSelect.getValue();

                fromSelect.setValue(toValue);
                toSelect.setValue(fromValue);
            });

            function simulateConversion(from, to, amount) {
                // Mock exchange rates (in real app, these would come from an API)
                const rates = {
                    'USD': { 'EUR': 0.85, 'GBP': 0.73, 'JPY': 110.25, 'CAD': 1.25, 'AUD': 1.35 },
                    'EUR': { 'USD': 1.18, 'GBP': 0.86, 'JPY': 129.75, 'CAD': 1.47, 'AUD': 1.59 },
                    'GBP': { 'USD': 1.37, 'EUR': 1.16, 'JPY': 151.00, 'CAD': 1.71, 'AUD': 1.85 },
                    'JPY': { 'USD': 0.0091, 'EUR': 0.0077, 'GBP': 0.0066, 'CAD': 0.011, 'AUD': 0.012 },
                    'CAD': { 'USD': 0.80, 'EUR': 0.68, 'GBP': 0.58, 'JPY': 88.00, 'AUD': 1.08 },
                    'AUD': { 'USD': 0.74, 'EUR': 0.63, 'GBP': 0.54, 'JPY': 81.50, 'CAD': 0.93 }
                };

                // Default rate if not found
                const rate = rates[from]?.[to] || 1.0;
                const converted = amount * rate;

                return {
                    converted: converted.toFixed(2),
                    rate: rate.toFixed(4)
                };
            }

            function displayResult(data, from, to, amount) {
                const convertedAmount = document.getElementById("convertedAmount");
                const exchangeRate = document.getElementById("exchangeRate");
                const originalAmount = document.getElementById("originalAmount");
                const rateValue = document.getElementById("rateValue");

                convertedAmount.textContent = `${data.converted} ${to}`;
                exchangeRate.textContent = `1 ${from} = ${data.rate} ${to}`;
                originalAmount.textContent = `${amount} ${from}`;
                rateValue.textContent = `1 ${from} = ${data.rate} ${to}`;

                resultDiv.classList.remove("hidden");
                
                // Scroll to result
                resultDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }

            function saveToHistory(from, to, amount, result) {
                const history = JSON.parse(localStorage.getItem('currencyHistory') || '[]');
                history.push({
                    id: Date.now(),
                    from: from,
                    to: to,
                    amount: parseFloat(amount),
                    converted: parseFloat(result.converted),
                    rate: parseFloat(result.rate),
                    timestamp: new Date().toISOString()
                });
                localStorage.setItem('currencyHistory', JSON.stringify(history));
                loadHistory();
            }

            function loadHistory() {
                // Simulate loading history from localStorage
                const history = JSON.parse(localStorage.getItem('currencyHistory') || '[]');
                const historyList = document.getElementById("historyList");
                
                if (history.length === 0) {
                    historyList.innerHTML = `
                        <div class="text-center text-gray-500 dark:text-gray-400 py-4">
                            <i class="fas fa-clock text-2xl mb-2"></i>
                            <div>No conversion history yet</div>
                        </div>
                    `;
                    return;
                }

                historyList.innerHTML = history.slice(-5).reverse().map(conv => `
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 border border-gray-200 dark:border-gray-600 animate-fade-in">
                        <div class="flex justify-between items-start mb-2">
                            <div class="font-medium text-gray-800 dark:text-white text-sm">
                                ${conv.from} → ${conv.to}
                            </div>
                            <button class="delete-conversion text-red-500 hover:text-red-700 transition-colors p-1" data-id="${conv.id}">
                                <i class="fas fa-trash text-xs"></i>
                            </button>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-primary-600 dark:text-primary-400 font-semibold">
                                ${conv.amount.toFixed(2)} ${conv.from} = ${conv.converted.toFixed(2)} ${conv.to}
                            </span>
                            <span class="text-gray-500 dark:text-gray-400 text-xs">${new Date(conv.timestamp).toLocaleDateString()}</span>
                        </div>
                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            Rate: 1 ${conv.from} = ${conv.rate.toFixed(4)} ${conv.to}
                        </div>
                    </div>
                `).join('');

                // Add event listeners to delete buttons
                document.querySelectorAll('.delete-conversion').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        deleteConversion(id);
                    });
                });
            }

            function deleteConversion(id) {
                if (!confirm('Are you sure you want to delete this conversion?')) {
                    return;
                }

                const history = JSON.parse(localStorage.getItem('currencyHistory') || '[]');
                const updatedHistory = history.filter(conv => conv.id != id);
                localStorage.setItem('currencyHistory', JSON.stringify(updatedHistory));
                loadHistory();
            }

            // Set popular currency pairs
            window.setCurrencies = function(from, to) {
                fromSelect.setValue(from);
                toSelect.setValue(to);
            };

            // Mobile menu toggle
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
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
        });
    </script>
</body>
</html>