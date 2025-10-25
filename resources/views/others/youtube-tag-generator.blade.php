<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='%2322c55e'><path fill-rule='evenodd' d='M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V4a2 2 0 00-2-2H6zm1 2a1 1 0 000 2h6a1 1 0 100-2H7zm6 7a1 1 0 00-1 1v1H7v-1a1 1 0 00-2 0v1a2 2 0 002 2h6a2 2 0 002-2v-1a1 1 0 00-1-1z' clip-rule='evenodd'/></svg>">
    <title>YouTube Tag Generator - CalcHub</title>
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
        
        .tag-copy {
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .tag-copy:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        .tag-copy.copied {
            background-color: #22c55e !important;
            color: white !important;
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
                        <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"><i class="fas fa-tachometer-alt mr-2"></i>Dashboard</a>
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
                <a href="#" class="py-2 text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">History</a>
                <a href="{{ route('profile') }}" class="py-2 text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Profile</a>
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
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">YouTube Tag Generator</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Page Header -->
        <div class="mb-8 animate-fade-in">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 dark:text-white mb-2">YouTube Tag Generator 🎬</h1>
                    <p class="text-gray-600 dark:text-gray-400">Generate optimized YouTube tags to improve your video's SEO and discoverability</p>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="px-3 py-1 bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 text-sm font-medium rounded-full">
                        YouTube Tag Generator
                    </span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Generator Card -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Generator Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 animate-scale-in">
                    <!-- Calculation Name -->
                    <div class="mb-6">
                        <label for="calculationName" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Project Name (Optional)
                        </label>
                        <input type="text" id="calculationName" 
                               class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors" 
                               placeholder="e.g., Travel Vlog Tags, Cooking Tutorial, etc.">
                    </div>

                    <!-- Input Fields -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Keyword -->
                        <div class="md:col-span-2 animate-slide-up" style="animation-delay: 0.1s">
                            <label for="keyword" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fab fa-youtube text-red-500 mr-2"></i>
                                Video Title / Keyword *
                            </label>
                            <input type="text" id="keyword" 
                                   class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors" 
                                   placeholder="Enter your YouTube video title or main keyword" required>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">This is the main keyword that will be used to generate relevant tags</p>
                        </div>

                        <!-- Language -->
                        <div class="animate-slide-up" style="animation-delay: 0.2s">
                            <label for="language" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-language text-primary-500 mr-2"></i>
                                Language
                            </label>
                            <select id="language" class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors">
                                <option value="en" selected>English</option>
                                <option value="es">Spanish</option>
                                <option value="fr">French</option>
                                <option value="de">German</option>
                                <option value="it">Italian</option>
                                <option value="pt">Portuguese</option>
                                <option value="ru">Russian</option>
                                <option value="ja">Japanese</option>
                                <option value="ko">Korean</option>
                                <option value="zh">Chinese</option>
                                <option value="hi">Hindi</option>
                                <option value="ar">Arabic</option>
                            </select>
                        </div>

                        <!-- Country -->
                        <div class="animate-slide-up" style="animation-delay: 0.3s">
                            <label for="country" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-globe text-primary-500 mr-2"></i>
                                Country
                            </label>
                            <select id="country" class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors">
                                <option value="US" selected>United States</option>
                                <option value="GB">United Kingdom</option>
                                <option value="CA">Canada</option>
                                <option value="AU">Australia</option>
                                <option value="IN">India</option>
                                <option value="DE">Germany</option>
                                <option value="FR">France</option>
                                <option value="BR">Brazil</option>
                                <option value="JP">Japan</option>
                                <option value="KR">South Korea</option>
                                <option value="MX">Mexico</option>
                                <option value="ES">Spain</option>
                            </select>
                        </div>

                        <!-- Max Results -->
                        <div class="animate-slide-up" style="animation-delay: 0.4s">
                            <label for="max_results" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-list-ol text-primary-500 mr-2"></i>
                                Number of Tags
                            </label>
                            <input type="number" id="max_results" 
                                   class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors" 
                                   min="5" max="50" value="20">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Number of tags to generate (5-50)</p>
                        </div>
                    </div>

                    <!-- Generate Button -->
                    <button id="generateBtn" class="w-full bg-red-500 hover:bg-red-600 text-white py-3 rounded-lg font-semibold transition-all duration-300 shadow-sm hover:shadow-md active:scale-95 flex items-center justify-center animate-scale-in" style="animation-delay: 0.5s">
                        <i class="fas fa-magic mr-2"></i>
                        Generate YouTube Tags
                    </button>

                    <!-- Result Display -->
                    <div id="result" class="mt-6 p-6 bg-gray-50 dark:bg-gray-700 rounded-lg hidden animate-fade-in">
                        <div class="text-center mb-6">
                            <div class="text-4xl font-bold text-red-600 dark:text-red-400 mb-2" id="tagsCount"></div>
                            <div class="text-lg font-semibold text-gray-800 dark:text-white mb-1">Optimized Tags Generated</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400" id="keywordUsed"></div>
                        </div>
                        
                        <!-- Tags Display -->
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="font-semibold text-gray-800 dark:text-white flex items-center">
                                    <i class="fas fa-tags text-red-500 mr-2"></i>
                                    Generated Tags
                                </h4>
                                <button id="copyAllBtn" class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center">
                                    <i class="fas fa-copy mr-2"></i>
                                    Copy All
                                </button>
                            </div>
                            <div id="tagsContainer" class="flex flex-wrap gap-2">
                                <!-- Tags will be inserted here -->
                            </div>
                        </div>

                        <!-- API Info -->
                        <div class="mt-4 p-4 bg-white dark:bg-gray-600 rounded-lg border border-gray-200 dark:border-gray-500">
                            <h4 class="font-semibold text-gray-800 dark:text-white mb-3 flex items-center">
                                <i class="fas fa-info-circle text-primary-500 mr-2"></i>
                                About These Tags:
                            </h4>
                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                These tags are generated using AI and are optimized for YouTube SEO. They help improve your video's discoverability in search results and recommendations. Use them in your video's tag section for better visibility.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Quick Examples -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 animate-scale-in" style="animation-delay: 0.2s">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 flex items-center">
                        <i class="fas fa-bolt text-red-500 mr-2"></i>
                        Quick Examples
                    </h3>
                    <div class="space-y-3 text-sm">
                        <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors border border-gray-200 dark:border-gray-600" onclick="loadExample('travel')">
                            <div class="font-medium text-gray-800 dark:text-white">Travel Vlogging</div>
                            <div class="text-gray-600 dark:text-gray-400 text-xs">"Top 10 Travel Destinations in 2025"</div>
                        </div>
                        <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors border border-gray-200 dark:border-gray-600" onclick="loadExample('cooking')">
                            <div class="font-medium text-gray-800 dark:text-white">Cooking Tutorial</div>
                            <div class="text-gray-600 dark:text-gray-400 text-xs">"Easy Chicken Recipes for Beginners"</div>
                        </div>
                        <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors border border-gray-200 dark:border-gray-600" onclick="loadExample('fitness')">
                            <div class="font-medium text-gray-800 dark:text-white">Fitness Workout</div>
                            <div class="text-gray-600 dark:text-gray-400 text-xs">"30 Minute Full Body Home Workout"</div>
                        </div>
                        <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors border border-gray-200 dark:border-gray-600" onclick="loadExample('tech')">
                            <div class="font-medium text-gray-800 dark:text-white">Tech Review</div>
                            <div class="text-gray-600 dark:text-gray-400 text-xs">"iPhone 15 Pro Max Honest Review"</div>
                        </div>
                    </div>
                </div>

                <!-- Generation History -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 animate-scale-in" style="animation-delay: 0.4s">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white flex items-center">
                            <i class="fas fa-history text-primary-500 mr-2"></i>
                            Recent Generations
                        </h3>
                        <button id="refreshHistory" class="text-primary-500 hover:text-primary-600 transition-colors p-1">
                            <i class="fas fa-refresh"></i>
                        </button>
                    </div>
                    <div id="historyList" class="space-y-3 max-h-80 overflow-y-auto">
                        <!-- History items will be loaded here -->
                        <div class="text-center text-gray-500 dark:text-gray-400 py-4">
                            <i class="fas fa-clock text-2xl mb-2"></i>
                            <div>No generation history yet</div>
                        </div>
                    </div>
                </div>

                <!-- YouTube Tips -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 animate-scale-in" style="animation-delay: 0.6s">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 flex items-center">
                        <i class="fas fa-lightbulb text-red-500 mr-2"></i>
                        YouTube SEO Tips
                    </h3>
                    <ul class="space-y-3 text-sm text-gray-600 dark:text-gray-400">
                        <li class="flex items-start">
                            <i class="fas fa-search text-red-500 mt-1 mr-3 flex-shrink-0"></i>
                            <span>Use 10-15 relevant tags per video for optimal SEO</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-tag text-red-500 mt-1 mr-3 flex-shrink-0"></i>
                            <span>Include both broad and specific tags</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-list-ol text-red-500 mt-1 mr-3 flex-shrink-0"></i>
                            <span>Put the most important tags first</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-chart-line text-red-500 mt-1 mr-3 flex-shrink-0"></i>
                            <span>Update tags based on video performance</span>
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

    // Generate button
    document.getElementById('generateBtn').addEventListener('click', generateTags);

    // Copy all button
    document.getElementById('copyAllBtn').addEventListener('click', copyAllTags);

    async function generateTags() {
        const inputs = {
            keyword: document.getElementById('keyword').value.trim(),
            language: document.getElementById('language').value,
            country: document.getElementById('country').value,
            max_results: parseInt(document.getElementById('max_results').value)
        };

        // Validate inputs
        if (!inputs.keyword) {
            alert('Please enter a video title or keyword');
            return;
        }

        const calculationName = document.getElementById('calculationName').value;

        // Show loading
        const generateBtn = document.getElementById('generateBtn');
        generateBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Generating Tags...';
        generateBtn.disabled = true;

        try {
            const response = await fetch('{{ route("youtube.tag-generator.generate") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(inputs)
            });

            const data = await response.json();
            
            console.log('API Response:', data); // Debug log
            
            if (data.success && data.tags) {
                displayResult(data, inputs.keyword);
                saveToHistory(calculationName, inputs, data);
            } else {
                throw new Error(data.error || 'No tags were generated. Please try a different keyword.');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error: ' + error.message);
        } finally {
            generateBtn.innerHTML = '<i class="fas fa-magic mr-2"></i>Generate YouTube Tags';
            generateBtn.disabled = false;
        }
    }

    function displayResult(data, keyword) {
        const resultDiv = document.getElementById('result');
        const tagsCount = document.getElementById('tagsCount');
        const keywordUsed = document.getElementById('keywordUsed');
        const tagsContainer = document.getElementById('tagsContainer');

        // Check if tags exist and is an array
        if (!data.tags || !Array.isArray(data.tags)) {
            console.error('Invalid tags data:', data.tags);
            tagsContainer.innerHTML = '<div class="text-red-500 dark:text-red-400 text-center py-4">Error: No valid tags received from API</div>';
            return;
        }

        tagsCount.textContent = data.tags.length;
        keywordUsed.textContent = `For: "${keyword}"`;
        
        // Clear previous tags
        tagsContainer.innerHTML = '';

        // Add tags
        if (data.tags.length > 0) {
            data.tags.forEach(tag => {
                // Ensure tag is a string
                const tagText = String(tag).trim();
                if (tagText) {
                    const tagElement = document.createElement('div');
                    tagElement.className = 'tag-copy bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-500 px-3 py-2 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 cursor-pointer transition-all duration-200';
                    tagElement.textContent = tagText;
                    tagElement.title = 'Click to copy tag';
                    
                    tagElement.addEventListener('click', function() {
                        copyToClipboard(tagText, tagElement);
                    });
                    
                    tagsContainer.appendChild(tagElement);
                }
            });
        } else {
            tagsContainer.innerHTML = '<div class="text-gray-500 dark:text-gray-400 text-center py-4">No tags generated. Try a different keyword.</div>';
        }

        resultDiv.classList.remove('hidden');
        
        // Scroll to result
        resultDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    function copyToClipboard(text, element) {
        navigator.clipboard.writeText(text).then(() => {
            // Visual feedback
            element.classList.add('copied');
            const originalText = element.textContent;
            element.innerHTML = '<i class="fas fa-check mr-1"></i>Copied!';
            
            setTimeout(() => {
                element.classList.remove('copied');
                element.textContent = originalText;
            }, 1500);
        }).catch(err => {
            console.error('Failed to copy: ', err);
            alert('Failed to copy tag to clipboard');
        });
    }

    function copyAllTags() {
        const tagElements = document.querySelectorAll('#tagsContainer .tag-copy');
        const tags = Array.from(tagElements)
            .map(tag => tag.textContent)
            .filter(tag => tag.trim())
            .join(', ');
        
        if (tags) {
            navigator.clipboard.writeText(tags).then(() => {
                // Visual feedback for copy all button
                const copyBtn = document.getElementById('copyAllBtn');
                const originalText = copyBtn.innerHTML;
                copyBtn.innerHTML = '<i class="fas fa-check mr-2"></i>Copied All!';
                
                setTimeout(() => {
                    copyBtn.innerHTML = originalText;
                }, 1500);
            }).catch(err => {
                console.error('Failed to copy all: ', err);
                alert('Failed to copy tags to clipboard');
            });
        }
    }

    function loadHistory() {
        // Simulate loading history from localStorage
        const history = JSON.parse(localStorage.getItem('youtubeTagHistory') || '[]');
        const historyList = document.getElementById('historyList');
        
        if (history.length === 0) {
            historyList.innerHTML = `
                <div class="text-center text-gray-500 dark:text-gray-400 py-4">
                    <i class="fas fa-clock text-2xl mb-2"></i>
                    <div>No generation history yet</div>
                </div>
            `;
            return;
        }

        historyList.innerHTML = history.slice(-5).reverse().map(calc => `
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 border border-gray-200 dark:border-gray-600">
                <div class="flex justify-between items-start mb-2">
                    <div class="font-medium text-gray-800 dark:text-white text-sm">${calc.name || 'Unnamed Generation'}</div>
                    <button class="delete-generation text-red-500 hover:text-red-700 transition-colors p-1" data-id="${calc.id}">
                        <i class="fas fa-trash text-xs"></i>
                    </button>
                </div>
                <div class="flex justify-between items-center text-sm">
                    <span class="text-red-600 dark:text-red-400 font-semibold">
                        ${calc.result.tags ? calc.result.tags.length : 0} tags
                    </span>
                    <span class="text-gray-500 dark:text-gray-400 text-xs">${new Date(calc.timestamp).toLocaleDateString()}</span>
                </div>
                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1 truncate">
                    ${calc.inputs.keyword}
                </div>
            </div>
        `).join('');

        // Add event listeners to delete buttons
        document.querySelectorAll('.delete-generation').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                deleteGeneration(id);
            });
        });
    }

    function saveToHistory(name, inputs, result) {
        const history = JSON.parse(localStorage.getItem('youtubeTagHistory') || '[]');
        history.push({
            id: Date.now(),
            name: name,
            inputs: inputs,
            result: result,
            timestamp: new Date().toISOString()
        });
        localStorage.setItem('youtubeTagHistory', JSON.stringify(history));
        loadHistory();
    }

    function deleteGeneration(id) {
        if (!confirm('Are you sure you want to delete this generation?')) {
            return;
        }

        const history = JSON.parse(localStorage.getItem('youtubeTagHistory') || '[]');
        const updatedHistory = history.filter(calc => calc.id != id);
        localStorage.setItem('youtubeTagHistory', JSON.stringify(updatedHistory));
        loadHistory();
    }

    // Example loader function
    window.loadExample = function(type) {
        const examples = {
            'travel': { keyword: 'Top 10 Travel Destinations in 2025', language: 'en', country: 'US', max_results: 20 },
            'cooking': { keyword: 'Easy Chicken Recipes for Beginners', language: 'en', country: 'US', max_results: 15 },
            'fitness': { keyword: '30 Minute Full Body Home Workout', language: 'en', country: 'US', max_results: 20 },
            'tech': { keyword: 'iPhone 15 Pro Max Honest Review', language: 'en', country: 'US', max_results: 15 }
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