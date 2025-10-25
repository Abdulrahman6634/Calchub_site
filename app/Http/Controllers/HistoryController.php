<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BmiCalculation;
use App\Models\CalorieCalculation;
use App\Models\CgpaCalculation;
use App\Models\CurrencyConversion;
use App\Models\DateTimeCalculation;
use App\Models\LoanCalculation;
use App\Models\PercentageCalculation;
use App\Models\ProfitLossCalculation;
use Carbon\Carbon;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Get quick stats
        $quickStats = $this->getQuickStats($user);
        
        // Get all calculations for search/filter
        $allCalculations = $this->getAllCalculations($user);
        
        // Apply search filter
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = strtolower($request->search);
            $allCalculations = array_filter($allCalculations, function($calc) use ($searchTerm) {
                return str_contains(strtolower($calc['name']), $searchTerm) ||
                       str_contains(strtolower($calc['type']), $searchTerm) ||
                       str_contains(strtolower($calc['question']), $searchTerm) ||
                       str_contains(strtolower($calc['description']), $searchTerm) ||
                       str_contains(strtolower($calc['result']), $searchTerm);
            });
        }
        
        // Apply type filter
        if ($request->has('type') && $request->type !== 'all') {
            $allCalculations = array_filter($allCalculations, function($calc) use ($request) {
                return str_contains(strtolower($calc['type']), strtolower($request->type));
            });
        }
        
        // Sort by date descending
        usort($allCalculations, function($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });
        
        // Pagination
        $perPage = $request->get('per_page', 10);
        $currentPage = $request->get('page', 1);
        $total = count($allCalculations);
        $offset = ($currentPage - 1) * $perPage;
        $paginatedCalculations = array_slice($allCalculations, $offset, $perPage);
        
        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $paginatedCalculations,
            $total,
            $perPage,
            $currentPage,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );
        
        // Get unique calculator types for filter dropdown
        $calculatorTypes = $this->getCalculatorTypes($user);
        
        return view('history.index', compact('quickStats', 'paginator', 'calculatorTypes'));
    }

    private function getQuickStats($user)
    {
        $oneWeekAgo = Carbon::now()->subWeek();
        
        // Total calculations this week
        $calculationsThisWeek = 
            BmiCalculation::where('user_id', $user->id)->where('created_at', '>=', $oneWeekAgo)->count() +
            CalorieCalculation::where('user_id', $user->id)->where('created_at', '>=', $oneWeekAgo)->count() +
            CgpaCalculation::where('user_id', $user->id)->where('created_at', '>=', $oneWeekAgo)->count() +
            CurrencyConversion::where('user_id', $user->id)->where('created_at', '>=', $oneWeekAgo)->count() +
            DateTimeCalculation::where('user_id', $user->id)->where('created_at', '>=', $oneWeekAgo)->count() +
            LoanCalculation::where('user_id', $user->id)->where('created_at', '>=', $oneWeekAgo)->count() +
            PercentageCalculation::where('user_id', $user->id)->where('created_at', '>=', $oneWeekAgo)->count() +
            ProfitLossCalculation::where('user_id', $user->id)->where('created_at', '>=', $oneWeekAgo)->count();

        // Most used calculator type
        $calculatorCounts = [];
        $models = [
            'BMI Calculator' => BmiCalculation::class,
            'Calorie Calculator' => CalorieCalculation::class,
            'CGPA Calculator' => CgpaCalculation::class,
            'Currency Converter' => CurrencyConversion::class,
            'Date Time Calculator' => DateTimeCalculation::class,
            'Loan Calculator' => LoanCalculation::class,
            'Percentage Calculator' => PercentageCalculation::class,
            'Profit Loss Calculator' => ProfitLossCalculation::class,
        ];

        foreach ($models as $name => $model) {
            $calculatorCounts[$name] = $model::where('user_id', $user->id)->count();
        }

        $favoriteCalculator = array_keys($calculatorCounts, max($calculatorCounts))[0] ?? 'None';

        // Estimated time saved (assuming 5 minutes per manual calculation)
        $totalCalculations = array_sum($calculatorCounts);
        $timeSaved = round(($totalCalculations * 5) / 60, 1); // Convert to hours

        return [
            'calculationsThisWeek' => $calculationsThisWeek,
            'favoriteCalculator' => $favoriteCalculator ?: 'None',
            'timeSaved' => $timeSaved,
            'totalCalculations' => $totalCalculations,
        ];
    }

    private function getCalculatorTypes($user)
    {
        $types = [];
        
        if (BmiCalculation::where('user_id', $user->id)->exists()) {
            $types[] = 'BMI Calculator';
        }
        if (CalorieCalculation::where('user_id', $user->id)->exists()) {
            $types[] = 'Calorie Calculator';
        }
        if (CgpaCalculation::where('user_id', $user->id)->exists()) {
            $types[] = 'CGPA Calculator';
        }
        if (CurrencyConversion::where('user_id', $user->id)->exists()) {
            $types[] = 'Currency Converter';
        }
        if (DateTimeCalculation::where('user_id', $user->id)->exists()) {
            $types[] = 'Date Time Calculator';
        }
        if (LoanCalculation::where('user_id', $user->id)->exists()) {
            $types[] = 'Loan Calculator';
        }
        if (PercentageCalculation::where('user_id', $user->id)->exists()) {
            $types[] = 'Percentage Calculator';
        }
        if (ProfitLossCalculation::where('user_id', $user->id)->exists()) {
            $types[] = 'Profit Loss Calculator';
        }
        
        return array_unique($types);
    }

    private function getAllCalculations($user)
    {
        $data = [];

        // BMI Calculations
        $bmiCalculations = BmiCalculation::where('user_id', $user->id)->get();
        foreach ($bmiCalculations as $calc) {
            $data[] = [
                'id' => 'bmi_' . $calc->id,
                'type' => 'BMI Calculator',
                'name' => $calc->calculation_name,
                'question' => "Height: {$calc->height} {$calc->height_unit}\nWeight: {$calc->weight} {$calc->weight_unit}",
                'description' => "Age: {$calc->age}, Gender: {$calc->gender}",
                'result' => "BMI: {$calc->bmi} ({$calc->category})",
                'date' => $calc->created_at->format('Y-m-d H:i:s'),
                'model' => 'BmiCalculation',
                'model_id' => $calc->id
            ];
        }

        // Calorie Calculations
        $calorieCalculations = CalorieCalculation::where('user_id', $user->id)->get();
        foreach ($calorieCalculations as $calc) {
            $data[] = [
                'id' => 'calorie_' . $calc->id,
                'type' => 'Calorie Calculator',
                'name' => $calc->calculation_name,
                'question' => "Age: {$calc->age}, Gender: {$calc->gender}",
                'description' => "Activity: " . ucfirst($calc->activity_level) . ", Goal: " . ucfirst($calc->goal),
                'result' => "{$calc->calorie_target} cal/day",
                'date' => $calc->created_at->format('Y-m-d H:i:s'),
                'model' => 'CalorieCalculation',
                'model_id' => $calc->id
            ];
        }

        // CGPA Calculations
        $cgpaCalculations = CgpaCalculation::where('user_id', $user->id)->get();
        foreach ($cgpaCalculations as $calc) {
            $data[] = [
                'id' => 'cgpa_' . $calc->id,
                'type' => 'CGPA Calculator',
                'name' => $calc->calculation_name,
                'question' => "Type: " . ucfirst(str_replace('_', ' ', $calc->calculation_type)),
                'description' => "Total Credits: {$calc->total_credits}",
                'result' => "GPA: {$calc->result}",
                'date' => $calc->created_at->format('Y-m-d H:i:s'),
                'model' => 'CgpaCalculation',
                'model_id' => $calc->id
            ];
        }

        // Currency Conversions
        $currencyConversions = CurrencyConversion::where('user_id', $user->id)->get();
        foreach ($currencyConversions as $calc) {
            $data[] = [
                'id' => 'currency_' . $calc->id,
                'type' => 'Currency Converter',
                'name' => "{$calc->from_currency} to {$calc->to_currency}",
                'question' => "Amount: {$calc->amount} {$calc->from_currency}",
                'description' => "Exchange Rate: {$calc->rate}",
                'result' => "{$calc->converted_amount} {$calc->to_currency}",
                'date' => $calc->created_at->format('Y-m-d H:i:s'),
                'model' => 'CurrencyConversion',
                'model_id' => $calc->id
            ];
        }

        // Date Time Calculations
        $dateTimeCalculations = DateTimeCalculation::where('user_id', $user->id)->get();
        foreach ($dateTimeCalculations as $calc) {
            $data[] = [
                'id' => 'datetime_' . $calc->id,
                'type' => 'Date Time Calculator',
                'name' => $calc->calculation_name,
                'question' => "Type: " . ucfirst(str_replace('_', ' ', $calc->calculation_type)),
                'description' => "Date/Time Calculation",
                'result' => "Completed",
                'date' => $calc->created_at->format('Y-m-d H:i:s'),
                'model' => 'DateTimeCalculation',
                'model_id' => $calc->id
            ];
        }

        // Loan Calculations
        $loanCalculations = LoanCalculation::where('user_id', $user->id)->get();
        foreach ($loanCalculations as $calc) {
            $data[] = [
                'id' => 'loan_' . $calc->id,
                'type' => 'Loan Calculator',
                'name' => $calc->calculation_name,
                'question' => "Amount: {$calc->loan_amount}, Rate: {$calc->interest_rate}%",
                'description' => "Term: {$calc->loan_term} {$calc->term_type}",
                'result' => "{$calc->monthly_payment}/month",
                'date' => $calc->created_at->format('Y-m-d H:i:s'),
                'model' => 'LoanCalculation',
                'model_id' => $calc->id
            ];
        }

        // Percentage Calculations
        $percentageCalculations = PercentageCalculation::where('user_id', $user->id)->get();
        foreach ($percentageCalculations as $calc) {
            $data[] = [
                'id' => 'percentage_' . $calc->id,
                'type' => 'Percentage Calculator',
                'name' => $calc->calculation_name,
                'question' => "Type: " . ucfirst(str_replace('_', ' ', $calc->calculation_type)),
                'description' => "Percentage Calculation",
                'result' => $calc->result,
                'date' => $calc->created_at->format('Y-m-d H:i:s'),
                'model' => 'PercentageCalculation',
                'model_id' => $calc->id
            ];
        }

        // Profit Loss Calculations
        $profitLossCalculations = ProfitLossCalculation::where('user_id', $user->id)->get();
        foreach ($profitLossCalculations as $calc) {
            $data[] = [
                'id' => 'profitloss_' . $calc->id,
                'type' => 'Profit Loss Calculator',
                'name' => $calc->calculation_name,
                'question' => "Revenue: {$calc->revenue}, COGS: {$calc->cogs}",
                'description' => "Operating Expenses: {$calc->operating_expenses}",
                'result' => "Profit: {$calc->net_profit}",
                'date' => $calc->created_at->format('Y-m-d H:i:s'),
                'model' => 'ProfitLossCalculation',
                'model_id' => $calc->id
            ];
        }

        return $data;
    }

    public function getHistoryData(Request $request)
    {
        $user = Auth::user();
        $calculations = $this->getAllCalculations($user);
        
        return response()->json(['data' => $calculations]);
    }

    public function deleteEntry(Request $request)
    {
        $request->validate([
            'model' => 'required|string',
            'id' => 'required|integer'
        ]);

        $user = Auth::user();
        $modelClass = "App\\Models\\" . $request->model;
        
        if (!class_exists($modelClass)) {
            return response()->json(['error' => 'Invalid model'], 400);
        }

        $entry = $modelClass::where('id', $request->id)
                           ->where('user_id', $user->id)
                           ->first();

        if (!$entry) {
            return response()->json(['error' => 'Entry not found'], 404);
        }

        $entry->delete();

        return response()->json(['success' => true, 'message' => 'Entry deleted successfully']);
    }

    public function deleteAll(Request $request)
    {
        $user = Auth::user();
        $model = $request->get('model');

        if ($model && $model !== 'all') {
            $modelClass = "App\\Models\\" . $model;
            if (class_exists($modelClass)) {
                $modelClass::where('user_id', $user->id)->delete();
            }
        } else {
            // Delete all calculations
            BmiCalculation::where('user_id', $user->id)->delete();
            CalorieCalculation::where('user_id', $user->id)->delete();
            CgpaCalculation::where('user_id', $user->id)->delete();
            CurrencyConversion::where('user_id', $user->id)->delete();
            DateTimeCalculation::where('user_id', $user->id)->delete();
            LoanCalculation::where('user_id', $user->id)->delete();
            PercentageCalculation::where('user_id', $user->id)->delete();
            ProfitLossCalculation::where('user_id', $user->id)->delete();
        }

        return response()->json(['success' => true, 'message' => 'All entries deleted successfully']);
    }
}