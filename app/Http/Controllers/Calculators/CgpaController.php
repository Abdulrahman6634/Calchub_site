<?php

namespace App\Http\Controllers\Calculators;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CgpaCalculation;

class CgpaController extends Controller
{
    public function index()
    {
        $userCalculations = [];

        if (Auth::check()) {
            $userCalculations = Auth::user()->cgpaCalculations()
                ->latest()
                ->take(5)
                ->get();
        }

        return view('calculators.cgpa-calculator', compact('userCalculations'));
    }

    public function calculate(Request $request)
    {
        $request->validate([
            'calculation_type' => 'required|string|in:gpa,cgpa',
            'calculation_name' => 'nullable|string|max:255'
        ]);

        try {
            if ($request->calculation_type === 'gpa') {
                $request->validate([
                    'subjects' => 'required|array|min:1',
                    'subjects.*.name' => 'required|string|max:255',
                    'subjects.*.credits' => 'required|numeric|min:0.5|max:10',
                    'subjects.*.grade' => 'required|string|in:A+,A,A-,B+,B,B-,C+,C,C-,D+,D,F',
                ]);

                $calculation = CgpaCalculation::calculateGPA($request->subjects);
                $dataToSave = [
                    'subjects' => $request->subjects,
                    'total_credits' => $calculation['total_credits'],
                    'total_grade_points' => $calculation['total_grade_points'],
                ];
            } else {
                $request->validate([
                    'semesters' => 'required|array|min:1',
                    'semesters.*.name' => 'required|string|max:255',
                    'semesters.*.credits' => 'required|numeric|min:1|max:50',
                    'semesters.*.gpa' => 'required|numeric|min:0|max:4.0',
                ]);

                $calculation = CgpaCalculation::calculateCGPA($request->semesters);
                $dataToSave = [
                    'subjects' => $request->semesters, // Storing semesters in subjects field
                    'total_credits' => $calculation['total_credits'],
                    'total_grade_points' => $calculation['total_grade_points'],
                ];
            }

            if (Auth::check()) {
                CgpaCalculation::create([
                    'user_id' => Auth::id(),
                    'calculation_name' => $request->calculation_name ?? $this->getDefaultCalculationName($request->calculation_type),
                    'calculation_type' => $request->calculation_type,
                    'subjects' => $dataToSave['subjects'],
                    'total_credits' => $dataToSave['total_credits'],
                    'total_grade_points' => $dataToSave['total_grade_points'],
                    'result' => $calculation['result'],
                    'formula_used' => $calculation['formula'],
                ]);
            }

            return response()->json([
                'success' => true,
                'result' => $calculation['result'],
                'total_credits' => $calculation['total_credits'],
                'total_grade_points' => $calculation['total_grade_points'],
                'formula' => $calculation['formula'],
                'calculation_type' => $request->calculation_type,
                'data' => $request->calculation_type === 'gpa' ? $calculation['subjects'] : $calculation['semesters']
            ]);

        } catch (\Exception $e) {
            \Log::error('CGPA Calculation Error: ' . $e->getMessage());
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

        $calculations = Auth::user()->cgpaCalculations()
            ->latest()
            ->get()
            ->map(function ($calc) {
                return [
                    'id' => $calc->id,
                    'name' => $calc->calculation_name,
                    'type' => $calc->calculation_type,
                    'result' => $calc->result,
                    'total_credits' => $calc->total_credits,
                    'formula' => $calc->formula_used,
                    'date' => $calc->created_at->format('M j, Y g:i A'),
                    'items_count' => count($calc->subjects),
                ];
            });

        return response()->json(['calculations' => $calculations]);
    }

    public function destroy($id)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false], 401);
        }

        $calculation = Auth::user()->cgpaCalculations()->findOrFail($id);
        $calculation->delete();

        return response()->json(['success' => true]);
    }

    private function getDefaultCalculationName(string $type): string
    {
        return $type === 'gpa' ? 'GPA Calculation' : 'CGPA Calculation';
    }
}