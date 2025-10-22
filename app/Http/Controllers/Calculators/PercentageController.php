<?php

namespace App\Http\Controllers\Calculators;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PercentageCalculation;

class PercentageController extends Controller
{
    public function index()
    {
        $userCalculations = [];

        if (Auth::check()) {
            $userCalculations = Auth::user()->percentageCalculations()
                ->latest()
                ->take(5)
                ->get();
        }

        return view('calculators.percentage-calculator', compact('userCalculations'));
    }

    public function calculate(Request $request)
    {
        $request->validate([
            'calculation_type' => 'required|string|in:basic,increase,decrease,percentage_of,find_number,percentage_change',
            'inputs' => 'required|array',
            'calculation_name' => 'nullable|string|max:255'
        ]);

        // Validate inputs based on calculation type
        $validationRules = $this->getValidationRules($request->calculation_type);
        $request->validate($validationRules);

        try {
            $calculation = PercentageCalculation::calculatePercentage([
                'calculation_type' => $request->calculation_type,
                'inputs' => $request->inputs
            ]);

            if (Auth::check()) {
                PercentageCalculation::create([
                    'user_id' => Auth::id(),
                    'calculation_name' => $request->calculation_name ?? $this->getDefaultCalculationName($request->calculation_type),
                    'calculation_type' => $request->calculation_type,
                    'inputs' => $request->inputs,
                    'result' => $calculation['result'],
                    'formula_used' => $calculation['formula'],
                ]);
            }

            return response()->json([
                'success' => true,
                'result' => $calculation['result'],
                'formula' => $calculation['formula'],
                'calculation_type' => $calculation['calculation_type'],
                'inputs' => $calculation['inputs']
            ]);

        } catch (\Exception $e) {
            \Log::error('Percentage Calculation Error: ' . $e->getMessage());
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

        $calculations = Auth::user()->percentageCalculations()
            ->latest()
            ->get()
            ->map(function ($calc) {
                return [
                    'id' => $calc->id,
                    'name' => $calc->calculation_name,
                    'type' => $calc->calculation_type,
                    'result' => $calc->result,
                    'formula' => $calc->formula_used,
                    'date' => $calc->created_at->format('M j, Y g:i A'),
                    'inputs' => $calc->inputs,
                ];
            });

        return response()->json(['calculations' => $calculations]);
    }

    public function destroy($id)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false], 401);
        }

        $calculation = Auth::user()->percentageCalculations()->findOrFail($id);
        $calculation->delete();

        return response()->json(['success' => true]);
    }

    private function getValidationRules(string $type): array
    {
        $rules = [
            'inputs' => 'required|array'
        ];

        switch ($type) {
            case 'basic':
                $rules['inputs.percentage'] = 'required|numeric|min:0';
                $rules['inputs.number'] = 'required|numeric';
                break;

            case 'increase':
            case 'decrease':
                $rules['inputs.percentage'] = 'required|numeric|min:0';
                $rules['inputs.number'] = 'required|numeric';
                break;

            case 'percentage_of':
                $rules['inputs.part'] = 'required|numeric';
                $rules['inputs.whole'] = 'required|numeric|min:0.01';
                break;

            case 'find_number':
                $rules['inputs.part'] = 'required|numeric';
                $rules['inputs.percentage'] = 'required|numeric|min:0.01';
                break;

            case 'percentage_change':
                $rules['inputs.old_value'] = 'required|numeric';
                $rules['inputs.new_value'] = 'required|numeric';
                break;
        }

        return $rules;
    }

    private function getDefaultCalculationName(string $type): string
    {
        $names = [
            'basic' => 'Percentage Calculation',
            'increase' => 'Percentage Increase',
            'decrease' => 'Percentage Decrease',
            'percentage_of' => 'Find Percentage',
            'find_number' => 'Find Whole Number',
            'percentage_change' => 'Percentage Change'
        ];

        return $names[$type] ?? 'Percentage Calculation';
    }
}