<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - CalcHub</title>
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
            <a href="{{ route('home') }}" class="flex items-center space-x-2">
                <div class="w-8 h-8 bg-primary-500 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V4a2 2 0 00-2-2H6zm1 2a1 1 0 000 2h6a1 1 0 100-2H7zm6 7a1 1 0 00-1 1v1H7v-1a1 1 0 00-2 0v1a2 2 0 002 2h6a2 2 0 002-2v-1a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <span class="text-xl font-bold text-gray-800 dark:text-white">CalcHub</span>
            </a>
            
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
                
                <!-- User Menu -->
                <div class="relative group">
                    <button class="flex items-center space-x-2 bg-gray-100 dark:bg-gray-700 rounded-lg px-3 py-2">
                        <div class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-white font-medium">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <span class="text-gray-700 dark:text-gray-300 font-medium">{{ $user->name }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 border border-gray-200 dark:border-gray-700">
                        <a href="{{ route('profile') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-user mr-2"></i>Profile
                        </a>
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
    </header>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <!-- Profile Header -->
        <div class="text-center mb-8">
            <div class="w-32 h-32 bg-primary-500 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                <span class="text-4xl font-bold text-white">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-2">Profile Settings</h1>
            <p class="text-gray-600 dark:text-gray-400">Manage your account settings and preferences</p>
        </div>

        <div class="max-w-2xl mx-auto">
            <!-- Profile Information Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Profile Information</h2>
                    <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse" title="Online"></div>
                </div>

                <form id="profileForm">
                    @csrf
                    <div class="space-y-4">
                        <!-- Name Input -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Full Name
                            </label>
                            <input type="text" id="name" name="name" 
                                   class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors" 
                                   value="{{ $user->name }}" required>
                            <div id="nameError" class="text-red-500 text-sm mt-1 hidden"></div>
                        </div>

                        <!-- Email Input -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Email Address
                            </label>
                            <input type="email" id="email" name="email" 
                                   class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors" 
                                   value="{{ $user->email }}" required>
                            <div id="emailError" class="text-red-500 text-sm mt-1 hidden"></div>
                        </div>

                        <!-- Member Since -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Member Since
                            </label>
                            <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg text-gray-600 dark:text-gray-400">
                                {{ $user->created_at->format('F j, Y') }}
                            </div>
                        </div>
                    </div>

                    <!-- Update Button -->
                    <div class="mt-6">
                        <button type="submit" 
                                class="w-full bg-primary-500 hover:bg-primary-600 text-white py-3 rounded-lg font-semibold transition-all duration-300 shadow-sm hover:shadow-md active:scale-95 flex items-center justify-center">
                            <i class="fas fa-save mr-2"></i>
                            Update Profile
                        </button>
                    </div>
                </form>

                <!-- Success Message -->
                <div id="profileSuccess" class="mt-4 p-4 bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-800 rounded-lg hidden">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-2"></i>
                        <span class="text-green-700 dark:text-green-300" id="profileSuccessMessage"></span>
                    </div>
                </div>
            </div>

            <!-- Change Password Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-6">Change Password</h2>

                <form id="passwordForm">
                    @csrf
                    <div class="space-y-4">
                        <!-- Current Password -->
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Current Password
                            </label>
                            <div class="relative">
                                <input type="password" id="current_password" name="current_password" 
                                       class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors pr-10" 
                                       placeholder="Enter current password" required>
                                <button type="button" 
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                                        onclick="togglePassword('current_password')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div id="currentPasswordError" class="text-red-500 text-sm mt-1 hidden"></div>
                        </div>

                        <!-- New Password -->
                        <div>
                            <label for="new_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                New Password
                            </label>
                            <div class="relative">
                                <input type="password" id="new_password" name="new_password" 
                                       class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors pr-10" 
                                       placeholder="Enter new password" required>
                                <button type="button" 
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                                        onclick="togglePassword('new_password')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                Password must be at least 8 characters with letters, numbers, and symbols.
                            </div>
                            <div id="newPasswordError" class="text-red-500 text-sm mt-1 hidden"></div>
                        </div>

                        <!-- Confirm New Password -->
                        <div>
                            <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Confirm New Password
                            </label>
                            <div class="relative">
                                <input type="password" id="new_password_confirmation" name="new_password_confirmation" 
                                       class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors pr-10" 
                                       placeholder="Confirm new password" required>
                                <button type="button" 
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                                        onclick="togglePassword('new_password_confirmation')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div id="confirmPasswordError" class="text-red-500 text-sm mt-1 hidden"></div>
                        </div>
                    </div>

                    <!-- Update Password Button -->
                    <div class="mt-6">
                        <button type="submit" 
                                class="w-full bg-blue-500 hover:bg-blue-600 text-white py-3 rounded-lg font-semibold transition-all duration-300 shadow-sm hover:shadow-md active:scale-95 flex items-center justify-center">
                            <i class="fas fa-key mr-2"></i>
                            Change Password
                        </button>
                    </div>
                </form>

                <!-- Success Message -->
                <div id="passwordSuccess" class="mt-4 p-4 bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-800 rounded-lg hidden">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-2"></i>
                        <span class="text-green-700 dark:text-green-300" id="passwordSuccessMessage"></span>
                    </div>
                </div>
            </div>

            <!-- Danger Zone Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-red-200 dark:border-red-800 p-6">
                <h2 class="text-xl font-semibold text-red-600 dark:text-red-400 mb-2">Danger Zone</h2>
                <p class="text-gray-600 dark:text-gray-400 mb-6">
                    Once you delete your account, there is no going back. Please be certain.
                </p>

                <!-- Delete Account Button -->
                <button type="button" 
                        onclick="openDeleteModal()"
                        class="w-full bg-red-500 hover:bg-red-600 text-white py-3 rounded-lg font-semibold transition-all duration-300 shadow-sm hover:shadow-md active:scale-95 flex items-center justify-center">
                    <i class="fas fa-trash mr-2"></i>
                    Delete Account
                </button>
            </div>
        </div>
    </div>

    <!-- Delete Account Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg max-w-md w-full p-6">
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-red-100 dark:bg-red-900 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-exclamation-triangle text-red-600 dark:text-red-400 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2">Delete Account</h3>
                <p class="text-gray-600 dark:text-gray-400">
                    Are you sure you want to delete your account? This action cannot be undone.
                </p>
            </div>

            <form id="deleteForm">
                @csrf
                <div class="mb-4">
                    <label for="delete_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Enter your password to confirm
                    </label>
                    <input type="password" id="delete_password" name="password" 
                           class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white transition-colors" 
                           placeholder="Enter your password" required>
                    <div id="deletePasswordError" class="text-red-500 text-sm mt-1 hidden"></div>
                </div>

                <div class="flex space-x-3">
                    <button type="button" 
                            onclick="closeDeleteModal()"
                            class="flex-1 bg-gray-300 hover:bg-gray-400 dark:bg-gray-600 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 py-3 rounded-lg font-semibold transition-colors">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="flex-1 bg-red-500 hover:bg-red-600 text-white py-3 rounded-lg font-semibold transition-colors flex items-center justify-center">
                        <i class="fas fa-trash mr-2"></i>
                        Delete Account
                    </button>
                </div>
            </form>
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
        // Password visibility toggle
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const icon = input.nextElementSibling.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Delete modal functions
        function openDeleteModal() {
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            document.getElementById('deleteForm').reset();
            hideError('deletePasswordError');
        }

        // Error handling functions
        function showError(elementId, message) {
            const element = document.getElementById(elementId);
            element.textContent = message;
            element.classList.remove('hidden');
        }

        function hideError(elementId) {
            const element = document.getElementById(elementId);
            element.classList.add('hidden');
        }

        function hideAllErrors() {
            hideError('nameError');
            hideError('emailError');
            hideError('currentPasswordError');
            hideError('newPasswordError');
            hideError('confirmPasswordError');
            hideError('deletePasswordError');
        }

        function showSuccess(elementId, message) {
            const element = document.getElementById(elementId);
            const messageElement = document.getElementById(elementId + 'Message');
            messageElement.textContent = message;
            element.classList.remove('hidden');
            
            setTimeout(() => {
                element.classList.add('hidden');
            }, 5000);
        }

        // Profile form submission
        document.getElementById('profileForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitButton = this.querySelector('button[type="submit"]');
            
            // Show loading state
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Updating...';
            submitButton.disabled = true;
            
            hideAllErrors();
            hideError('profileSuccess');

            fetch("{{ route('profile.update') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showSuccess('profileSuccess', data.message);
                    // Update user initial in header
                    const userInitial = document.querySelector('.w-8.h-8.bg-primary-500');
                    if (userInitial) {
                        userInitial.textContent = data.user.name.charAt(0).toUpperCase();
                    }
                    // Update user name in header
                    const userName = document.querySelector('.text-gray-700.dark\\:text-gray-300.font-medium');
                    if (userName) {
                        userName.textContent = data.user.name;
                    }
                } else {
                    if (data.errors) {
                        Object.keys(data.errors).forEach(field => {
                            showError(field + 'Error', data.errors[field][0]);
                        });
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showError('profileError', 'An error occurred. Please try again.');
            })
            .finally(() => {
                submitButton.innerHTML = '<i class="fas fa-save mr-2"></i>Update Profile';
                submitButton.disabled = false;
            });
        });

        // Password form submission
        document.getElementById('passwordForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitButton = this.querySelector('button[type="submit"]');
            
            // Show loading state
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Changing...';
            submitButton.disabled = true;
            
            hideAllErrors();
            hideError('passwordSuccess');

            fetch("{{ route('profile.password') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showSuccess('passwordSuccess', data.message);
                    this.reset();
                } else {
                    if (data.errors) {
                        Object.keys(data.errors).forEach(field => {
                            showError(field + 'Error', data.errors[field][0]);
                        });
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showError('passwordError', 'An error occurred. Please try again.');
            })
            .finally(() => {
                submitButton.innerHTML = '<i class="fas fa-key mr-2"></i>Change Password';
                submitButton.disabled = false;
            });
        });

        // Delete form submission
        document.getElementById('deleteForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitButton = this.querySelector('button[type="submit"]');
            
            // Show loading state
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Deleting...';
            submitButton.disabled = true;
            
            hideAllErrors();

            fetch("{{ route('profile.delete') }}", {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    }
                } else {
                    if (data.errors) {
                        Object.keys(data.errors).forEach(field => {
                            showError('deletePasswordError', data.errors[field][0]);
                        });
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showError('deletePasswordError', 'An error occurred. Please try again.');
            })
            .finally(() => {
                submitButton.innerHTML = '<i class="fas fa-trash mr-2"></i>Delete Account';
                submitButton.disabled = false;
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