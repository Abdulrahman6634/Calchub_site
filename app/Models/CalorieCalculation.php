<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CalorieCalculation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'calculation_name',
        'age',
        'gender',
        'weight',
        'height',
        'activity_level',
        'goal',
        'bmr',
        'tdee',
        'calorie_target',
        'formula_used'
    ];

    protected $casts = [
        'weight' => 'decimal:2',
        'height' => 'decimal:2',
        'bmr' => 'integer',
        'tdee' => 'integer',
        'calorie_target' => 'integer'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function calculateCalories(array $data): array
    {
        $age = intval($data['age']);
        $weight = floatval($data['weight']);
        $height = floatval($data['height']);
        $gender = $data['gender'];
        $activityLevel = $data['activity_level'];
        $goal = $data['goal'];

        // Calculate BMR (Basal Metabolic Rate) using Mifflin-St Jeor Equation
        if ($gender === 'male') {
            $bmr = (10 * $weight) + (6.25 * $height) - (5 * $age) + 5;
        } else {
            $bmr = (10 * $weight) + (6.25 * $height) - (5 * $age) - 161;
        }

        // Activity multipliers
        $activityMultipliers = [
            'sedentary' => 1.2,      // Little or no exercise
            'light' => 1.375,        // Light exercise 1-3 days/week
            'moderate' => 1.55,      // Moderate exercise 3-5 days/week
            'active' => 1.725,       // Hard exercise 6-7 days/week
            'very_active' => 1.9     // Very hard exercise & physical job
        ];

        // Calculate TDEE (Total Daily Energy Expenditure)
        $tdee = $bmr * $activityMultipliers[$activityLevel];

        // Adjust for goal
        $goalAdjustments = [
            'maintain' => 0,
            'lose' => -500,      // 500 calorie deficit for weight loss
            'gain' => 500        // 500 calorie surplus for weight gain
        ];

        $calorieTarget = $tdee + $goalAdjustments[$goal];

        $formula = "BMR Calculation:\n";
        $formula .= $gender === 'male' 
            ? "BMR = (10 × weight) + (6.25 × height) - (5 × age) + 5\n"
            : "BMR = (10 × weight) + (6.25 × height) - (5 × age) - 161\n";
        $formula .= "BMR = {$bmr} calories/day\n\n";
        $formula .= "TDEE Calculation:\n";
        $formula .= "TDEE = BMR × Activity Multiplier\n";
        $formula .= "TDEE = {$bmr} × {$activityMultipliers[$activityLevel]} = {$tdee} calories/day\n\n";
        $formula .= "Calorie Target:\n";
        $formula .= "Target = TDEE + Goal Adjustment\n";
        $formula .= "Target = {$tdee} + {$goalAdjustments[$goal]} = {$calorieTarget} calories/day";

        return [
            'bmr' => round($bmr),
            'tdee' => round($tdee),
            'calorie_target' => round($calorieTarget),
            'formula' => $formula,
            'inputs' => $data
        ];
    }
}