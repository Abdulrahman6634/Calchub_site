<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='%2322c55e'><path fill-rule='evenodd' d='M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V4a2 2 0 00-2-2H6zm1 2a1 1 0 000 2h6a1 1 0 100-2H7zm6 7a1 1 0 00-1 1v1H7v-1a1 1 0 00-2 0v1a2 2 0 002 2h6a2 2 0 002-2v-1a1 1 0 00-1-1z' clip-rule='evenodd'/></svg>">
    <title>Loan Calculator - CalcHub</title>
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

        .payment-breakdown {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
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
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Loan Calculator</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Page Header -->
        <div class="mb-8 animate-fade-in">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 dark:text-white mb-2">Loan Calculator 💰</h1>
                    <p class="text-gray-600 dark:text-gray-400">Calculate loan payments, interest, and amortization schedule.</p>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="px-3 py-1 bg-primary-100 dark:bg-primary-900 text-primary-800 dark:text-primary-200 text-sm font-medium rounded-full">
                        Finance
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
                               placeholder="e.g., Mortgage, Car Loan, Personal Loan, etc.">
                    </div>

                    <!-- Loan Amount -->
                    <div class="mb-6">
                        <label for="loanAmount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                            <i class="fas fa-money-bill-wave text-primary-500 mr-2"></i>
                            Loan Amount
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500">$</span>
                            </div>
                            <input type="number" id="loanAmount" min="1" max="10000000" step="1000"
                                   class="w-full pl-8 p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors" 
                                   placeholder="Enter loan amount" value="250000">
                        </div>
                    </div>

                    <!-- Interest Rate -->
                    <div class="mb-6">
                        <label for="interestRate" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                            <i class="fas fa-percentage text-primary-500 mr-2"></i>
                            Annual Interest Rate
                        </label>
                        <div class="relative">
                            <input type="number" id="interestRate" min="0.01" max="100" step="0.01"
                                   class="w-full p-3 pr-8 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors" 
                                   placeholder="Enter interest rate" value="4.5">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500">%</span>
                            </div>
                        </div>
                    </div>

                    <!-- Loan Term -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label for="loanTerm" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                <i class="fas fa-calendar-alt text-primary-500 mr-2"></i>
                                Loan Term
                            </label>
                            <input type="number" id="loanTerm" min="1" max="600" step="1"
                                   class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors" 
                                   placeholder="Enter loan term" value="30">
                        </div>
                        <div>
                            <label for="termType" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Term Type
                            </label>
                            <select id="termType" class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors">
                                <option value="years">Years</option>
                                <option value="months">Months</option>
                            </select>
                        </div>
                    </div>

                    <!-- Payment Frequency -->
                    <div class="mb-6">
                        <label for="paymentFrequency" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                            <i class="fas fa-calendar-check text-primary-500 mr-2"></i>
                            Payment Frequency
                        </label>
                        <select id="paymentFrequency" class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors">
                            <option value="monthly">Monthly</option>
                            <option value="bi-weekly">Bi-Weekly</option>
                            <option value="weekly">Weekly</option>
                        </select>
                    </div>

                    <!-- Calculate Button -->
                    <button id="calculateBtn" class="w-full bg-primary-500 hover:bg-primary-600 text-white py-3 rounded-lg font-semibold transition-all duration-300 shadow-sm hover:shadow-md active:scale-95 flex items-center justify-center animate-scale-in" style="animation-delay: 0.4s">
                        <i class="fas fa-calculator mr-2"></i>
                        Calculate Loan
                    </button>

                    <!-- Result Display -->
                    <div id="result" class="mt-6 p-6 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600 hidden animate-fade-in">
                        <!-- Payment Summary -->
                        <div class="payment-breakdown text-white rounded-xl p-6 mb-6">
                            <div class="text-center mb-4">
                                <div class="text-2xl font-bold mb-2">Monthly Payment</div>
                                <div class="text-4xl font-bold" id="monthlyPayment"></div>
                            </div>
                            <div class="grid grid-cols-3 gap-4 text-center">
                                <div>
                                    <div class="text-sm opacity-90">Total Loan</div>
                                    <div class="text-lg font-semibold" id="totalLoan"></div>
                                </div>
                                <div>
                                    <div class="text-sm opacity-90">Total Interest</div>
                                    <div class="text-lg font-semibold" id="totalInterest"></div>
                                </div>
                                <div>
                                    <div class="text-sm opacity-90">Total Payment</div>
                                    <div class="text-lg font-semibold" id="totalPayment"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Breakdown Chart -->
                        <div class="mb-6">
                            <h4 class="font-semibold text-gray-800 dark:text-white mb-4 flex items-center">
                                <i class="fas fa-chart-pie text-primary-500 mr-2"></i>
                                Payment Breakdown
                            </h4>
                            <div class="h-48">
                                <canvas id="paymentChart"></canvas>
                            </div>
                        </div>

                        <!-- Amortization Schedule -->
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="font-semibold text-gray-800 dark:text-white flex items-center">
                                    <i class="fas fa-table text-primary-500 mr-2"></i>
                                    Amortization Schedule
                                </h4>
                                <button id="toggleSchedule" class="text-primary-500 hover:text-primary-600 text-sm font-medium">
                                    Show Full Schedule
                                </button>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm">
                                    <thead class="bg-gray-100 dark:bg-gray-600">
                                        <tr>
                                            <th class="py-2 px-3 text-left">Month</th>
                                            <th class="py-2 px-3 text-right">Payment</th>
                                            <th class="py-2 px-3 text-right">Principal</th>
                                            <th class="py-2 px-3 text-right">Interest</th>
                                            <th class="py-2 px-3 text-right">Balance</th>
                                        </tr>
                                    </thead>
                                    <tbody id="scheduleBody" class="divide-y divide-gray-200 dark:divide-gray-600">
                                        <!-- Schedule will be populated here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Extra Payment Calculator -->
                        <div class="mt-6 p-4 bg-white dark:bg-gray-600 rounded-lg border border-gray-200 dark:border-gray-500">
                            <h4 class="font-semibold text-gray-800 dark:text-white mb-3 flex items-center">
                                <i class="fas fa-rocket text-primary-500 mr-2"></i>
                                Extra Payment Calculator
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="extraPayment" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Extra Monthly Payment
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500">$</span>
                                        </div>
                                        <input type="number" id="extraPayment" min="0" step="10"
                                               class="w-full pl-8 p-2 border border-gray-300 dark:border-gray-600 rounded focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors" 
                                               placeholder="Extra payment amount">
                                    </div>
                                </div>
                                <div class="flex items-end">
                                    <button id="calculateExtra" class="w-full bg-primary-500 hover:bg-primary-600 text-white py-2 px-4 rounded font-medium transition-colors">
                                        Calculate Impact
                                    </button>
                                </div>
                            </div>
                            <div id="extraPaymentResult" class="hidden">
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div class="text-center p-3 bg-green-50 dark:bg-green-900/20 rounded">
                                        <div class="text-green-600 dark:text-green-400 font-semibold" id="monthsSaved"></div>
                                        <div class="text-gray-600 dark:text-gray-400">Months Saved</div>
                                    </div>
                                    <div class="text-center p-3 bg-blue-50 dark:bg-blue-900/20 rounded">
                                        <div class="text-blue-600 dark:text-blue-400 font-semibold" id="interestSaved"></div>
                                        <div class="text-gray-600 dark:text-gray-400">Interest Saved</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Quick Tips -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 animate-scale-in" style="animation-delay: 0.2s">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 flex items-center">
                        <i class="fas fa-lightbulb text-primary-500 mr-2"></i>
                        Loan Tips
                    </h3>
                    <ul class="space-y-3 text-sm text-gray-600 dark:text-gray-400">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-primary-500 mt-1 mr-3 flex-shrink-0"></i>
                            <span>Even small extra payments can significantly reduce total interest</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-primary-500 mt-1 mr-3 flex-shrink-0"></i>
                            <span>Shorter loan terms usually have lower interest rates</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-primary-500 mt-1 mr-3 flex-shrink-0"></i>
                            <span>Consider bi-weekly payments to make one extra payment per year</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-primary-500 mt-1 mr-3 flex-shrink-0"></i>
                            <span>Your credit score significantly impacts your interest rate</span>
                        </li>
                    </ul>
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

                <!-- Common Loan Types -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 animate-scale-in" style="animation-delay: 0.6s">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 flex items-center">
                        <i class="fas fa-home text-primary-500 mr-2"></i>
                        Common Loan Types
                    </h3>
                    <div class="space-y-3 text-sm">
                        <div class="p-3 bg-blue-50 dark:bg-blue-900/20 rounded border border-blue-200 dark:border-blue-800">
                            <div class="font-semibold text-blue-800 dark:text-blue-300">Mortgage</div>
                            <div class="text-blue-600 dark:text-blue-400">15-30 years, 3-6% interest</div>
                        </div>
                        <div class="p-3 bg-green-50 dark:bg-green-900/20 rounded border border-green-200 dark:border-green-800">
                            <div class="font-semibold text-green-800 dark:text-green-300">Auto Loan</div>
                            <div class="text-green-600 dark:text-green-400">3-7 years, 4-8% interest</div>
                        </div>
                        <div class="p-3 bg-purple-50 dark:bg-purple-900/20 rounded border border-purple-200 dark:border-purple-800">
                            <div class="font-semibold text-purple-800 dark:text-purple-300">Personal Loan</div>
                            <div class="text-purple-600 dark:text-purple-400">1-5 years, 6-36% interest</div>
                        </div>
                        <div class="p-3 bg-orange-50 dark:bg-orange-900/20 rounded border border-orange-200 dark:border-orange-800">
                            <div class="font-semibold text-orange-800 dark:text-orange-300">Student Loan</div>
                            <div class="text-orange-600 dark:text-orange-400">10-25 years, 3-7% interest</div>
                        </div>
                    </div>
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
            let paymentChart = null;
            let fullSchedule = [];
            let showingFullSchedule = false;

            // Load history
            loadHistory();

            // Refresh history
            document.getElementById('refreshHistory').addEventListener('click', loadHistory);

            // Calculate button
            document.getElementById('calculateBtn').addEventListener('click', calculateLoan);

            // Extra payment calculation
            document.getElementById('calculateExtra').addEventListener('click', calculateExtraPayment);

            // Toggle schedule view
            document.getElementById('toggleSchedule').addEventListener('click', toggleSchedule);

            function calculateLoan() {
                const loanAmount = parseFloat(document.getElementById('loanAmount').value);
                const interestRate = parseFloat(document.getElementById('interestRate').value);
                const loanTerm = parseInt(document.getElementById('loanTerm').value);
                const termType = document.getElementById('termType').value;
                const paymentFrequency = document.getElementById('paymentFrequency').value;
                const calculationName = document.getElementById('calculationName').value;

                // Validation
                if (!loanAmount || loanAmount <= 0) {
                    alert('Please enter a valid loan amount.');
                    return;
                }
                if (!interestRate || interestRate <= 0) {
                    alert('Please enter a valid interest rate.');
                    return;
                }
                if (!loanTerm || loanTerm <= 0) {
                    alert('Please enter a valid loan term.');
                    return;
                }

                // Show loading
                const calculateBtn = document.getElementById('calculateBtn');
                calculateBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Calculating...';
                calculateBtn.disabled = true;

                // Send calculation request
                fetch('{{ route("loan.calculate") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        loan_amount: loanAmount,
                        interest_rate: interestRate,
                        loan_term: loanTerm,
                        term_type: termType,
                        payment_frequency: paymentFrequency,
                        calculation_name: calculationName
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displayResult(data);
                        loadHistory();
                    } else {
                        alert(data.error || 'Calculation failed. Please try again.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                })
                .finally(() => {
                    calculateBtn.innerHTML = '<i class="fas fa-calculator mr-2"></i>Calculate Loan';
                    calculateBtn.disabled = false;
                });
            }

            function displayResult(data) {
                const resultDiv = document.getElementById('result');
                const monthlyPayment = document.getElementById('monthlyPayment');
                const totalLoan = document.getElementById('totalLoan');
                const totalInterest = document.getElementById('totalInterest');
                const totalPayment = document.getElementById('totalPayment');

                monthlyPayment.textContent = '$' + data.monthly_payment.toLocaleString();
                totalLoan.textContent = '$' + data.calculation_details.principal.toLocaleString();
                totalInterest.textContent = '$' + data.total_interest.toLocaleString();
                totalPayment.textContent = '$' + data.total_payment.toLocaleString();

                // Store full schedule
                fullSchedule = data.amortization_schedule;
                showingFullSchedule = false;

                // Display first 12 months of schedule
                displaySchedule(fullSchedule.slice(0, 12));

                // Create payment breakdown chart
                createPaymentChart(data.calculation_details.principal, data.total_interest);

                resultDiv.classList.remove('hidden');
                resultDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }

            function displaySchedule(schedule) {
                const scheduleBody = document.getElementById('scheduleBody');
                scheduleBody.innerHTML = '';

                schedule.forEach(payment => {
                    const row = document.createElement('tr');
                    row.className = 'hover:bg-gray-50 dark:hover:bg-gray-600';
                    row.innerHTML = `
                        <td class="py-2 px-3">${payment.month}</td>
                        <td class="py-2 px-3 text-right">$${payment.payment.toLocaleString()}</td>
                        <td class="py-2 px-3 text-right">$${payment.principal.toLocaleString()}</td>
                        <td class="py-2 px-3 text-right">$${payment.interest.toLocaleString()}</td>
                        <td class="py-2 px-3 text-right">$${payment.balance.toLocaleString()}</td>
                    `;
                    scheduleBody.appendChild(row);
                });
            }

            function toggleSchedule() {
                const toggleBtn = document.getElementById('toggleSchedule');
                
                if (showingFullSchedule) {
                    displaySchedule(fullSchedule.slice(0, 12));
                    toggleBtn.textContent = 'Show Full Schedule';
                    showingFullSchedule = false;
                } else {
                    displaySchedule(fullSchedule);
                    toggleBtn.textContent = 'Show First 12 Months';
                    showingFullSchedule = true;
                }
            }

            function createPaymentChart(principal, interest) {
                const ctx = document.getElementById('paymentChart').getContext('2d');
                
                if (paymentChart) {
                    paymentChart.destroy();
                }

                paymentChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Principal', 'Interest'],
                        datasets: [{
                            data: [principal, interest],
                            backgroundColor: ['#22c55e', '#ef4444'],
                            borderWidth: 2,
                            borderColor: '#fff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    color: '#6b7280',
                                    font: {
                                        size: 12
                                    }
                                }
                            }
                        }
                    }
                });
            }

            function calculateExtraPayment() {
                const extraPayment = parseFloat(document.getElementById('extraPayment').value);
                
                if (!extraPayment || extraPayment <= 0) {
                    alert('Please enter a valid extra payment amount.');
                    return;
                }

                const loanAmount = parseFloat(document.getElementById('loanAmount').value);
                const interestRate = parseFloat(document.getElementById('interestRate').value);
                const loanTerm = parseInt(document.getElementById('loanTerm').value);
                const termType = document.getElementById('termType').value;
                const paymentFrequency = document.getElementById('paymentFrequency').value;

                fetch('{{ route("loan.calculate.extra") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        loan_amount: loanAmount,
                        interest_rate: interestRate,
                        loan_term: loanTerm,
                        term_type: termType,
                        payment_frequency: paymentFrequency,
                        extra_payment: extraPayment
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displayExtraPaymentResult(data);
                    } else {
                        alert(data.error || 'Calculation failed. Please try again.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                });
            }

            function displayExtraPaymentResult(data) {
                const resultDiv = document.getElementById('extraPaymentResult');
                const monthsSaved = document.getElementById('monthsSaved');
                const interestSaved = document.getElementById('interestSaved');

                monthsSaved.textContent = data.months_saved + ' months';
                interestSaved.textContent = '$' + data.interest_saved.toLocaleString();

                resultDiv.classList.remove('hidden');
            }

            function loadHistory() {
                fetch('{{ route("loan.history") }}')
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
                                    <span class="text-primary-600 dark:text-primary-400 font-semibold">$${calc.monthly_payment}/mo</span>
                                    <span class="text-gray-500 dark:text-gray-400 text-xs">${calc.date}</span>
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    $${calc.loan_amount} • ${calc.interest_rate}% • ${calc.loan_term}
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

            function deleteCalculation(id) {
                if (!confirm('Are you sure you want to delete this calculation?')) {
                    return;
                }

                fetch(`/loan-calculator/history/${id}`, {
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