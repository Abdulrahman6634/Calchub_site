<?php

namespace App\Http\Controllers\Calculators;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BmiCalculation;

class BmiCalculatorController extends Controller
{
    public function index()
    {
        $userCalculations = [];

        if (Auth::check()) {
            $userCalculations = Auth::user()->bmiCalculations()
                ->latest()
                ->take(5)
                ->get();
        }

        return view('calculators.bmi-calculator', compact('userCalculations'));
    }

    public function calculate(Request $request)
    {
        $request->validate([
            'height' => 'required|numeric|min:0.1|max:300',
            'height_unit' => 'required|string|in:cm,m,ft,in',
            'weight' => 'required|numeric|min:0.1|max:500',
            'weight_unit' => 'required|string|in:kg,lbs',
            'calculation_name' => 'nullable|string|max:255',
            'age' => 'nullable|integer|min:1|max:120',
            'gender' => 'nullable|string|in:male,female,other',
        ]);

        try {
            $calculation = BmiCalculation::calculateBMI(
                $request->height,
                $request->height_unit,
                $request->weight,
                $request->weight_unit,
                $request->age,
                $request->gender
            );

            $idealWeight = BmiCalculation::getIdealWeightRange($request->height, $request->height_unit);

            if (Auth::check()) {
                BmiCalculation::create([
                    'user_id' => Auth::id(),
                    'calculation_name' => $request->calculation_name ?? $this->getDefaultCalculationName(),
                    'height' => $request->height,
                    'height_unit' => $request->height_unit,
                    'weight' => $request->weight,
                    'weight_unit' => $request->weight_unit,
                    'bmi' => $calculation['bmi'],
                    'category' => $calculation['category'],
                    'health_advice' => $calculation['health_advice'],
                    'age' => $request->age,
                    'gender' => $request->gender,
                    'measurements' => [
                        'ideal_weight' => $idealWeight,
                        'height_in_meters' => $calculation['height_in_meters'],
                        'weight_in_kg' => $calculation['weight_in_kg'],
                    ],
                ]);
            }

            return response()->json([
                'success' => true,
                'bmi' => $calculation['bmi'],
                'category' => $calculation['category'],
                'health_advice' => $calculation['health_advice'],
                'ideal_weight' => $idealWeight,
                'calculation' => [
                    'height' => $request->height,
                    'height_unit' => $request->height_unit,
                    'weight' => $request->weight,
                    'weight_unit' => $request->weight_unit,
                    'age' => $request->age,
                    'gender' => $request->gender,
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('BMI Calculation Error: ' . $e->getMessage());
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

        $calculations = Auth::user()->bmiCalculations()
            ->latest()
            ->get()
            ->map(function ($calc) {
                return [
                    'id' => $calc->id,
                    'name' => $calc->calculation_name,
                    'bmi' => $calc->bmi,
                    'category' => $calc->category,
                    'height' => $calc->height . ' ' . $calc->height_unit,
                    'weight' => $calc->weight . ' ' . $calc->weight_unit,
                    'age' => $calc->age,
                    'gender' => $calc->gender,
                    'health_advice' => $calc->health_advice,
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

        $calculation = Auth::user()->bmiCalculations()->findOrFail($id);
        $calculation->delete();

        return response()->json(['success' => true]);
    }

    public function progress()
    {
        if (!Auth::check()) {
            return response()->json(['progress' => []]);
        }

        $progress = Auth::user()->bmiCalculations()
            ->orderBy('created_at')
            ->get(['bmi', 'weight', 'created_at'])
            ->map(function ($calc) {
                return [
                    'bmi' => $calc->bmi,
                    'weight' => $calc->weight,
                    'date' => $calc->created_at->format('Y-m-d'),
                    'month' => $calc->created_at->format('M Y'),
                ];
            });

        return response()->json(['progress' => $progress]);
    }

    private function getDefaultCalculationName(): string
    {
        return 'BMI Calculation - ' . now()->format('M j, Y');
    }
}