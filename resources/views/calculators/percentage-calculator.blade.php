<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='%2322c55e'><path fill-rule='evenodd' d='M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V4a2 2 0 00-2-2H6zm1 2a1 1 0 000 2h6a1 1 0 100-2H7zm6 7a1 1 0 00-1 1v1H7v-1a1 1 0 00-2 0v1a2 2 0 002 2h6a2 2 0 002-2v-1a1 1 0 00-1-1z' clip-rule='evenodd'/></svg>">
    <title>Percentage Calculator - CalcHub</title>
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
                        <a href="#" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">Profile</a>
                        <a href="#" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">Settings</a>
                        <div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>
                        <form method="POST" action="#">
                            <button 
                                type="submit" 
                                class="w-full text-left px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                Sign Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <!-- Welcome Section -->
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-2">Percentage Calculator 📊</h1>
            <p class="text-gray-600 dark:text-gray-400">Calculate percentages, increases, decreases, and more with ease</p>
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
                            <option value="basic">What is X% of Y?</option>
                            <option value="increase">Increase Y by X%</option>
                            <option value="decrease">Decrease Y by X%</option>
                            <option value="percentage_of">X is what % of Y?</option>
                            <option value="find_number">X is Y% of what number?</option>
                            <option value="percentage_change">Percentage change from X to Y</option>
                        </select>
                    </div>

                    <!-- Calculation Name -->
                    <div class="mb-6">
                        <label for="calculationName" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Calculation Name (Optional)
                        </label>
                        <input type="text" id="calculationName" 
                               class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors" 
                               placeholder="e.g., Discount Calculation, Tax Increase, etc.">
                    </div>

                    <!-- Dynamic Input Fields -->
                    <div id="inputFields" class="space-y-4 mb-6">
                        <!-- Basic: What is X% of Y? -->
                        <div id="basicFields" class="calculation-fields">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="percentage" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Percentage (X%)
                                    </label>
                                    <input type="number" id="percentage" 
                                           class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors" 
                                           placeholder="Enter percentage" step="0.01" min="0">
                                </div>
                                <div>
                                    <label for="number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Of Number (Y)
                                    </label>
                                    <input type="number" id="number" 
                                           class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors" 
                                           placeholder="Enter number" step="0.01">
                                </div>
                            </div>
                        </div>

                        <!-- Other calculation type fields will be shown/hidden dynamically -->
                    </div>

                    <!-- Calculate Button -->
                    <button id="calculateBtn" class="w-full bg-primary-500 hover:bg-primary-600 text-white py-3 rounded-lg font-semibold transition-all duration-300 shadow-sm hover:shadow-md active:scale-95 flex items-center justify-center">
                        <i class="fas fa-calculator mr-2"></i>
                        Calculate Percentage
                    </button>

                    <!-- Result Display -->
                    <div id="result" class="mt-6 p-6 bg-gray-50 dark:bg-gray-700 rounded-lg hidden">
                        <div class="text-center">
                            <div class="text-4xl font-bold text-primary-600 dark:text-primary-400 mb-2" id="resultValue"></div>
                            <div class="text-lg font-semibold text-gray-800 dark:text-white mb-1" id="resultTitle"></div>
                            <div class="text-sm text-gray-600 dark:text-gray-400 mb-4" id="formulaUsed"></div>
                        </div>
                        
                        <!-- Inputs Summary -->
                        <div id="inputsSummary" class="mt-4 p-4 bg-white dark:bg-gray-600 rounded-lg">
                            <h4 class="font-semibold text-gray-800 dark:text-white mb-3">Calculation Summary:</h4>
                            <div id="summaryList" class="space-y-2 text-sm"></div>
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
                        <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors" onclick="loadExample('basic')">
                            <div class="font-medium text-gray-800 dark:text-white">What is 15% of 200?</div>
                            <div class="text-gray-600 dark:text-gray-400 text-xs">Answer: 30</div>
                        </div>
                        <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors" onclick="loadExample('increase')">
                            <div class="font-medium text-gray-800 dark:text-white">Increase 80 by 25%</div>
                            <div class="text-gray-600 dark:text-gray-400 text-xs">Answer: 100</div>
                        </div>
                        <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors" onclick="loadExample('percentage_of')">
                            <div class="font-medium text-gray-800 dark:text-white">50 is what % of 200?</div>
                            <div class="text-gray-600 dark:text-gray-400 text-xs">Answer: 25%</div>
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
                            <span>Use decimal numbers for precise calculations</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-lightbulb text-primary-500 mt-1 mr-2 flex-shrink-0"></i>
                            <span>Negative percentages work for decreases</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-lightbulb text-primary-500 mt-1 mr-2 flex-shrink-0"></i>
                            <span>Sign in to save your calculations</span>
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
            document.getElementById('calculateBtn').addEventListener('click', calculatePercentage);

            // Update input fields when calculation type changes
            calculationType.addEventListener('change', updateInputFields);
            
            // Initialize input fields
            updateInputFields();

            function updateInputFields() {
                const type = calculationType.value;
                let html = '';

                switch (type) {
                    case 'basic':
                        html = `
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="percentage" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Percentage (X%)
                                    </label>
                                    <input type="number" id="percentage" 
                                           class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors" 
                                           placeholder="Enter percentage" step="0.01" min="0">
                                </div>
                                <div>
                                    <label for="number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Of Number (Y)
                                    </label>
                                    <input type="number" id="number" 
                                           class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors" 
                                           placeholder="Enter number" step="0.01">
                                </div>
                            </div>
                        `;
                        break;

                    case 'increase':
                    case 'decrease':
                        html = `
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="percentage" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Percentage (X%)
                                    </label>
                                    <input type="number" id="percentage" 
                                           class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors" 
                                           placeholder="Enter percentage" step="0.01">
                                </div>
                                <div>
                                    <label for="number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Number (Y)
                                    </label>
                                    <input type="number" id="number" 
                                           class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors" 
                                           placeholder="Enter number" step="0.01">
                                </div>
                            </div>
                        `;
                        break;

                    case 'percentage_of':
                        html = `
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="part" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Part (X)
                                    </label>
                                    <input type="number" id="part" 
                                           class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors" 
                                           placeholder="Enter part" step="0.01">
                                </div>
                                <div>
                                    <label for="whole" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Whole (Y)
                                    </label>
                                    <input type="number" id="whole" 
                                           class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors" 
                                           placeholder="Enter whole" step="0.01" min="0.01">
                                </div>
                            </div>
                        `;
                        break;

                    case 'find_number':
                        html = `
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="part" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Part (X)
                                    </label>
                                    <input type="number" id="part" 
                                           class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors" 
                                           placeholder="Enter part" step="0.01">
                                </div>
                                <div>
                                    <label for="percentage" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Percentage (Y%)
                                    </label>
                                    <input type="number" id="percentage" 
                                           class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors" 
                                           placeholder="Enter percentage" step="0.01" min="0.01">
                                </div>
                            </div>
                        `;
                        break;

                    case 'percentage_change':
                        html = `
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="old_value" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Old Value (X)
                                    </label>
                                    <input type="number" id="old_value" 
                                           class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors" 
                                           placeholder="Enter old value" step="0.01">
                                </div>
                                <div>
                                    <label for="new_value" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        New Value (Y)
                                    </label>
                                    <input type="number" id="new_value" 
                                           class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white transition-colors" 
                                           placeholder="Enter new value" step="0.01">
                                </div>
                            </div>
                        `;
                        break;
                }

                inputFields.innerHTML = html;
            }

            function calculatePercentage() {
                const type = calculationType.value;
                const inputs = getInputValues(type);

                if (!validateInputs(type, inputs)) {
                    alert('Please fill in all fields correctly.');
                    return;
                }

                const calculationName = document.getElementById('calculationName').value;

                // Show loading
                const calculateBtn = document.getElementById('calculateBtn');
                calculateBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Calculating...';
                calculateBtn.disabled = true;

                fetch("{{ route('percentage.calculate') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        calculation_type: type,
                        inputs: inputs,
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
                    calculateBtn.innerHTML = '<i class="fas fa-calculator mr-2"></i>Calculate Percentage';
                    calculateBtn.disabled = false;
                });
            }

            function getInputValues(type) {
                const inputs = {};
                
                switch (type) {
                    case 'basic':
                    case 'increase':
                    case 'decrease':
                        inputs.percentage = parseFloat(document.getElementById('percentage').value);
                        inputs.number = parseFloat(document.getElementById('number').value);
                        break;
                    case 'percentage_of':
                        inputs.part = parseFloat(document.getElementById('part').value);
                        inputs.whole = parseFloat(document.getElementById('whole').value);
                        break;
                    case 'find_number':
                        inputs.part = parseFloat(document.getElementById('part').value);
                        inputs.percentage = parseFloat(document.getElementById('percentage').value);
                        break;
                    case 'percentage_change':
                        inputs.old_value = parseFloat(document.getElementById('old_value').value);
                        inputs.new_value = parseFloat(document.getElementById('new_value').value);
                        break;
                }
                
                return inputs;
            }

            function validateInputs(type, inputs) {
                switch (type) {
                    case 'basic':
                    case 'increase':
                    case 'decrease':
                        return !isNaN(inputs.percentage) && !isNaN(inputs.number);
                    case 'percentage_of':
                        return !isNaN(inputs.part) && !isNaN(inputs.whole) && inputs.whole !== 0;
                    case 'find_number':
                        return !isNaN(inputs.part) && !isNaN(inputs.percentage) && inputs.percentage !== 0;
                    case 'percentage_change':
                        return !isNaN(inputs.old_value) && !isNaN(inputs.new_value) && inputs.old_value !== 0;
                    default:
                        return false;
                }
            }

            function displayResult(data) {
                const resultDiv = document.getElementById('result');
                const resultValue = document.getElementById('resultValue');
                const resultTitle = document.getElementById('resultTitle');
                const formulaUsed = document.getElementById('formulaUsed');
                const summaryList = document.getElementById('summaryList');

                // Set result value with appropriate formatting
                let displayValue = data.result;
                let suffix = '';
                
                if (data.calculation_type === 'percentage_of' || data.calculation_type === 'percentage_change') {
                    suffix = '%';
                }

                resultValue.textContent = `${displayValue}${suffix}`;
                
                // Set title based on calculation type
                const titles = {
                    'basic': 'Result',
                    'increase': 'Increased Amount',
                    'decrease': 'Decreased Amount',
                    'percentage_of': 'Percentage',
                    'find_number': 'Whole Number',
                    'percentage_change': 'Percentage Change'
                };
                
                resultTitle.textContent = titles[data.calculation_type] || 'Result';
                formulaUsed.textContent = data.formula;

                // Create summary
                summaryList.innerHTML = '';
                Object.entries(data.inputs).forEach(([key, value]) => {
                    const div = document.createElement('div');
                    div.className = 'flex justify-between text-sm';
                    const label = key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
                    const suffix = (key === 'percentage' || key === 'percentage_change') ? '%' : '';
                    div.innerHTML = `
                        <span>${label}:</span>
                        <span class="font-medium">${value}${suffix}</span>
                    `;
                    summaryList.appendChild(div);
                });

                resultDiv.classList.remove('hidden');
            }

            function loadHistory() {
                fetch("{{ route('percentage.history') }}")
                    .then(response => response.json())
                    .then(data => {
                        const historyList = document.getElementById('historyList');
                        
                        if (data.calculations.length === 0) {
                            historyList.innerHTML = '<div class="text-center text-gray-500 dark:text-gray-400 py-4">No calculation history yet</div>';
                            return;
                        }

                        historyList.innerHTML = data.calculations.map(calc => `
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3">
                                <div class="flex justify-between items-start mb-2">
                                    <div class="font-medium text-gray-800 dark:text-white text-sm">${calc.name}</div>
                                    <button class="delete-calculation text-red-500 hover:text-red-700 transition-colors" data-id="${calc.id}">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </div>
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-primary-600 dark:text-primary-400 font-semibold">${calc.result}${calc.type === 'percentage_of' || calc.type === 'percentage_change' ? '%' : ''}</span>
                                    <span class="text-gray-500 dark:text-gray-400 text-xs">${calc.date}</span>
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1 truncate">
                                    ${calc.formula}
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

                fetch(`/calculators/percentage/${id}`, {
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
            window.loadExample = function(type) {
                calculationType.value = type;
                updateInputFields();
                
                const examples = {
                    'basic': { percentage: 15, number: 200 },
                    'increase': { percentage: 25, number: 80 },
                    'percentage_of': { part: 50, whole: 200 }
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
    </script>
</body>
</html>

