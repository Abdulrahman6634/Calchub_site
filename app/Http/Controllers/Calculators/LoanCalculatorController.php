<?php

namespace App\Http\Controllers\Calculators;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LoanCalculation;

class LoanCalculatorController extends Controller
{
    public function index()
    {
        $userCalculations = [];

        if (Auth::check()) {
            $userCalculations = Auth::user()->loanCalculations()
                ->latest()
                ->take(5)
                ->get();
        }

        return view('calculators.loan-calculator', compact('userCalculations'));
    }

    public function calculate(Request $request)
    {
        $request->validate([
            'loan_amount' => 'required|numeric|min:1|max:10000000',
            'interest_rate' => 'required|numeric|min:0.01|max:100',
            'loan_term' => 'required|integer|min:1|max:600',
            'term_type' => 'required|string|in:months,years',
            'payment_frequency' => 'required|string|in:monthly,bi-weekly,weekly',
            'calculation_name' => 'nullable|string|max:255',
        ]);

        try {
            $calculation = LoanCalculation::calculateLoan($request->all());

            if (Auth::check()) {
                LoanCalculation::create([
                    'user_id' => Auth::id(),
                    'calculation_name' => $request->calculation_name ?? $this->getDefaultCalculationName(),
                    'loan_amount' => $request->loan_amount,
                    'interest_rate' => $request->interest_rate,
                    'loan_term' => $request->loan_term,
                    'term_type' => $request->term_type,
                    'payment_frequency' => $request->payment_frequency,
                    'monthly_payment' => $calculation['monthly_payment'],
                    'total_interest' => $calculation['total_interest'],
                    'total_payment' => $calculation['total_payment'],
                    'amortization_schedule' => $calculation['amortization_schedule'],
                    'calculation_details' => $calculation['calculation_details'],
                ]);
            }

            return response()->json([
                'success' => true,
                'monthly_payment' => $calculation['monthly_payment'],
                'total_interest' => $calculation['total_interest'],
                'total_payment' => $calculation['total_payment'],
                'loan_term_months' => $calculation['loan_term_months'],
                'amortization_schedule' => $calculation['amortization_schedule'],
                'calculation_details' => $calculation['calculation_details'],
            ]);

        } catch (\Exception $e) {
            \Log::error('Loan Calculation Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Calculation failed. Please try again.'
            ], 500);
        }
    }

    public function calculateExtraPayment(Request $request)
    {
        $request->validate([
            'loan_amount' => 'required|numeric|min:1',
            'interest_rate' => 'required|numeric|min:0.01',
            'loan_term' => 'required|integer|min:1',
            'term_type' => 'required|string|in:months,years',
            'payment_frequency' => 'required|string|in:monthly,bi-weekly,weekly',
            'extra_payment' => 'required|numeric|min:0',
        ]);

        try {
            $data = $request->all();
            $extraPayment = (float) $request->extra_payment;

            $impact = LoanCalculation::calculateExtraPaymentImpact($data, $extraPayment);

            return response()->json([
                'success' => true,
                'months_saved' => $impact['months_saved'],
                'interest_saved' => $impact['interest_saved'],
                'new_total_interest' => $impact['new_total_interest'],
                'new_schedule' => $impact['new_schedule'],
                'original_schedule' => $impact['original_schedule'],
            ]);

        } catch (\Exception $e) {
            \Log::error('Extra Payment Calculation Error: ' . $e->getMessage());
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

        $calculations = Auth::user()->loanCalculations()
            ->latest()
            ->get()
            ->map(function ($calc) {
                return [
                    'id' => $calc->id,
                    'name' => $calc->calculation_name,
                    'loan_amount' => $calc->loan_amount,
                    'interest_rate' => $calc->interest_rate,
                    'loan_term' => $calc->loan_term . ' ' . $calc->term_type,
                    'monthly_payment' => $calc->monthly_payment,
                    'total_interest' => $calc->total_interest,
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

        $calculation = Auth::user()->loanCalculations()->findOrFail($id);
        $calculation->delete();

        return response()->json(['success' => true]);
    }

    private function getDefaultCalculationName(): string
    {
        return 'Loan Calculation - ' . now()->format('M j, Y');
    }
}