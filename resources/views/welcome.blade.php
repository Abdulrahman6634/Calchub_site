<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='%2322c55e'><path fill-rule='evenodd' d='M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V4a2 2 0 00-2-2H6zm1 2a1 1 0 000 2h6a1 1 0 100-2H7zm6 7a1 1 0 00-1 1v1H7v-1a1 1 0 00-2 0v1a2 2 0 002 2h6a2 2 0 002-2v-1a1 1 0 00-1-1z' clip-rule='evenodd'/></svg>">
    <title>CalcHub - All-in-One Calculator Platform</title>
    <script>
        // Theme detection - optimized for immediate execution
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
                        'fade-in': 'fadeIn 0.6s ease-out',
                        'slide-up': 'slideUp 0.8s ease-out',
                        'scale-in': 'scaleIn 0.5s ease-out',
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
                transform: translateY(30px);
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
        
        /* Performance optimizations */
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
<body class="bg-white dark:bg-gray-800 transition-colors duration-300 scroll-optimized">
    <!-- Header/Navigation -->
    <header class="sticky top-0 z-50 bg-white/80 dark:bg-gray-800/80 backdrop-blur-md border-b border-gray-200 dark:border-gray-700 scroll-optimized">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <div class="w-8 h-8 bg-primary-500 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V4a2 2 0 00-2-2H6zm1 2a1 1 0 000 2h6a1 1 0 100-2H7zm6 7a1 1 0 00-1 1v1H7v-1a1 1 0 00-2 0v1a2 2 0 002 2h6a2 2 0 002-2v-1a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <span class="text-xl font-bold text-gray-800 dark:text-white">CalcHub</span>
            </div>
            
            <nav class="hidden md:flex space-x-8">
                <a href="#" class="text-gray-600 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition-smooth">Home</a>
                <a href="#calculators" class="text-gray-600 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition-smooth">Calculators</a>
                <a href="#features" class="text-gray-600 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition-smooth">Features</a>
                <a href="#" class="text-gray-600 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition-smooth">About</a>
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
                
                <!-- Conditional Auth Buttons -->
                <?php if(auth()->check()): ?>
                    <!-- Show Dashboard button when logged in -->
                    <a href="/dashboard" class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-lg transition-smooth font-medium">
                        Dashboard
                    </a>
                    <!-- Optional: User dropdown menu -->
                    <div class="relative group">
                        <button class="flex items-center space-x-2 bg-gray-100 dark:bg-gray-700 rounded-lg px-3 py-2 transition-smooth">
                            <div class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-white font-medium">
                                <?php echo strtoupper(substr(auth()->user()->name, 0, 1)); ?>
                            </div>
                        </button>
                    </div>
                <?php else: ?>
                    <!-- Show Sign In/Sign Up when logged out -->
                    <a href="/signin" class="text-gray-600 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition-smooth font-medium">Sign In</a>
                    <a href="/signup" class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-lg transition-smooth font-medium">Sign Up</a>
                <?php endif; ?>
            </div>
            
            <!-- Mobile menu button -->
            <button id="mobile-menu-button" class="md:hidden p-2 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 transition-smooth">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="md:hidden hidden bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 px-4 py-2 transition-all duration-300">
            <nav class="flex flex-col space-y-3">
                <a href="#" class="py-2 text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition-smooth">Home</a>
                <a href="#calculators" class="py-2 text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition-smooth">Calculators</a>
                <a href="#features" class="py-2 text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition-smooth">Features</a>
                <a href="#" class="py-2 text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition-smooth">About</a>
                <div class="border-t border-gray-200 dark:border-gray-700 pt-3">
                    <?php if(auth()->check()): ?>
                        <a href="/dashboard" class="block py-2 text-primary-600 dark:text-primary-400 font-medium">Dashboard</a>
                    <?php else: ?>
                        <a href="/signin" class="block py-2 text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition-smooth">Sign In</a>
                        <a href="/signup" class="block py-2 text-primary-600 dark:text-primary-400 font-medium">Sign Up</a>
                    <?php endif; ?>
                </div>
            </nav>
        </div>
    </header>

    <!-- Hero Section with Background Image -->
    <section class="relative bg-gradient-to-r from-primary-700 to-primary-800 text-white py-20 md:py-28 animate-fade-in">
        <div class="absolute inset-0 bg-black/30"></div>
        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-2xl mx-auto text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-6 animate-slide-up">All Calculators You Need in One Place</h1>
                <p class="text-xl mb-8 text-primary-100 animate-slide-up" style="animation-delay: 0.2s">CGPA, currency conversion, percentage, profit & expense, calorie tracking, and much more. All completely free!</p>
                <div class="flex flex-col sm:flex-row justify-center gap-4 animate-slide-up" style="animation-delay: 0.4s">
                    <?php if(auth()->check()): ?>
                        <!-- Show Dashboard button when logged in -->
                        <a href="/dashboard" class="bg-white text-primary-700 hover:bg-gray-100 font-semibold py-3 px-8 rounded-lg transition-smooth text-center">
                            Go to Dashboard
                        </a>
                        <a href="/tools" class="bg-transparent border-2 border-white hover:bg-white/10 font-semibold py-3 px-8 rounded-lg transition-smooth text-center">
                            Explore Calculators
                        </a>
                    <?php else: ?>
                        <!-- Show Get Started button when logged out -->
                        <a href="/signup" class="bg-white text-primary-700 hover:bg-gray-100 font-semibold py-3 px-8 rounded-lg transition-smooth text-center">
                            Get Started
                        </a>
                        <a href="#calculators" class="bg-transparent border-2 border-white hover:bg-white/10 font-semibold py-3 px-8 rounded-lg transition-smooth text-center">
                            Explore Calculators
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="calculators" class="py-16 bg-gray-50 dark:bg-gray-900">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-gray-800 dark:text-white mb-12 animate-fade-in">Our Featured Calculators</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php
                $calculators = [
                    [
                        'title' => 'CGPA Calculator',
                        'description' => 'Calculate your GPA and CGPA with ease. Perfect for students.',
                        'route' => 'cgpa.calculator',
                        'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'
                    ],
                    [
                        'title' => 'Currency Converter',
                        'description' => 'Convert between 150+ currencies with real-time exchange rates.',
                        'route' => 'currency.converter',
                        'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1'
                    ],
                    [
                        'title' => 'Percentage Calculator',
                        'description' => 'Calculate percentages, increases, decreases, and more.',
                        'route' => 'percentage.calculator',
                        'icon' => 'M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z'
                    ],
                    [
                        'title' => 'Profit & Expense',
                        'description' => 'Track your finances with our profit and expense calculator.',
                        'route' => 'profit-loss.calculator',
                        'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
                    ],
                    [
                        'title' => 'Calorie Calculator',
                        'description' => 'Track your daily calorie intake and manage your diet effectively.',
                        'route' => 'calorie.calculator',
                        'icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z'
                    ],
                    [
                        'title' => 'Date & Time Calculator',
                        'description' => 'Calculate date differences, add/subtract time, and more.',
                        'route' => 'date-time.calculator',
                        'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'
                    ]
                ];
                ?>

                <?php foreach($calculators as $index => $calculator): ?>
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden transition-transform hover:scale-105 animate-scale-in" style="animation-delay: <?php echo $index * 0.1; ?>s">
                    <div class="p-6 h-full flex flex-col">
                        <div class="w-12 h-12 bg-primary-100 dark:bg-primary-900 rounded-lg flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-600 dark:text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo $calculator['icon']; ?>" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2"><?php echo $calculator['title']; ?></h3>
                        <p class="text-gray-600 dark:text-gray-300 mb-4 flex-grow"><?php echo $calculator['description']; ?></p>
                        <?php if(auth()->check()): ?>
                            <a href="<?php echo route($calculator['route']); ?>" class="text-primary-600 dark:text-primary-400 font-medium hover:underline inline-flex items-center">
                                Try it now
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        <?php else: ?>
                            <a href="/signin" class="text-primary-600 dark:text-primary-400 font-medium hover:underline inline-flex items-center">
                                Sign in to use
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section id="features" class="py-16 bg-primary-50 dark:bg-gray-800">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center animate-fade-in">
                <h2 class="text-3xl font-bold text-gray-800 dark:text-white mb-6">Ready to Simplify Your Calculations?</h2>
                <p class="text-xl text-gray-600 dark:text-gray-300 mb-8">Join thousands of users who trust CalcHub for all their calculation needs. It's completely free!</p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <?php if(auth()->check()): ?>
                        <a href="/dashboard" class="bg-primary-500 hover:bg-primary-600 text-white font-semibold py-3 px-8 rounded-lg transition-smooth text-center">
                            Go to Dashboard
                        </a>
                        <a href="/tools" class="bg-white dark:bg-gray-700 text-primary-600 dark:text-primary-400 border border-primary-500 dark:border-primary-400 hover:bg-gray-50 dark:hover:bg-gray-600 font-semibold py-3 px-8 rounded-lg transition-smooth text-center">
                            Explore All Tools
                        </a>
                    <?php else: ?>
                        <a href="/signup" class="bg-primary-500 hover:bg-primary-600 text-white font-semibold py-3 px-8 rounded-lg transition-smooth text-center">
                            Create Account
                        </a>
                        <a href="/signin" class="bg-white dark:bg-gray-700 text-primary-600 dark:text-primary-400 border border-primary-500 dark:border-primary-400 hover:bg-gray-50 dark:hover:bg-gray-600 font-semibold py-3 px-8 rounded-lg transition-smooth text-center">
                            Sign In
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 dark:bg-gray-900 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="md:col-span-2">
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-8 h-8 bg-primary-500 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V4a2 2 0 00-2-2H6zm1 2a1 1 0 000 2h6a1 1 0 100-2H7zm6 7a1 1 0 00-1 1v1H7v-1a1 1 0 00-2 0v1a2 2 0 002 2h6a2 2 0 002-2v-1a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <span class="text-xl font-bold">CalcHub</span>
                    </div>
                    <p class="text-gray-400 mb-4 max-w-md">Your all-in-one calculator platform for CGPA, currency conversion, percentage calculations, and much more. All completely free to use.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition-smooth">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-smooth">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-smooth">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Calculators</h3>
                    <ul class="space-y-2">
                        <li><a href="<?php echo auth()->check() ? route('cgpa.calculator') : '/signin'; ?>" class="text-gray-400 hover:text-white transition-smooth">CGPA Calculator</a></li>
                        <li><a href="<?php echo auth()->check() ? route('currency.converter') : '/signin'; ?>" class="text-gray-400 hover:text-white transition-smooth">Currency Converter</a></li>
                        <li><a href="<?php echo auth()->check() ? route('percentage.calculator') : '/signin'; ?>" class="text-gray-400 hover:text-white transition-smooth">Percentage Calculator</a></li>
                        <li><a href="<?php echo auth()->check() ? route('profit-loss.calculator') : '/signin'; ?>" class="text-gray-400 hover:text-white transition-smooth">Profit & Expense</a></li>
                        <li><a href="<?php echo auth()->check() ? route('calorie.calculator') : '/signin'; ?>" class="text-gray-400 hover:text-white transition-smooth">Calorie Calculator</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Company</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-smooth">About Us</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-smooth">Privacy Policy</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-smooth">Terms of Service</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-smooth">Contact</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-smooth">FAQ</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2023 CalcHub. All rights reserved.</p>
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

            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>