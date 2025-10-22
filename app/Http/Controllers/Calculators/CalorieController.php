<?php

namespace App\Http\Controllers\Calculators;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CalorieCalculation;

class CalorieController extends Controller
{
    public function index()
    {
        $userCalculations = [];

        if (Auth::check()) {
            $userCalculations = Auth::user()->calorieCalculations()
                ->latest()
                ->take(5)
                ->get();
        }

        return view('calculators.calorie-calculator', compact('userCalculations'));
    }

    public function calculate(Request $request)
    {
        $request->validate([
            'age' => 'required|integer|min:15|max:100',
            'gender' => 'required|in:male,female',
            'weight' => 'required|numeric|min:30|max:300',
            'height' => 'required|numeric|min:100|max:250',
            'activity_level' => 'required|in:sedentary,light,moderate,active,very_active',
            'goal' => 'required|in:maintain,lose,gain',
            'calculation_name' => 'nullable|string|max:255'
        ]);

        try {
            $calculation = CalorieCalculation::calculateCalories([
                'age' => $request->age,
                'gender' => $request->gender,
                'weight' => $request->weight,
                'height' => $request->height,
                'activity_level' => $request->activity_level,
                'goal' => $request->goal,
            ]);

            if (Auth::check()) {
                CalorieCalculation::create([
                    'user_id' => Auth::id(),
                    'calculation_name' => $request->calculation_name ?? 'Calorie Calculation',
                    'age' => $request->age,
                    'gender' => $request->gender,
                    'weight' => $request->weight,
                    'height' => $request->height,
                    'activity_level' => $request->activity_level,
                    'goal' => $request->goal,
                    'bmr' => $calculation['bmr'],
                    'tdee' => $calculation['tdee'],
                    'calorie_target' => $calculation['calorie_target'],
                    'formula_used' => $calculation['formula'],
                ]);
            }

            return response()->json([
                'success' => true,
                'bmr' => $calculation['bmr'],
                'tdee' => $calculation['tdee'],
                'calorie_target' => $calculation['calorie_target'],
                'formula' => $calculation['formula'],
                'inputs' => $calculation['inputs']
            ]);

        } catch (\Exception $e) {
            \Log::error('Calorie Calculation Error: ' . $e->getMessage());
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

        $calculations = Auth::user()->calorieCalculations()
            ->latest()
            ->get()
            ->map(function ($calc) {
                $goalIcons = [
                    'maintain' => '⚖️',
                    'lose' => '📉',
                    'gain' => '📈'
                ];

                $activityLevels = [
                    'sedentary' => 'Sedentary',
                    'light' => 'Light Activity',
                    'moderate' => 'Moderate Activity',
                    'active' => 'Active',
                    'very_active' => 'Very Active'
                ];

                return [
                    'id' => $calc->id,
                    'name' => $calc->calculation_name,
                    'calorie_target' => $calc->calorie_target,
                    'goal' => $calc->goal,
                    'goal_icon' => $goalIcons[$calc->goal],
                    'activity_level' => $activityLevels[$calc->activity_level],
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

        $calculation = Auth::user()->calorieCalculations()->findOrFail($id);
        $calculation->delete();

        return response()->json(['success' => true]);
    }
}