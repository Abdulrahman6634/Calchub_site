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

        return view('dashboard', compact('quickStats', 'recentCalculations'));
    }

    /**
     * Generate quick stats for the dashboard.
     */
    private function getQuickStats($userId)
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $cgpaCount = CgpaCalculation::where('user_id', $userId)
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->count();

        $currencyCount = CurrencyConversion::where('user_id', $userId)
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->count();

        $percentageCount = PercentageCalculation::where('user_id', $userId)
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->count();

        $calorieCount = CalorieCalculation::where('user_id', $userId)
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->count();

        $profitLossCount = ProfitLossCalculation::where('user_id', $userId)
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->count();

        $totalCalculationsThisWeek = $cgpaCount + $currencyCount + $percentageCount + $calorieCount + $profitLossCount;

        // Favorite calculator (based on total count)
        $counts = [
            'CGPA' => CgpaCalculation::where('user_id', $userId)->count(),
            'Currency' => CurrencyConversion::where('user_id', $userId)->count(),
            'Percentage' => PercentageCalculation::where('user_id', $userId)->count(),
            'Calories' => CalorieCalculation::where('user_id', $userId)->count(),
            'Profit & Loss' => ProfitLossCalculation::where('user_id', $userId)->count(),
        ];
        $favoriteCalculator = collect($counts)->sortDesc()->keys()->first() ?? 'N/A';

        // Estimated time saved (1.5 min per calculation)
        $totalCalculations = array_sum($counts);
        $timeSaved = round(($totalCalculations * 1.5) / 60, 1); // in hours

        return [
            'calculationsThisWeek' => $totalCalculationsThisWeek,
            'favoriteCalculator' => $favoriteCalculator,
            'timeSaved' => $timeSaved,
        ];
    }

    /**
     * Get recent calculations from all calculators.
     */
    private function getRecentCalculations($userId)
    {
        $cgpa = CgpaCalculation::where('user_id', $userId)
            ->latest()->take(5)->get()
            ->map(fn($calc) => [
                'type' => 'CGPA',
                'question' => 'GPA Calculation for ' . count($calc->subjects) . ' subjects',
                'description' => 'Calculated cumulative grade point average based on subjects and credits.',
                'result' => $calc->result,
                'date' => $calc->created_at,
            ]);

        $currency = CurrencyConversion::where('user_id', $userId)
            ->latest()->take(5)->get()
            ->map(fn($conv) => [
                'type' => 'Currency',
                'question' => "{$conv->amount} {$conv->from_currency} → {$conv->to_currency}",
                'description' => 'Converted currency value using the latest exchange rate.',
                'result' => "{$conv->converted_amount} {$conv->to_currency}",
                'date' => $conv->created_at,
            ]);

        $percentage = PercentageCalculation::where('user_id', $userId)
            ->latest()->take(5)->get()
            ->map(fn($calc) => [
                'type' => 'Percentage',
                'question' => $this->getPercentageQuestion($calc),
                'description' => 'Performed percentage-based increase, decrease, or ratio calculation.',
                'result' => "{$calc->result}",
                'date' => $calc->created_at,
            ]);

        $calories = CalorieCalculation::where('user_id', $userId)
            ->latest()->take(5)->get()
            ->map(fn($calc) => [
                'type' => 'Calories',
                'question' => "{$calc->gender} | Age: {$calc->age}, Weight: {$calc->weight}kg, Height: {$calc->height}cm | Activity: {$calc->activity_level} | Goal: {$calc->goal}",
                'description' => 'Estimated daily calorie needs based on BMR and activity level.',
                'result' => "{$calc->calorie_target} kcal/day",
                'date' => $calc->created_at,
            ]);

        $profitLoss = ProfitLossCalculation::where('user_id', $userId)
            ->latest()->take(5)->get()
            ->map(fn($calc) => [
                'type' => 'Profit & Loss',
                'question' => "Revenue: {$calc->revenue}, COGS: {$calc->cogs}, OpEx: {$calc->operating_expenses}",
                'description' => 'Calculated business profit, loss, and margin from revenue and expenses.',
                'result' => "{$calc->net_profit} ({$calc->profit_margin}%)",
                'date' => $calc->created_at,
            ]);

        return collect()
            ->merge($cgpa)
            ->merge($currency)
            ->merge($percentage)
            ->merge($calories)
            ->merge($profitLoss)
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
