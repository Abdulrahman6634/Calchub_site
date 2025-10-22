<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PercentageCalculation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'calculation_name',
        'calculation_type',
        'inputs',
        'result',
        'formula_used'
    ];

    protected $casts = [
        'inputs' => 'array'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function calculatePercentage(array $data): array
    {
        $type = $data['calculation_type'];
        $inputs = $data['inputs'];

        switch ($type) {
            case 'basic':
                // What is X% of Y?
                $result = ($inputs['percentage'] / 100) * $inputs['number'];
                $formula = "{$inputs['percentage']}% of {$inputs['number']} = ({$inputs['percentage']} ÷ 100) × {$inputs['number']}";
                break;

            case 'increase':
                // Increase Y by X%
                $increase = ($inputs['percentage'] / 100) * $inputs['number'];
                $result = $inputs['number'] + $increase;
                $formula = "{$inputs['number']} increased by {$inputs['percentage']}% = {$inputs['number']} + ({$inputs['percentage']} ÷ 100) × {$inputs['number']}";
                break;

            case 'decrease':
                // Decrease Y by X%
                $decrease = ($inputs['percentage'] / 100) * $inputs['number'];
                $result = $inputs['number'] - $decrease;
                $formula = "{$inputs['number']} decreased by {$inputs['percentage']}% = {$inputs['number']} - ({$inputs['percentage']} ÷ 100) × {$inputs['number']}";
                break;

            case 'percentage_of':
                // X is what % of Y?
                $result = ($inputs['part'] / $inputs['whole']) * 100;
                $formula = "{$inputs['part']} is what % of {$inputs['whole']} = ({$inputs['part']} ÷ {$inputs['whole']}) × 100";
                break;

            case 'find_number':
                // X is Y% of what number?
                $result = ($inputs['part'] / $inputs['percentage']) * 100;
                $formula = "{$inputs['part']} is {$inputs['percentage']}% of what number? = ({$inputs['part']} ÷ {$inputs['percentage']}) × 100";
                break;

            case 'percentage_change':
                // Percentage change from X to Y
                $change = $inputs['new_value'] - $inputs['old_value'];
                $result = ($change / $inputs['old_value']) * 100;
                $formula = "Percentage change from {$inputs['old_value']} to {$inputs['new_value']} = (({$inputs['new_value']} - {$inputs['old_value']}) ÷ {$inputs['old_value']}) × 100";
                break;

            default:
                throw new \InvalidArgumentException('Invalid calculation type');
        }

        return [
            'result' => round($result, 2),
            'formula' => $formula,
            'calculation_type' => $type,
            'inputs' => $inputs
        ];
    }
}