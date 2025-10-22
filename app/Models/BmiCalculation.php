<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BmiCalculation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'calculation_name',
        'height',
        'height_unit',
        'weight',
        'weight_unit',
        'bmi',
        'category',
        'health_advice',
        'age',
        'gender',
        'measurements',
    ];

    protected $casts = [
        'measurements' => 'array',
        'height' => 'decimal:2',
        'weight' => 'decimal:2',
        'bmi' => 'decimal:2',
        'age' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Calculate BMI based on height and weight
     */
    public static function calculateBMI(float $height, string $heightUnit, float $weight, string $weightUnit, ?int $age = null, ?string $gender = null): array
    {
        // Convert to metric system for calculation
        $heightInMeters = self::convertToMeters($height, $heightUnit);
        $weightInKg = self::convertToKg($weight, $weightUnit);

        // Calculate BMI
        $bmi = $weightInKg / ($heightInMeters * $heightInMeters);
        $bmi = round($bmi, 2);

        // Determine category and health advice
        $category = self::getBMICategory($bmi);
        $healthAdvice = self::getHealthAdvice($bmi, $age, $gender);

        return [
            'bmi' => $bmi,
            'category' => $category,
            'health_advice' => $healthAdvice,
            'height_in_meters' => $heightInMeters,
            'weight_in_kg' => $weightInKg,
        ];
    }

    /**
     * Convert height to meters
     */
    private static function convertToMeters(float $height, string $unit): float
    {
        return match ($unit) {
            'cm' => $height / 100,
            'm' => $height,
            'ft' => $height * 0.3048,
            'in' => $height * 0.0254,
            default => $height,
        };
    }

    /**
     * Convert weight to kg
     */
    private static function convertToKg(float $weight, string $unit): float
    {
        return match ($unit) {
            'kg' => $weight,
            'lbs' => $weight * 0.453592,
            default => $weight,
        };
    }

    /**
     * Get BMI category
     */
    private static function getBMICategory(float $bmi): string
    {
        if ($bmi < 18.5) return 'Underweight';
        if ($bmi < 25) return 'Normal weight';
        if ($bmi < 30) return 'Overweight';
        if ($bmi < 35) return 'Obesity Class I';
        if ($bmi < 40) return 'Obesity Class II';
        return 'Obesity Class III';
    }

    /**
     * Get health advice based on BMI
     */
    private static function getHealthAdvice(float $bmi, ?int $age, ?string $gender): string
    {
        $advice = '';

        if ($bmi < 18.5) {
            $advice = "You're underweight. Consider consulting a nutritionist for a balanced diet plan to gain weight healthily.";
        } elseif ($bmi < 25) {
            $advice = "Congratulations! You're in the healthy weight range. Maintain your current lifestyle with regular exercise and balanced nutrition.";
        } elseif ($bmi < 30) {
            $advice = "You're overweight. Consider increasing physical activity and adjusting your diet. Small changes can make a big difference.";
        } else {
            $advice = "You're in the obesity range. We recommend consulting with a healthcare provider for personalized guidance on weight management.";
        }

        // Age-specific advice
        if ($age && $age > 50) {
            $advice .= " As you're over 50, focus on maintaining muscle mass through strength training and adequate protein intake.";
        }

        return $advice;
    }

    /**
     * Calculate ideal weight range
     */
    public static function getIdealWeightRange(float $height, string $heightUnit): array
    {
        $heightInMeters = self::convertToMeters($height, $heightUnit);
        
        $minWeight = 18.5 * ($heightInMeters * $heightInMeters);
        $maxWeight = 24.9 * ($heightInMeters * $heightInMeters);

        return [
            'min_kg' => round($minWeight, 1),
            'max_kg' => round($maxWeight, 1),
            'min_lbs' => round($minWeight * 2.20462, 1),
            'max_lbs' => round($maxWeight * 2.20462, 1),
        ];
    }
}