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
        
        /* Custom scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }
        .dark .custom-scrollbar::-webkit-scrollbar-track {
            background: #374151;
        }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #6b7280;
        }
    </style>
</head>
<body class="bg-white dark:bg-gray-800 transition-colors duration-300 scroll-optimized">
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
            

            
            <div class="flex items-center space-x-3">

                <!-- Optimized Navigation -->
                <nav class="hidden md:flex items-center space-x-1">
                    <a href="#" class="nav-link px-4 py-2 rounded-lg transition-smooth">Home</a>
                    <a href="#calculators" class="nav-link px-4 py-2 rounded-lg transition-smooth">Calculators</a>
                    <a href="#other-tools" class="nav-link px-4 py-2 rounded-lg transition-smooth">Other Tools</a>
                    <a href="#features" class="nav-link px-4 py-2 rounded-lg transition-smooth">Features</a>
                    <a href="#about" class="nav-link px-4 py-2 rounded-lg transition-smooth">About</a>
                </nav>

                <!-- Mobile menu button -->
                <button id="mobile-menu-button" class="md:hidden p-2 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 transition-smooth">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                    </svg>
                </button>

                <!-- Dark mode toggle -->
                <button id="theme-toggle" class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 transition-smooth hover:bg-gray-200 dark:hover:bg-gray-600">
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
                    <a href="{{ route('dashboard') }}" class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-lg transition-smooth font-medium text-sm">Dashboard</a>
                    <!-- User avatar with dropdown -->
                    <div class="relative group">
                        <a href="{{ route('profile') }}" class="flex items-center space-x-2 bg-gray-100 dark:bg-gray-700 rounded-lg px-3 py-2 transition-smooth hover:bg-gray-200 dark:hover:bg-gray-600">
                            <div class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-white font-medium text-sm">
                                <?php echo strtoupper(substr(auth()->user()->name, 0, 1)); ?>
                            </div>
                        </a>
                    </div>
                <?php else: ?>
                    <!-- Show Sign In/Sign Up when logged out -->
                    <a href="{{ route('signin.form') }}" class="text-gray-600 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Sign In</a>
                    <a href="{{ route('signup.form') }}" class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-lg transition-colors">Sign Up</a>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="md:hidden hidden bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 px-4 py-3 transition-all duration-300">
            <nav class="flex flex-col space-y-2">
                <a href="#" class="nav-link-mobile py-3 px-4 rounded-lg transition-smooth">Home</a>
                <a href="#calculators" class="nav-link-mobile py-3 px-4 rounded-lg transition-smooth">Calculators</a>
                <a href="#other-tools" class="nav-link-mobile py-3 px-4 rounded-lg transition-smooth">Other Tools</a>
                <a href="#features" class="nav-link-mobile py-3 px-4 rounded-lg transition-smooth">Features</a>
                <a href="#about" class="nav-link-mobile py-3 px-4 rounded-lg transition-smooth">About</a>
                <div class="border-t border-gray-200 dark:border-gray-700 pt-3 mt-2">
                    <?php if(auth()->check()): ?>
                        <a href="/dashboard" class="block py-3 px-4 bg-primary-500 text-white rounded-lg font-medium text-center">
                            <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                        </a>
                    <?php else: ?>
                        <a href="{{ route('signin.form') }}" class="block py-3 px-4 text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition-smooth text-center">Sign In</a>
                        <a href="{{ route('signup.form') }}" class="block py-3 px-4 bg-primary-500 text-white rounded-lg font-medium text-center mt-2">Sign Up Free</a>
                    <?php endif; ?>
                </div>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-r from-primary-700 to-primary-800 text-white py-20 md:py-28 animate-fade-in">
        <div class="absolute inset-0 bg-black/30"></div>
        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-2xl mx-auto text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-6 animate-slide-up">All Calculators & Tools You Need in One Place</h1>
                <p class="text-xl mb-8 text-primary-100 animate-slide-up" style="animation-delay: 0.2s">CGPA, currency conversion, percentage, profit & expense, calorie tracking, YouTube tools, and much more. All completely free!</p>
                <div class="flex flex-col sm:flex-row justify-center gap-4 animate-slide-up" style="animation-delay: 0.4s">
                    <?php if(auth()->check()): ?>
                        <a href="/dashboard" class="bg-white text-primary-700 hover:bg-gray-100 font-semibold py-3 px-8 rounded-lg transition-smooth text-center">
                            <i class="fas fa-tachometer-alt mr-2"></i>Go to Dashboard
                        </a>
                        <a href="/tools" class="bg-transparent border-2 border-white hover:bg-white/10 font-semibold py-3 px-8 rounded-lg transition-smooth text-center">
                            <i class="fas fa-calculator mr-2"></i>Explore Tools
                        </a>
                    <?php else: ?>
                        <a href="/signup" class="bg-white text-primary-700 hover:bg-gray-100 font-semibold py-3 px-8 rounded-lg transition-smooth text-center">
                            <i class="fas fa-rocket mr-2"></i>Get Started Free
                        </a>
                        <a href="#calculators" class="bg-transparent border-2 border-white hover:bg-white/10 font-semibold py-3 px-8 rounded-lg transition-smooth text-center">
                            <i class="fas fa-eye mr-2"></i>View Tools
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-12 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                <div class="animate-scale-in" style="animation-delay: 0.1s">
                    <div class="text-3xl font-bold text-primary-600 dark:text-primary-400 mb-2">50+</div>
                    <div class="text-gray-600 dark:text-gray-400 text-sm">Calculation Tools</div>
                </div>
                <div class="animate-scale-in" style="animation-delay: 0.2s">
                    <div class="text-3xl font-bold text-primary-600 dark:text-primary-400 mb-2">10K+</div>
                    <div class="text-gray-600 dark:text-gray-400 text-sm">Active Users</div>
                </div>
                <div class="animate-scale-in" style="animation-delay: 0.3s">
                    <div class="text-3xl font-bold text-primary-600 dark:text-primary-400 mb-2">100%</div>
                    <div class="text-gray-600 dark:text-gray-400 text-sm">Free Tools</div>
                </div>
                <div class="animate-scale-in" style="animation-delay: 0.4s">
                    <div class="text-3xl font-bold text-primary-600 dark:text-primary-400 mb-2">24/7</div>
                    <div class="text-gray-600 dark:text-gray-400 text-sm">Available</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Calculators Section -->
    <section id="calculators" class="py-16 bg-gray-50 dark:bg-gray-900">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-gray-800 dark:text-white mb-4 animate-fade-in">Essential Calculators</h2>
            <p class="text-lg text-center text-gray-600 dark:text-gray-400 mb-12 max-w-2xl mx-auto animate-fade-in">
                Powerful calculation tools for students, professionals, and everyday use
            </p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php
                $calculators = [
                    [
                        'title' => 'CGPA Calculator',
                        'description' => 'Calculate your GPA and CGPA with ease. Perfect for students.',
                        'route' => 'cgpa.calculator',
                        'icon' => 'fas fa-graduation-cap',
                        'color' => 'green'
                    ],
                    [
                        'title' => 'Currency Converter',
                        'description' => 'Convert between 150+ currencies with real-time exchange rates.',
                        'route' => 'currency.converter',
                        'icon' => 'fas fa-exchange-alt',
                        'color' => 'blue'
                    ],
                    [
                        'title' => 'Percentage Calculator',
                        'description' => 'Calculate percentages, increases, decreases, and more.',
                        'route' => 'percentage.calculator',
                        'icon' => 'fas fa-percent',
                        'color' => 'purple'
                    ],
                    [
                        'title' => 'BMI Calculator',
                        'description' => 'Calculate Body Mass Index and track your health metrics.',
                        'route' => 'bmi.calculator',
                        'icon' => 'fas fa-weight',
                        'color' => 'teal'
                    ],
                ];

                $colorClasses = [
                    'green' => 'bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-400',
                    'blue' => 'bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400',
                    'purple' => 'bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-400',
                    'orange' => 'bg-orange-100 dark:bg-orange-900 text-orange-600 dark:text-orange-400',
                    'red' => 'bg-red-100 dark:bg-red-900 text-red-600 dark:text-red-400',
                    'indigo' => 'bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-400',
                    'teal' => 'bg-teal-100 dark:bg-teal-900 text-teal-600 dark:text-teal-400',
                    'amber' => 'bg-amber-100 dark:bg-amber-900 text-amber-600 dark:text-amber-400',
                    'pink' => 'bg-pink-100 dark:bg-pink-900 text-pink-600 dark:text-pink-400'
                ];
                ?>

                <?php foreach($calculators as $index => $calculator): ?>
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden transition-all hover:scale-105 hover:shadow-lg animate-scale-in" style="animation-delay: <?php echo $index * 0.1; ?>s">
                    <div class="p-6 h-full flex flex-col">
                        <div class="w-12 h-12 <?php echo $colorClasses[$calculator['color']]; ?> rounded-lg flex items-center justify-center mb-4">
                            <i class="<?php echo $calculator['icon']; ?> text-lg"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2"><?php echo $calculator['title']; ?></h3>
                        <p class="text-gray-600 dark:text-gray-300 mb-4 flex-grow"><?php echo $calculator['description']; ?></p>
                        <?php if(auth()->check()): ?>
                            <a href="<?php echo route($calculator['route']); ?>" class="text-primary-600 dark:text-primary-400 font-medium hover:underline inline-flex items-center group">
                                Try it now
                                <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        <?php else: ?>
                            <a href="{{ route('signin.form') }}" class="text-primary-600 dark:text-primary-400 font-medium hover:underline inline-flex items-center group">
                                Sign in to use
                                <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>

                <?php $delay = count($calculators) * 0.1; ?>
                <!-- Explore More Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden transition-all hover:scale-105 hover:shadow-lg flex items-center justify-center animate-scale-in" style="animation-delay: <?php echo $delay; ?>s">
                    <div class="p-6 text-center">
                        <div class="w-12 h-12 bg-primary-100 dark:bg-primary-900 rounded-lg flex items-center justify-center mb-4 mx-auto">
                            <i class="fas fa-th-large text-primary-600 dark:text-primary-400 text-lg"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">More Useful Tools</h3>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">Explore our complete collection of calculators and utilities.</p>
                        <a href="/tools" class="inline-block bg-primary-600 hover:bg-primary-700 text-white font-medium py-2 px-5 rounded-lg transition-smooth">
                            Explore More
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Other Tools Section -->
    <section id="other-tools" class="py-16 bg-white dark:bg-gray-800">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-gray-800 dark:text-white mb-4 animate-fade-in">Other Tools</h2>
            <p class="text-lg text-center text-gray-600 dark:text-gray-400 mb-12 max-w-2xl mx-auto animate-fade-in">
                Explore a range of additional resources and utilities designed to streamline your workflow and enhance your content creation experience.
            </p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php
                $otherTools = [
                    [
                        'title' => 'YouTube Tag Generator',
                        'description' => 'Generate optimized tags for your YouTube videos to improve visibility and SEO.',
                        'route' => 'youtube.tag-generator',
                        'icon' => 'fab fa-youtube',
                        'featured' => true
                    ],
                    // [
                    //     'title' => 'Title Generator',
                    //     'description' => 'Create catchy and SEO-friendly titles for your YouTube videos.',
                    //     'route' => 'youtube.title-generator',
                    //     'icon' => 'fas fa-heading',
                    //     'featured' => false
                    // ],
                    // [
                    //     'title' => 'Description Generator',
                    //     'description' => 'Generate compelling descriptions with timestamps and links for your videos.',
                    //     'route' => 'youtube.description-generator',
                    //     'icon' => 'fas fa-align-left',
                    //     'featured' => false
                    // ],
                    // [
                    //     'title' => 'Thumbnail Analyzer',
                    //     'description' => 'Analyze and optimize your YouTube thumbnails for better click-through rates.',
                    //     'route' => 'youtube.thumbnail-analyzer',
                    //     'icon' => 'fas fa-image',
                    //     'featured' => false
                    // ],
                    // [
                    //     'title' => 'SEO Optimizer',
                    //     'description' => 'Optimize your video metadata for better search rankings and discoverability.',
                    //     'route' => 'youtube.seo-optimizer',
                    //     'icon' => 'fas fa-search',
                    //     'featured' => false
                    // ],
                    // [
                    //     'title' => 'Analytics Dashboard',
                    //     'description' => 'Track your channel performance and get insights for growth.',
                    //     'route' => 'youtube.analytics',
                    //     'icon' => 'fas fa-chart-bar',
                    //     'featured' => false
                    // ]
                ];
                ?>

                <?php foreach($otherTools as $index => $tool): ?>
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden transition-all hover:scale-105 hover:shadow-lg animate-scale-in border-2 <?php echo $tool['featured'] ? 'border-red-500' : 'border-gray-200 dark:border-gray-700'; ?>" style="animation-delay: <?php echo $index * 0.1; ?>s">
                    <div class="p-6 h-full flex flex-col">
                        <div class="flex justify-between items-start mb-4">
                            <div class="w-12 h-12 bg-red-100 dark:bg-red-900 rounded-lg flex items-center justify-center">
                                <i class="<?php echo $tool['icon']; ?> text-red-600 dark:text-red-400 text-lg"></i>
                            </div>
                            <?php if($tool['featured']): ?>
                                <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full">Popular</span>
                            <?php endif; ?>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2"><?php echo $tool['title']; ?></h3>
                        <p class="text-gray-600 dark:text-gray-300 mb-4 flex-grow"><?php echo $tool['description']; ?></p>
                        <?php if(auth()->check()): ?>
                            <a href="<?php echo route($tool['route']); ?>" class="text-red-600 dark:text-red-400 font-medium hover:underline inline-flex items-center group">
                                Use Tool
                                <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        <?php else: ?>
                            <a href="{{ route('signin.form') }}" class="text-red-600 dark:text-red-400 font-medium hover:underline inline-flex items-center group">
                                Sign in to use
                                <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Additional Tools Section -->
    <section class="py-16 bg-gray-50 dark:bg-gray-900">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-gray-800 dark:text-white mb-4 animate-fade-in">More Useful Tools</h2>
            <p class="text-lg text-center text-gray-600 dark:text-gray-400 mb-12 max-w-2xl mx-auto animate-fade-in">
                Discover our collection of specialized tools for various needs
            </p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php
                $additionalTools = [
                    [
                        'title' => 'Password Generator',
                        'description' => 'Create strong, secure passwords instantly.',
                        'icon' => 'fas fa-key',
                        'category' => 'Security'
                    ],
                    [
                        'title' => 'Color Picker',
                        'description' => 'Pick and convert colors between different formats.',
                        'icon' => 'fas fa-palette',
                        'category' => 'Design'
                    ],
                    [
                        'title' => 'QR Code Generator',
                        'description' => 'Generate QR codes for URLs, text, and more.',
                        'icon' => 'fas fa-qrcode',
                        'category' => 'Utility'
                    ],
                    [
                        'title' => 'Text Counter',
                        'description' => 'Count words, characters, and sentences in your text.',
                        'icon' => 'fas fa-text-height',
                        'category' => 'Writing'
                    ],
                    // [
                    //     'title' => 'Age Calculator',
                    //     'description' => 'Calculate exact age in years, months, and days.',
                    //     'icon' => 'fas fa-birthday-cake',
                    //     'category' => 'Utility'
                    // ],
                    // [
                    //     'title' => 'Time Zone Converter',
                    //     'description' => 'Convert time between different time zones worldwide.',
                    //     'icon' => 'fas fa-globe',
                    //     'category' => 'Productivity'
                    // ],
                    // [
                    //     'title' => 'File Size Converter',
                    //     'description' => 'Convert between different file size units.',
                    //     'icon' => 'fas fa-file',
                    //     'category' => 'Utility'
                    // ],
                    // [
                    //     'title' => 'BMI Calculator',
                    //     'description' => 'Calculate your Body Mass Index and health metrics.',
                    //     'icon' => 'fas fa-weight',
                    //     'category' => 'Health'
                    // ]
                ];
                ?>

                <?php foreach($additionalTools as $index => $tool): ?>
                <div class="bg-white dark:bg-gray-800 rounded-lg p-4 transition-all hover:scale-105 hover:shadow-md animate-scale-in" style="animation-delay: <?php echo $index * 0.1; ?>s">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-primary-100 dark:bg-primary-900 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="<?php echo $tool['icon']; ?> text-primary-600 dark:text-primary-400 text-sm"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-semibold text-gray-800 dark:text-white truncate"><?php echo $tool['title']; ?></h4>
                            <p class="text-xs text-gray-600 dark:text-gray-400 truncate"><?php echo $tool['description']; ?></p>
                            <span class="inline-block mt-1 px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 text-xs rounded-full">
                                <?php echo $tool['category']; ?>
                            </span>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-16 bg-primary-50 dark:bg-gray-800">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center animate-fade-in">
                <h2 class="text-3xl font-bold text-gray-800 dark:text-white mb-6">Why Choose CalcHub?</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-12">
                    <div class="animate-scale-in" style="animation-delay: 0.1s">
                        <div class="w-16 h-16 bg-primary-500 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-bolt text-white text-xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">Lightning Fast</h3>
                        <p class="text-gray-600 dark:text-gray-300">Instant calculations with optimized performance</p>
                    </div>
                    <div class="animate-scale-in" style="animation-delay: 0.2s">
                        <div class="w-16 h-16 bg-primary-500 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-shield-alt text-white text-xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">100% Secure</h3>
                        <p class="text-gray-600 dark:text-gray-300">Your data is safe with us - no storage of personal info</p>
                    </div>
                    <div class="animate-scale-in" style="animation-delay: 0.3s">
                        <div class="w-16 h-16 bg-primary-500 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-mobile-alt text-white text-xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">Mobile Friendly</h3>
                        <p class="text-gray-600 dark:text-gray-300">Works perfectly on all devices and screen sizes</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-16 bg-white dark:bg-gray-800">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <h2 class="text-3xl font-bold text-center text-gray-800 dark:text-white mb-12 animate-fade-in">About CalcHub</h2>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div class="animate-slide-up">
                        <h3 class="text-2xl font-semibold text-gray-800 dark:text-white mb-4">Your All-in-One Calculation Platform</h3>
                        <p class="text-gray-600 dark:text-gray-300 mb-6">
                            CalcHub was created to provide a comprehensive suite of calculation tools for students, professionals, 
                            and everyday users. We believe that everyone should have access to powerful, easy-to-use calculators 
                            without any cost barriers.
                        </p>
                        <p class="text-gray-600 dark:text-gray-300 mb-6">
                            From academic calculations like CGPA to financial tools, health calculators, and specialized YouTube 
                            creator tools - we've got you covered. Our platform is constantly evolving with new tools and features.
                        </p>
                        <div class="flex flex-wrap gap-3">
                            <span class="px-3 py-1 bg-primary-100 dark:bg-primary-900 text-primary-800 dark:text-primary-200 rounded-full text-sm">Free Forever</span>
                            <span class="px-3 py-1 bg-primary-100 dark:bg-primary-900 text-primary-800 dark:text-primary-200 rounded-full text-sm">No Ads</span>
                            <span class="px-3 py-1 bg-primary-100 dark:bg-primary-900 text-primary-800 dark:text-primary-200 rounded-full text-sm">Regular Updates</span>
                        </div>
                    </div>
                    <div class="animate-slide-up" style="animation-delay: 0.2s">
                        <div class="bg-gray-100 dark:bg-gray-700 rounded-xl p-6">
                            <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">What's New?</h4>
                            <ul class="space-y-3">
                                <li class="flex items-start">
                                    <i class="fas fa-check text-primary-500 mt-1 mr-3 flex-shrink-0"></i>
                                    <span class="text-gray-600 dark:text-gray-300">YouTube Tag Generator - Generate optimized tags for your videos</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check text-primary-500 mt-1 mr-3 flex-shrink-0"></i>
                                    <span class="text-gray-600 dark:text-gray-300">Dark Mode Support - Easy on the eyes anytime</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check text-primary-500 mt-1 mr-3 flex-shrink-0"></i>
                                    <span class="text-gray-600 dark:text-gray-300">Mobile App - Coming soon for iOS and Android</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-plus text-primary-500 mt-1 mr-3 flex-shrink-0"></i>
                                    <span class="text-gray-600 dark:text-gray-300">More tools added every month</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-primary-600 dark:bg-primary-700 text-white">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center animate-fade-in">
                <h2 class="text-3xl font-bold mb-6">Ready to Simplify Your Calculations?</h2>
                <p class="text-xl text-primary-100 mb-8">Join thousands of users who trust CalcHub for all their calculation needs. It's completely free!</p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <?php if(auth()->check()): ?>
                        <a href="{{ route('dashboard') }}" class="bg-white text-primary-600 hover:bg-gray-100 font-semibold py-3 px-8 rounded-lg transition-smooth text-center">
                            <i class="fas fa-tachometer-alt mr-2"></i>Go to Dashboard
                        </a>
                        <a href="{{ route('home') }}" class="bg-transparent border-2 border-white hover:bg-white/10 font-semibold py-3 px-8 rounded-lg transition-smooth text-center">
                            <i class="fas fa-calculator mr-2"></i>Explore All Tools
                        </a>
                    <?php else: ?>
                        <a href="{{ route('signup.form') }}" class="bg-white text-primary-600 hover:bg-gray-100 font-semibold py-3 px-8 rounded-lg transition-smooth text-center">
                            <i class="fas fa-user-plus mr-2"></i>Create Free Account
                        </a>
                        <a href="{{ route('signin.form') }}" class="bg-transparent border-2 border-white hover:bg-white/10 font-semibold py-3 px-8 rounded-lg transition-smooth text-center">
                            <i class="fas fa-sign-in-alt mr-2"></i>Sign In
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
                    <p class="text-gray-400 mb-4 max-w-md">Your all-in-one calculator platform for academic, financial, health, and YouTube tools. All completely free to use.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition-smooth">
                            <i class="fab fa-twitter text-lg"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-smooth">
                            <i class="fab fa-github text-lg"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-smooth">
                            <i class="fab fa-linkedin text-lg"></i>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Tools</h3>
                    <ul class="space-y-2">
                        <li><a href="#calculators" class="text-gray-400 hover:text-white transition-smooth">Calculators</a></li>
                        <li><a href="#other-tools" class="text-gray-400 hover:text-white transition-smooth">Other Tools</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-smooth">All Tools</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-smooth">New Tools</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Support</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-smooth">Help Center</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-smooth">Contact Us</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-smooth">Privacy Policy</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-smooth">Terms of Service</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2023 CalcHub. All rights reserved. Made with <i class="fas fa-heart text-red-500 mx-1"></i> for the community</p>
            </div>
        </div>
    </footer>

    <script>
        // Enhanced JavaScript with better performance
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

            // Theme toggle with smooth transition
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
                    // Toggle menu icon
                    const icon = mobileMenuButton.querySelector('svg');
                    if (mobileMenu.classList.contains('hidden')) {
                        icon.innerHTML = '<path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />';
                    } else {
                        icon.innerHTML = '<path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />';
                    }
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

            // Add active state to nav links
            const navLinks = document.querySelectorAll('.nav-link, .nav-link-mobile');
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    navLinks.forEach(l => l.classList.remove('bg-primary-500', 'text-white'));
                    this.classList.add('bg-primary-500', 'text-white');
                });
            });

            // Intersection Observer for animations
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            // Observe elements for scroll animations
            document.querySelectorAll('.animate-scale-in, .animate-slide-up').forEach(el => {
                observer.observe(el);
            });
        });

        // Add CSS for nav links
        const style = document.createElement('style');
        style.textContent = `
            .nav-link {
                color: #6b7280;
            }
            .nav-link:hover {
                color: #22c55e;
                background-color: rgba(34, 197, 94, 0.1);
            }
            .nav-link-mobile {
                color: #374151;
            }
            .dark .nav-link-mobile {
                color: #d1d5db;
            }
            .nav-link-mobile:hover {
                background-color: rgba(34, 197, 94, 0.1);
                color: #22c55e;
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>