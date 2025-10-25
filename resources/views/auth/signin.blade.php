<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CalcHub - Sign In</title>
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
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-white dark:bg-gray-800 transition-colors duration-300">
    <!-- Header/Navigation -->
    <header class="sticky top-0 z-50 bg-white/80 dark:bg-gray-800/80 backdrop-blur-md">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <div class="w-8 h-8 bg-primary-500 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V4a2 2 0 00-2-2H6zm1 2a1 1 0 000 2h6a1 1 0 100-2H7zm6 7a1 1 0 00-1 1v1H7v-1a1 1 0 00-2 0v1a2 2 0 002 2h6a2 2 0 002-2v-1a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <span class="text-xl font-bold text-gray-800 dark:text-white">CalcHub</span>
            </div>
            
            <div class="flex items-center space-x-4">
                <!-- Dark mode toggle -->
                <button id="theme-toggle" class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                    <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                    </svg>
                    <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path>
                    </svg>
                </button>
                
                <a href="{{ route('signin.form') }}" class="text-gray-600 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Sign In</a>
                <a href="{{ route('signup.form') }}" class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-lg transition-colors">Sign Up</a>
            </div>
        </div>
    </header>

    <!-- Login Section -->
    <section class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen flex items-center">
        <div class="container mx-auto px-4">
            <div class="max-w-md mx-auto bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                <div class="p-8">
                    <!-- Logo and Title -->
                    <div class="text-center mb-8">
                        <div class="w-16 h-16 bg-primary-500 rounded-xl flex items-center justify-center mx-auto mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V4a2 2 0 00-2-2H6zm1 2a1 1 0 000 2h6a1 1 0 100-2H7zm6 7a1 1 0 00-1 1v1H7v-1a1 1 0 00-2 0v1a2 2 0 002 2h6a2 2 0 002-2v-1a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Sign In to Your Account</h1>
                        <p class="text-gray-600 dark:text-gray-300 mt-2">Access all calculators and features</p>
                    </div>

                    <!-- Success Message -->
                    @if (session('success'))
                        <div class="mb-6 p-4 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 rounded-lg">
                            <ul class="list-disc ml-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Sign In Form -->
                    <form method="POST" action="{{ route('signin') }}">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email Address</label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors" placeholder="you@example.com">
                            </div>
                            
                            <div>
                                <div class="flex justify-between items-center mb-1">
                                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                                    <a href="{{ route('password.request') }}" class="text-sm text-primary-600 dark:text-primary-400 hover:underline">Forgot password?</a>
                                </div>
                                <input type="password" id="password" name="password" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors" placeholder="••••••••">
                            </div>
                            
                            <div class="flex items-center">
                                <input type="checkbox" id="remember" name="remember" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                                <label for="remember" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">Remember me</label>
                            </div>
                            
                            <button type="submit" class="w-full bg-primary-500 hover:bg-primary-600 text-white py-3 px-4 rounded-lg transition-colors font-medium">Sign In</button>
                        </div>
                    </form>

                    <!-- Divider -->
                    <div class="my-6 flex items-center">
                        <div class="flex-grow border-t border-gray-300 dark:border-gray-600"></div>
                        <span class="mx-4 text-gray-500 dark:text-gray-400 text-sm">Or continue with</span>
                        <div class="flex-grow border-t border-gray-300 dark:border-gray-600"></div>
                    </div>

                    <!-- Social Login -->
                    <div class="grid grid-cols-2 gap-4">
                        <button type="button" class="flex items-center justify-center py-2 px-4 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                            </svg>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Google</span>
                        </button>
                        
                        <button type="button" class="flex items-center justify-center py-2 px-4 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                            </svg>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Twitter</span>
                        </button>
                    </div>

                    <!-- Link to signup -->
                    <div class="mt-8 text-center">
                        <p class="text-gray-600 dark:text-gray-300">
                            Don't have an account? 
                            <a href="{{ route('signup.form') }}" class="text-primary-600 dark:text-primary-400 font-medium hover:underline">Sign up</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 dark:bg-gray-900 text-white py-8">
        <div class="container mx-auto px-4 text-center">
            <p class="text-gray-400">&copy; 2023 CalcHub. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Dark mode toggle functionality
        const themeToggle = document.getElementById('theme-toggle');
        const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

        // Change the icons inside the button based on previous settings
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            themeToggleLightIcon.classList.remove('hidden');
            document.documentElement.classList.add('dark');
        } else {
            themeToggleDarkIcon.classList.remove('hidden');
            document.documentElement.classList.remove('dark');
        }

        themeToggle.addEventListener('click', function() {
            // toggle icons
            themeToggleDarkIcon.classList.toggle('hidden');
            themeToggleLightIcon.classList.toggle('hidden');

            // if set via local storage previously
            if (localStorage.getItem('color-theme')) {
                if (localStorage.getItem('color-theme') === 'light') {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                }

            // if NOT set via local storage previously
            } else {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                }
            }
        });
    </script>
</body>
</html>