<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProfitLossCalculation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'calculation_name',
        'revenue',
        'cogs',
        'operating_expenses',
        'other_income',
        'other_expenses',
        'gross_profit',
        'operating_profit',
        'net_profit',
        'profit_margin',
        'formula_used'
    ];

    protected $casts = [
        'revenue' => 'decimal:2',
        'cogs' => 'decimal:2',
        'operating_expenses' => 'decimal:2',
        'other_income' => 'decimal:2',
        'other_expenses' => 'decimal:2',
        'gross_profit' => 'decimal:2',
        'operating_profit' => 'decimal:2',
        'net_profit' => 'decimal:2',
        'profit_margin' => 'decimal:2'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function calculateProfitLoss(array $data): array
    {
        $revenue = floatval($data['revenue']);
        $cogs = floatval($data['cogs']);
        $operatingExpenses = floatval($data['operating_expenses']);
        $otherIncome = floatval($data['other_income']);
        $otherExpenses = floatval($data['other_expenses']);

        // Calculations
        $grossProfit = $revenue - $cogs;
        $operatingProfit = $grossProfit - $operatingExpenses;
        $netProfit = $operatingProfit + $otherIncome - $otherExpenses;
        $profitMargin = $revenue > 0 ? ($netProfit / $revenue) * 100 : 0;

        $formula = "Gross Profit = Revenue - COGS = {$revenue} - {$cogs} = {$grossProfit}\n";
        $formula .= "Operating Profit = Gross Profit - Operating Expenses = {$grossProfit} - {$operatingExpenses} = {$operatingProfit}\n";
        $formula .= "Net Profit = Operating Profit + Other Income - Other Expenses = {$operatingProfit} + {$otherIncome} - {$otherExpenses} = {$netProfit}\n";
        $formula .= "Profit Margin = (Net Profit ÷ Revenue) × 100 = ({$netProfit} ÷ {$revenue}) × 100 = {$profitMargin}%";

        return [
            'gross_profit' => round($grossProfit, 2),
            'operating_profit' => round($operatingProfit, 2),
            'net_profit' => round($netProfit, 2),
            'profit_margin' => round($profitMargin, 2),
            'formula' => $formula,
            'inputs' => $data
        ];
    }
}