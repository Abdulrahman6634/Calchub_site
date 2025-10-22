<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoanCalculation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'calculation_name',
        'loan_amount',
        'interest_rate',
        'loan_term',
        'term_type',
        'payment_frequency',
        'monthly_payment',
        'total_interest',
        'total_payment',
        'amortization_schedule',
        'calculation_details',
    ];

    protected $casts = [
        'amortization_schedule' => 'array',
        'calculation_details' => 'array',
        'loan_amount' => 'decimal:2',
        'interest_rate' => 'decimal:2',
        'monthly_payment' => 'decimal:2',
        'total_interest' => 'decimal:2',
        'total_payment' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Calculate loan payment and amortization schedule
     */
    public static function calculateLoan(array $data): array
    {
        $loanAmount = (float) $data['loan_amount'];
        $annualInterestRate = (float) $data['interest_rate'];
        $loanTerm = (int) $data['loan_term'];
        $termType = $data['term_type'];
        $paymentFrequency = $data['payment_frequency'];

        // Convert term to months if in years
        if ($termType === 'years') {
            $loanTermMonths = $loanTerm * 12;
        } else {
            $loanTermMonths = $loanTerm;
        }

        // Calculate payments per year based on frequency
        $paymentsPerYear = self::getPaymentsPerYear($paymentFrequency);
        
        // Calculate monthly interest rate
        $monthlyInterestRate = ($annualInterestRate / 100) / 12;

        // Calculate monthly payment using the formula: P = [r*PV] / [1 - (1 + r)^-n]
        $monthlyPayment = self::calculateMonthlyPayment($loanAmount, $monthlyInterestRate, $loanTermMonths);

        // Calculate total payment and interest
        $totalPayment = $monthlyPayment * $loanTermMonths;
        $totalInterest = $totalPayment - $loanAmount;

        // Generate amortization schedule
        $amortizationSchedule = self::generateAmortizationSchedule(
            $loanAmount, 
            $monthlyInterestRate, 
            $loanTermMonths, 
            $monthlyPayment
        );

        return [
            'monthly_payment' => round($monthlyPayment, 2),
            'total_interest' => round($totalInterest, 2),
            'total_payment' => round($totalPayment, 2),
            'loan_term_months' => $loanTermMonths,
            'amortization_schedule' => $amortizationSchedule,
            'calculation_details' => [
                'principal' => $loanAmount,
                'annual_interest_rate' => $annualInterestRate,
                'monthly_interest_rate' => $monthlyInterestRate * 100,
                'payments_per_year' => $paymentsPerYear,
            ]
        ];
    }

    /**
     * Calculate monthly payment
     */
    private static function calculateMonthlyPayment(float $principal, float $monthlyRate, int $termMonths): float
    {
        if ($monthlyRate == 0) {
            return $principal / $termMonths;
        }

        return ($principal * $monthlyRate * pow(1 + $monthlyRate, $termMonths)) 
               / (pow(1 + $monthlyRate, $termMonths) - 1);
    }

    /**
     * Generate amortization schedule
     */
    private static function generateAmortizationSchedule(float $principal, float $monthlyRate, int $termMonths, float $monthlyPayment): array
    {
        $schedule = [];
        $balance = $principal;

        for ($month = 1; $month <= $termMonths; $month++) {
            $interestPayment = $balance * $monthlyRate;
            $principalPayment = $monthlyPayment - $interestPayment;
            
            // Adjust for the last payment
            if ($month === $termMonths) {
                $principalPayment = $balance;
                $monthlyPayment = $principalPayment + $interestPayment;
                $balance = 0;
            } else {
                $balance -= $principalPayment;
            }

            $schedule[] = [
                'month' => $month,
                'payment' => round($monthlyPayment, 2),
                'principal' => round($principalPayment, 2),
                'interest' => round($interestPayment, 2),
                'balance' => round($balance, 2),
            ];
        }

        return $schedule;
    }

    /**
     * Get payments per year based on frequency
     */
    private static function getPaymentsPerYear(string $frequency): int
    {
        return match($frequency) {
            'weekly' => 52,
            'bi-weekly' => 26,
            'monthly' => 12,
            default => 12,
        };
    }

    /**
     * Calculate extra payment impact
     */
    public static function calculateExtraPaymentImpact(array $data, float $extraPayment): array
    {
        $calculation = self::calculateLoan($data);
        $schedule = $calculation['amortization_schedule'];
        
        $newSchedule = [];
        $balance = $data['loan_amount'];
        $monthlyRate = ($data['interest_rate'] / 100) / 12;
        $regularPayment = $calculation['monthly_payment'];
        $totalPayment = $regularPayment + $extraPayment;

        $month = 1;
        $monthsSaved = 0;
        $interestSaved = 0;

        while ($balance > 0) {
            $interestPayment = $balance * $monthlyRate;
            $principalPayment = $totalPayment - $interestPayment;

            if ($principalPayment > $balance) {
                $principalPayment = $balance;
                $totalPayment = $principalPayment + $interestPayment;
            }

            $balance -= $principalPayment;

            $newSchedule[] = [
                'month' => $month,
                'payment' => round($totalPayment, 2),
                'principal' => round($principalPayment, 2),
                'interest' => round($interestPayment, 2),
                'balance' => round($balance, 2),
                'extra_payment' => $extraPayment,
            ];

            $month++;

            if ($month > 1000) break; // Safety break
        }

        $originalMonths = count($schedule);
        $newMonths = count($newSchedule);
        $monthsSaved = $originalMonths - $newMonths;
        $interestSaved = $calculation['total_interest'] - array_sum(array_column($newSchedule, 'interest'));

        return [
            'original_schedule' => $schedule,
            'new_schedule' => $newSchedule,
            'months_saved' => $monthsSaved,
            'interest_saved' => round($interestSaved, 2),
            'new_total_interest' => round(array_sum(array_column($newSchedule, 'interest')), 2),
        ];
    }
}