<?php

namespace App\Http\Controllers\Calculators;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DateTimeCalculation;

class DateTimeController extends Controller
{
    public function index()
    {
        $userCalculations = [];

        if (Auth::check()) {
            $userCalculations = Auth::user()->dateTimeCalculations()
                ->latest()
                ->take(5)
                ->get();
        }

        return view('calculators.date-time-calculator', compact('userCalculations'));
    }

    public function calculate(Request $request)
    {
        $request->validate([
            'calculation_type' => 'required|in:difference,add,subtract,business_days',
            'calculation_name' => 'nullable|string|max:255'
        ]);

        $validationRules = $this->getValidationRules($request->calculation_type);
        $request->validate($validationRules);

        try {
            $calculation = DateTimeCalculation::calculateDateTime([
                'calculation_type' => $request->calculation_type,
                'inputs' => $request->all()
            ]);

            if (Auth::check()) {
                DateTimeCalculation::create([
                    'user_id' => Auth::id(),
                    'calculation_name' => $request->calculation_name ?? $this->getDefaultCalculationName($request->calculation_type),
                    'calculation_type' => $request->calculation_type,
                    'inputs' => $request->all(),
                    'results' => $calculation['results'],
                    'formula_used' => $calculation['formula'],
                ]);
            }

            return response()->json([
                'success' => true,
                'results' => $calculation['results'],
                'formula' => $calculation['formula'],
                'calculation_type' => $request->calculation_type,
                'inputs' => $calculation['inputs']
            ]);

        } catch (\Exception $e) {
            \Log::error('DateTime Calculation Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Calculation failed. Please try again.'
            ], 500);
        }
    }

    public function history()
    {
        if (!Auth::check()) {
            return response()->json(['calculations' => []]);
        }

        $calculations = Auth::user()->dateTimeCalculations()
            ->latest()
            ->get()
            ->map(function ($calc) {
                $typeIcons = [
                    'difference' => '📅',
                    'add' => '➕',
                    'subtract' => '➖',
                    'business_days' => '💼'
                ];

                $typeNames = [
                    'difference' => 'Date Difference',
                    'add' => 'Date Addition',
                    'subtract' => 'Date Subtraction',
                    'business_days' => 'Business Days'
                ];

                return [
                    'id' => $calc->id,
                    'name' => $calc->calculation_name,
                    'type' => $calc->calculation_type,
                    'type_icon' => $typeIcons[$calc->calculation_type],
                    'type_name' => $typeNames[$calc->calculation_type],
                    'results' => $calc->results,
                    'date' => $calc->created_at->format('M j, Y g:i A'),
                ];
            });

        return response()->json(['calculations' => $calculations]);
    }

    public function destroy($id)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false], 401);
        }

        $calculation = Auth::user()->dateTimeCalculations()->findOrFail($id);
        $calculation->delete();

        return response()->json(['success' => true]);
    }

    private function getValidationRules(string $type): array
    {
        $rules = [
            'calculation_type' => 'required|in:difference,add,subtract,business_days'
        ];

        switch ($type) {
            case 'difference':
                $rules['start_date'] = 'required|date';
                $rules['end_date'] = 'required|date|after_or_equal:start_date';
                $rules['start_time'] = 'required|date_format:H:i';
                $rules['end_time'] = 'required|date_format:H:i';
                break;

            case 'add':
            case 'subtract':
                $rules['base_date'] = 'required|date';
                $rules['base_time'] = 'required|date_format:H:i';
                $rules['add_years'] = 'nullable|integer|min:0';
                $rules['add_months'] = 'nullable|integer|min:0';
                $rules['add_days'] = 'nullable|integer|min:0';
                $rules['add_hours'] = 'nullable|integer|min:0';
                $rules['add_minutes'] = 'nullable|integer|min:0';
                $rules['add_seconds'] = 'nullable|integer|min:0';
                $rules['subtract_years'] = 'nullable|integer|min:0';
                $rules['subtract_months'] = 'nullable|integer|min:0';
                $rules['subtract_days'] = 'nullable|integer|min:0';
                $rules['subtract_hours'] = 'nullable|integer|min:0';
                $rules['subtract_minutes'] = 'nullable|integer|min:0';
                $rules['subtract_seconds'] = 'nullable|integer|min:0';
                break;

            case 'business_days':
                $rules['start_date'] = 'required|date';
                $rules['end_date'] = 'required|date|after_or_equal:start_date';
                break;
        }

        return $rules;
    }

    private function getDefaultCalculationName(string $type): string
    {
        $names = [
            'difference' => 'Date Difference',
            'add' => 'Date Addition',
            'subtract' => 'Date Subtraction',
            'business_days' => 'Business Days'
        ];

        return $names[$type] ?? 'Date Time Calculation';
    }
}