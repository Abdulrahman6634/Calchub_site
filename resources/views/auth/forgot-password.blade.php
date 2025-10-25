<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='%2322c55e'><path fill-rule='evenodd' d='M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V4a2 2 0 00-2-2H6zm1 2a1 1 0 000 2h6a1 1 0 100-2H7zm6 7a1 1 0 00-1 1v1H7v-1a1 1 0 00-2 0v1a2 2 0 002 2h6a2 2 0 002-2v-1a1 1 0 00-1-1z' clip-rule='evenodd'/></svg>">
    <title>Reset Password - CalcHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            500: '#22c55e',
                            600: '#16a34a',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.5s ease-out;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="flex items-center justify-center space-x-2 mb-4">
                <div class="w-10 h-10 bg-primary-500 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V4a2 2 0 00-2-2H6zm1 2a1 1 0 000 2h6a1 1 0 100-2H7zm6 7a1 1 0 00-1 1v1H7v-1a1 1 0 00-2 0v1a2 2 0 002 2h6a2 2 0 002-2v-1a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <span class="text-2xl font-bold text-gray-900">CalcHub</span>
            </div>
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Reset Your Password</h1>
            <p class="text-gray-600">Enter your email to receive a verification code</p>
        </div>

        <!-- Progress Steps -->
        <div class="flex items-center justify-center mb-8">
            <div class="flex items-center">
                <div class="w-8 h-8 rounded-full bg-primary-500 text-white flex items-center justify-center text-sm font-medium">
                    1
                </div>
                <div class="w-16 h-1 bg-primary-500 mx-2"></div>
                <div class="w-8 h-8 rounded-full border-2 border-gray-300 text-gray-500 flex items-center justify-center text-sm font-medium">
                    2
                </div>
                <div class="w-16 h-1 bg-gray-300 mx-2"></div>
                <div class="w-8 h-8 rounded-full border-2 border-gray-300 text-gray-500 flex items-center justify-center text-sm font-medium">
                    3
                </div>
            </div>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 animate-fade-in">
            <!-- Step 1: Email Input -->
            <div id="step1">
                <form id="emailForm">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email Address
                            </label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                                placeholder="Enter your email address"
                            >
                        </div>
                        
                        <button 
                            type="submit"
                            id="sendCodeBtn"
                            class="w-full bg-primary-500 text-white py-3 px-4 rounded-lg hover:bg-primary-600 focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-colors font-medium"
                        >
                            Send Verification Code
                        </button>
                    </div>
                </form>
                
                <div class="mt-4 text-center">
                    <a href="{{ route('signin.form') }}" class="text-primary-500 hover:text-primary-600 font-medium">
                        ← Back to Login
                    </a>
                </div>
            </div>

            <!-- Step 2: Code Verification -->
            <div id="step2" class="hidden">
                <div class="text-center mb-6">
                    <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Check Your Email</h3>
                    <p class="text-gray-600 mb-2">We sent a 6-digit code to</p>
                    <p class="text-gray-900 font-medium" id="emailDisplay"></p>
                </div>

                <form id="codeForm">
                    @csrf
                    <input type="hidden" id="verificationEmail" name="email">
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Verification Code
                            </label>
                            <input 
                                type="text" 
                                id="code" 
                                name="code"
                                maxlength="6"
                                required
                                class="w-full px-4 py-3 text-center text-xl font-semibold tracking-widest border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                                placeholder="000000"
                            >
                            <p class="text-sm text-gray-500 mt-2 text-center">
                                Enter the 6-digit code from your email
                            </p>
                        </div>
                        
                        <div class="flex space-x-3">
                            <button 
                                type="button"
                                id="resendCodeBtn"
                                class="flex-1 bg-gray-100 text-gray-700 py-3 px-4 rounded-lg hover:bg-gray-200 transition-colors font-medium"
                            >
                                Resend Code
                            </button>
                            <button 
                                type="submit"
                                id="verifyCodeBtn"
                                class="flex-1 bg-primary-500 text-white py-3 px-4 rounded-lg hover:bg-primary-600 focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-colors font-medium"
                            >
                                Verify Code
                            </button>
                        </div>
                    </div>
                </form>
                
                <div class="mt-4 text-center">
                    <button 
                        type="button"
                        onclick="goBackToStep1()"
                        class="text-primary-500 hover:text-primary-600 font-medium"
                    >
                        ← Use different email
                    </button>
                </div>
            </div>

            <!-- Step 3: New Password -->
            <div id="step3" class="hidden">
                <div class="text-center mb-6">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Create New Password</h3>
                    <p class="text-gray-600">Enter your new password below</p>
                </div>

                <form id="passwordForm">
                    @csrf
                    <input type="hidden" id="sessionToken" name="session_token">
                    
                    <div class="space-y-4">
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                New Password
                            </label>
                            <input 
                                type="password" 
                                id="password" 
                                name="password"
                                required
                                minlength="8"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                                placeholder="Enter new password"
                            >
                        </div>
                        
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                Confirm Password
                            </label>
                            <input 
                                type="password" 
                                id="password_confirmation" 
                                name="password_confirmation"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                                placeholder="Confirm new password"
                            >
                        </div>
                        
                        <button 
                            type="submit"
                            id="resetPasswordBtn"
                            class="w-full bg-primary-500 text-white py-3 px-4 rounded-lg hover:bg-primary-600 focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-colors font-medium"
                        >
                            Reset Password
                        </button>
                    </div>
                </form>
            </div>

            <!-- Success Message -->
            <div id="successMessage" class="hidden text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Password Reset Successful!</h3>
                <p class="text-gray-600 mb-6" id="successText"></p>
                <a 
                    href="{{ route('signin.form') }}" 
                    class="w-full bg-primary-500 text-white py-3 px-4 rounded-lg hover:bg-primary-600 focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-colors font-medium inline-block"
                >
                    Continue to Login
                </a>
            </div>
        </div>

        <!-- Messages -->
        <div id="messageContainer" class="mt-4"></div>
    </div>

    <script>
        let resendCooldown = 60;
        let resendTimer;

        function showMessage(message, type = 'error') {
            const container = document.getElementById('messageContainer');
            const alertClass = type === 'success' ? 'bg-green-50 border-green-200 text-green-800' : 'bg-red-50 border-red-200 text-red-800';
            const icon = type === 'success' ? '✅' : '❌';
            
            container.innerHTML = `
                <div class="rounded-lg border p-4 ${alertClass} animate-fade-in">
                    <div class="flex items-center space-x-2">
                        <span>${icon}</span>
                        <span class="font-medium">${message}</span>
                    </div>
                </div>
            `;
            
            // Auto-hide success messages after 5 seconds
            if (type === 'success') {
                setTimeout(() => {
                    container.innerHTML = '';
                }, 5000);
            }
        }

        function updateProgress(step) {
            const steps = document.querySelectorAll('.flex.items-center > div:nth-child(odd)');
            const lines = document.querySelectorAll('.flex.items-center > div:nth-child(even)');
            
            steps.forEach((circle, index) => {
                if (index < step) {
                    circle.className = circle.className.replace('border-gray-300 text-gray-500', 'bg-primary-500 text-white');
                    circle.className = circle.className.replace('border-2', '');
                } else {
                    circle.className = circle.className.replace('bg-primary-500 text-white', 'border-2 border-gray-300 text-gray-500');
                }
            });
            
            lines.forEach((line, index) => {
                if (index < step - 1) {
                    line.className = line.className.replace('bg-gray-300', 'bg-primary-500');
                } else {
                    line.className = line.className.replace('bg-primary-500', 'bg-gray-300');
                }
            });
        }

        function goToStep(step) {
            document.getElementById('step1').classList.add('hidden');
            document.getElementById('step2').classList.add('hidden');
            document.getElementById('step3').classList.add('hidden');
            document.getElementById('successMessage').classList.add('hidden');
            
            document.getElementById(`step${step}`).classList.remove('hidden');
            updateProgress(step);
        }

        function goBackToStep1() {
            goToStep(1);
            document.getElementById('messageContainer').innerHTML = '';
        }

        function startResendCooldown() {
            const btn = document.getElementById('resendCodeBtn');
            btn.disabled = true;
            btn.textContent = `Resend (${resendCooldown}s)`;
            
            resendTimer = setInterval(() => {
                resendCooldown--;
                btn.textContent = `Resend (${resendCooldown}s)`;
                
                if (resendCooldown <= 0) {
                    clearInterval(resendTimer);
                    btn.disabled = false;
                    btn.textContent = 'Resend Code';
                    resendCooldown = 60;
                }
            }, 1000);
        }

        // Email form submission
        document.getElementById('emailForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const btn = document.getElementById('sendCodeBtn');
            const originalText = btn.textContent;
            
            btn.disabled = true;
            btn.textContent = 'Sending...';
            
            const formData = new FormData(e.target);
            
            try {
                const response = await fetch('{{ route("password.send-code") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    document.getElementById('emailDisplay').textContent = data.email;
                    document.getElementById('verificationEmail').value = formData.get('email');
                    goToStep(2);
                    showMessage(data.message, 'success');
                    startResendCooldown();
                } else {
                    showMessage(data.message, 'error');
                }
            } catch (error) {
                showMessage('An error occurred. Please try again.', 'error');
            } finally {
                btn.disabled = false;
                btn.textContent = originalText;
            }
        });

        // Code verification
        document.getElementById('codeForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const btn = document.getElementById('verifyCodeBtn');
            const originalText = btn.textContent;
            
            btn.disabled = true;
            btn.textContent = 'Verifying...';
            
            const formData = new FormData(e.target);
            formData.append('email', document.getElementById('verificationEmail').value);
            
            try {
                const response = await fetch('{{ route("password.verify-code") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    document.getElementById('sessionToken').value = data.session_token;
                    goToStep(3);
                    showMessage(data.message, 'success');
                } else {
                    showMessage(data.message, 'error');
                }
            } catch (error) {
                showMessage('An error occurred. Please try again.', 'error');
            } finally {
                btn.disabled = false;
                btn.textContent = originalText;
            }
        });

        // Resend code
        document.getElementById('resendCodeBtn').addEventListener('click', async () => {
            const btn = document.getElementById('resendCodeBtn');
            const email = document.getElementById('verificationEmail').value;
            
            btn.disabled = true;
            btn.textContent = 'Sending...';
            
            try {
                const response = await fetch('{{ route("password.resend-code") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ email })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showMessage(data.message, 'success');
                    startResendCooldown();
                } else {
                    showMessage(data.message, 'error');
                    btn.disabled = false;
                    btn.textContent = 'Resend Code';
                }
            } catch (error) {
                showMessage('An error occurred. Please try again.', 'error');
                btn.disabled = false;
                btn.textContent = 'Resend Code';
            }
        });

        // Password reset
        document.getElementById('passwordForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const btn = document.getElementById('resetPasswordBtn');
            const originalText = btn.textContent;
            
            btn.disabled = true;
            btn.textContent = 'Resetting...';
            
            const formData = new FormData(e.target);
            
            try {
                const response = await fetch('{{ route("password.reset") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    document.getElementById('successText').textContent = data.message;
                    document.getElementById('step3').classList.add('hidden');
                    document.getElementById('successMessage').classList.remove('hidden');
                    updateProgress(4);
                    showMessage(data.message, 'success');
                    
                    if (data.redirect_url) {
                        setTimeout(() => {
                            window.location.href = data.redirect_url;
                        }, 3000);
                    }
                } else {
                    showMessage(data.message, 'error');
                }
            } catch (error) {
                showMessage('An error occurred. Please try again.', 'error');
            } finally {
                btn.disabled = false;
                btn.textContent = originalText;
            }
        });

        // Auto-format code input
        document.getElementById('code').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 6);
        });
    </script>
</body>
</html>