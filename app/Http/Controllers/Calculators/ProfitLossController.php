<?php

namespace App\Http\Controllers\Calculators;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ProfitLossCalculation;

class ProfitLossController extends Controller
{
    public function index()
    {
        $userCalculations = [];

        if (Auth::check()) {
            $userCalculations = Auth::user()->profitLossCalculations()
                ->latest()
                ->take(5)
                ->get();
        }

        return view('calculators.profit-loss-calculator', compact('userCalculations'));
    }

    public function calculate(Request $request)
    {
        $request->validate([
            'revenue' => 'required|numeric|min:0',
            'cogs' => 'required|numeric|min:0',
            'operating_expenses' => 'required|numeric|min:0',
            'other_income' => 'required|numeric|min:0',
            'other_expenses' => 'required|numeric|min:0',
            'calculation_name' => 'nullable|string|max:255'
        ]);

        try {
            $calculation = ProfitLossCalculation::calculateProfitLoss([
                'revenue' => $request->revenue,
                'cogs' => $request->cogs,
                'operating_expenses' => $request->operating_expenses,
                'other_income' => $request->other_income,
                'other_expenses' => $request->other_expenses,
            ]);

            if (Auth::check()) {
                ProfitLossCalculation::create([
                    'user_id' => Auth::id(),
                    'calculation_name' => $request->calculation_name ?? 'Profit & Loss Calculation',
                    'revenue' => $request->revenue,
                    'cogs' => $request->cogs,
                    'operating_expenses' => $request->operating_expenses,
                    'other_income' => $request->other_income,
                    'other_expenses' => $request->other_expenses,
                    'gross_profit' => $calculation['gross_profit'],
                    'operating_profit' => $calculation['operating_profit'],
                    'net_profit' => $calculation['net_profit'],
                    'profit_margin' => $calculation['profit_margin'],
                    'formula_used' => $calculation['formula'],
                ]);
            }

            return response()->json([
                'success' => true,
                'gross_profit' => $calculation['gross_profit'],
                'operating_profit' => $calculation['operating_profit'],
                'net_profit' => $calculation['net_profit'],
                'profit_margin' => $calculation['profit_margin'],
                'formula' => $calculation['formula'],
                'inputs' => $calculation['inputs']
            ]);

        } catch (\Exception $e) {
            \Log::error('Profit Loss Calculation Error: ' . $e->getMessage());
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

        $calculations = Auth::user()->profitLossCalculations()
            ->latest()
            ->get()
            ->map(function ($calc) {
                $status = $calc->net_profit >= 0 ? 'Profit' : 'Loss';
                $color = $calc->net_profit >= 0 ? 'text-green-600' : 'text-red-600';
                
                return [
                    'id' => $calc->id,
                    'name' => $calc->calculation_name,
                    'revenue' => $calc->revenue,
                    'net_profit' => $calc->net_profit,
                    'profit_margin' => $calc->profit_margin,
                    'status' => $status,
                    'color' => $color,
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

        $calculation = Auth::user()->profitLossCalculations()->findOrFail($id);
        $calculation->delete();

        return response()->json(['success' => true]);
    }
}