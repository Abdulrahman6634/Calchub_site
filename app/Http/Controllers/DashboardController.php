<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\CgpaCalculation;
use App\Models\CurrencyConversion;
use App\Models\PercentageCalculation;
use App\Models\CalorieCalculation;
use App\Models\ProfitLossCalculation;
use App\Models\BmiCalculation;
use App\Models\DateTimeCalculation;
use App\Models\LoanCalculation;

class DashboardController extends Controller
{
    /**
     * Show the main dashboard view.
     */
    public function show()
    {
        $user = Auth::user();

        // Get data
        $quickStats = $this->getQuickStats($user->id);
        $recentCalculations = $this->getRecentCalculations($user->id);
        $calculatorUsage = $this->getCalculatorUsage($user->id);

        return view('dashboard', compact('quickStats', 'recentCalculations', 'calculatorUsage'));
    }

    /**
     * Generate quick stats for the dashboard.
     */
    private function getQuickStats($userId)
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        // Count calculations for each type this week
        $calculationsThisWeek = 
            CgpaCalculation::where('user_id', $userId)->whereBetween('created_at', [$startOfWeek, $endOfWeek])->count() +
            CurrencyConversion::where('user_id', $userId)->whereBetween('created_at', [$startOfWeek, $endOfWeek])->count() +
            PercentageCalculation::where('user_id', $userId)->whereBetween('created_at', [$startOfWeek, $endOfWeek])->count() +
            CalorieCalculation::where('user_id', $userId)->whereBetween('created_at', [$startOfWeek, $endOfWeek])->count() +
            ProfitLossCalculation::where('user_id', $userId)->whereBetween('created_at', [$startOfWeek, $endOfWeek])->count() +
            BmiCalculation::where('user_id', $userId)->whereBetween('created_at', [$startOfWeek, $endOfWeek])->count() +
            DateTimeCalculation::where('user_id', $userId)->whereBetween('created_at', [$startOfWeek, $endOfWeek])->count() +
            LoanCalculation::where('user_id', $userId)->whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();

        // Favorite calculator (based on total count)
        $counts = $this->getCalculatorCounts($userId);
        $favoriteCalculator = collect($counts)->sortDesc()->keys()->first() ?? 'N/A';

        // Estimated time saved (1.5 min per calculation)
        $totalCalculations = array_sum($counts);
        $timeSaved = round(($totalCalculations * 1.5) / 60, 1); // in hours

        return [
            'calculationsThisWeek' => $calculationsThisWeek,
            'favoriteCalculator' => $favoriteCalculator,
            'timeSaved' => $timeSaved,
            'totalCalculations' => $totalCalculations,
        ];
    }

    /**
     * Get calculator usage data for the circular chart.
     */
    private function getCalculatorUsage($userId)
    {
        $counts = $this->getCalculatorCounts($userId);
        $total = array_sum($counts);
        
        if ($total === 0) {
            return [
                'data' => [],
                'total' => 0
            ];
        }

        $usageData = [];
        $colors = [
            '#22C55E', // Green - CGPA
            '#3B82F6', // Blue - Currency
            '#8B5CF6', // Purple - Percentage
            '#EF4444', // Red - Calories
            '#F59E0B', // Amber - Profit/Loss
            '#06B6D4', // Cyan - BMI
            '#84CC16', // Lime - Date Time
            '#F97316', // Orange - Loan
        ];

        $i = 0;
        foreach ($counts as $calculator => $count) {
            if ($count > 0) {
                $percentage = round(($count / $total) * 100, 1);
                $usageData[] = [
                    'calculator' => $calculator,
                    'count' => $count,
                    'percentage' => $percentage,
                    'color' => $colors[$i % count($colors)]
                ];
            }
            $i++;
        }

        // Sort by count descending
        usort($usageData, function($a, $b) {
            return $b['count'] - $a['count'];
        });

        return [
            'data' => $usageData,
            'total' => $total
        ];
    }

    /**
     * Get counts for all calculators.
     */
    private function getCalculatorCounts($userId)
    {
        return [
            'CGPA' => CgpaCalculation::where('user_id', $userId)->count(),
            'Currency' => CurrencyConversion::where('user_id', $userId)->count(),
            'Percentage' => PercentageCalculation::where('user_id', $userId)->count(),
            'Calories' => CalorieCalculation::where('user_id', $userId)->count(),
            'Profit & Loss' => ProfitLossCalculation::where('user_id', $userId)->count(),
            'BMI' => BmiCalculation::where('user_id', $userId)->count(),
            'Date Time' => DateTimeCalculation::where('user_id', $userId)->count(),
            'Loan' => LoanCalculation::where('user_id', $userId)->count(),
        ];
    }

    /**
     * Get recent calculations from all calculators.
     */
    private function getRecentCalculations($userId)
    {
        $calculations = collect();

        // CGPA Calculations
        $calculations = $calculations->merge(
            CgpaCalculation::where('user_id', $userId)
                ->latest()->take(3)->get()
                ->map(fn($calc) => [
                    'type' => 'CGPA Calculator',
                    'name' => $calc->calculation_name,
                    'question' => 'GPA Calculation for ' . (is_array($calc->subjects) ? count($calc->subjects) : 0) . ' subjects',
                    'description' => 'Total Credits: ' . ($calc->total_credits ?? 'N/A'),
                    'result' => 'GPA: ' . ($calc->result ?? 'N/A'),
                    'date' => $calc->created_at,
                ])
        );

        // Currency Conversions
        $calculations = $calculations->merge(
            CurrencyConversion::where('user_id', $userId)
                ->latest()->take(3)->get()
                ->map(fn($conv) => [
                    'type' => 'Currency Converter',
                    'name' => $conv->from_currency . ' to ' . $conv->to_currency,
                    'question' => "Amount: {$conv->amount} {$conv->from_currency}",
                    'description' => "Exchange Rate: {$conv->rate}",
                    'result' => "{$conv->converted_amount} {$conv->to_currency}",
                    'date' => $conv->created_at,
                ])
        );

        // Percentage Calculations
        $calculations = $calculations->merge(
            PercentageCalculation::where('user_id', $userId)
                ->latest()->take(3)->get()
                ->map(fn($calc) => [
                    'type' => 'Percentage Calculator',
                    'name' => $calc->calculation_name,
                    'question' => $this->getPercentageQuestion($calc),
                    'description' => 'Percentage Calculation',
                    'result' => $calc->result,
                    'date' => $calc->created_at,
                ])
        );

        // Calorie Calculations
        $calculations = $calculations->merge(
            CalorieCalculation::where('user_id', $userId)
                ->latest()->take(3)->get()
                ->map(fn($calc) => [
                    'type' => 'Calorie Calculator',
                    'name' => $calc->calculation_name,
                    'question' => "Age: {$calc->age}, Gender: {$calc->gender}",
                    'description' => "Activity: " . ucfirst($calc->activity_level) . ", Goal: " . ucfirst($calc->goal),
                    'result' => "{$calc->calorie_target} cal/day",
                    'date' => $calc->created_at,
                ])
        );

        // Profit Loss Calculations
        $calculations = $calculations->merge(
            ProfitLossCalculation::where('user_id', $userId)
                ->latest()->take(3)->get()
                ->map(fn($calc) => [
                    'type' => 'Profit Loss Calculator',
                    'name' => $calc->calculation_name,
                    'question' => "Revenue: {$calc->revenue}, COGS: {$calc->cogs}",
                    'description' => "Operating Expenses: {$calc->operating_expenses}",
                    'result' => "Profit: {$calc->net_profit}",
                    'date' => $calc->created_at,
                ])
        );

        // BMI Calculations
        $calculations = $calculations->merge(
            BmiCalculation::where('user_id', $userId)
                ->latest()->take(3)->get()
                ->map(fn($calc) => [
                    'type' => 'BMI Calculator',
                    'name' => $calc->calculation_name,
                    'question' => "Height: {$calc->height} {$calc->height_unit}, Weight: {$calc->weight} {$calc->weight_unit}",
                    'description' => "Age: {$calc->age}, Gender: {$calc->gender}",
                    'result' => "BMI: {$calc->bmi} ({$calc->category})",
                    'date' => $calc->created_at,
                ])
        );

        // Date Time Calculations
        $calculations = $calculations->merge(
            DateTimeCalculation::where('user_id', $userId)
                ->latest()->take(3)->get()
                ->map(fn($calc) => [
                    'type' => 'Date Time Calculator',
                    'name' => $calc->calculation_name,
                    'question' => "Type: " . ucfirst(str_replace('_', ' ', $calc->calculation_type)),
                    'description' => 'Date/Time Calculation',
                    'result' => 'Completed',
                    'date' => $calc->created_at,
                ])
        );

        // Loan Calculations
        $calculations = $calculations->merge(
            LoanCalculation::where('user_id', $userId)
                ->latest()->take(3)->get()
                ->map(fn($calc) => [
                    'type' => 'Loan Calculator',
                    'name' => $calc->calculation_name,
                    'question' => "Amount: {$calc->loan_amount}, Rate: {$calc->interest_rate}%",
                    'description' => "Term: {$calc->loan_term} {$calc->term_type}",
                    'result' => "{$calc->monthly_payment}/month",
                    'date' => $calc->created_at,
                ])
        );

        return $calculations
            ->sortByDesc('date')
            ->take(5)
            ->values()
            ->toArray();
    }

    /**
     * Format percentage question text for dashboard table.
     */
    private function getPercentageQuestion($calc)
    {
        $inputs = $calc->inputs ?? [];
        $type = $calc->calculation_type ?? 'basic';

        return match ($type) {
            'basic' => "What is {$inputs['percentage']}% of {$inputs['number']}?",
            'increase' => "Increase {$inputs['number']} by {$inputs['percentage']}%",
            'decrease' => "Decrease {$inputs['number']} by {$inputs['percentage']}%",
            'percentage_of' => "{$inputs['part']} is what % of {$inputs['whole']}?",
            'find_number' => "{$inputs['part']} is {$inputs['percentage']}% of what number?",
            'percentage_change' => "Change from {$inputs['old_value']} to {$inputs['new_value']}",
            default => 'Percentage calculation',
        };
    }
}