<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class DateTimeCalculation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'calculation_name',
        'calculation_type',
        'inputs',
        'results',
        'formula_used'
    ];

    protected $casts = [
        'inputs' => 'array',
        'results' => 'array'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function calculateDateTime(array $data): array
    {
        $type = $data['calculation_type'];
        $inputs = $data['inputs'];

        switch ($type) {
            case 'difference':
                return self::calculateDateDifference($inputs);
            case 'add':
                return self::calculateDateAdd($inputs);
            case 'subtract':
                return self::calculateDateSubtract($inputs);
            case 'business_days':
                return self::calculateBusinessDays($inputs);
            default:
                throw new \InvalidArgumentException('Invalid calculation type');
        }
    }

    private static function calculateDateDifference(array $inputs): array
    {
        $startDate = Carbon::parse($inputs['start_date'] . ' ' . $inputs['start_time']);
        $endDate = Carbon::parse($inputs['end_date'] . ' ' . $inputs['end_time']);

        $diff = $startDate->diff($endDate);

        $totalDays = $startDate->diffInDays($endDate);
        $totalHours = $startDate->diffInHours($endDate);
        $totalMinutes = $startDate->diffInMinutes($endDate);
        $totalSeconds = $startDate->diffInSeconds($endDate);
        $totalWeeks = floor($totalDays / 7);
        $remainingDays = $totalDays % 7;

        $formula = "Date Difference Calculation:\n";
        $formula .= "From: {$startDate->format('Y-m-d H:i:s')}\n";
        $formula .= "To: {$endDate->format('Y-m-d H:i:s')}\n";
        $formula .= "Total Difference:\n";
        $formula .= "- Years: {$diff->y}\n";
        $formula .= "- Months: {$diff->m}\n";
        $formula .= "- Days: {$diff->d}\n";
        $formula .= "- Hours: {$diff->h}\n";
        $formula .= "- Minutes: {$diff->i}\n";
        $formula .= "- Seconds: {$diff->s}";

        return [
            'results' => [
                'years' => $diff->y,
                'months' => $diff->m,
                'days' => $diff->d,
                'hours' => $diff->h,
                'minutes' => $diff->i,
                'seconds' => $diff->s,
                'total_days' => $totalDays,
                'total_hours' => $totalHours,
                'total_minutes' => $totalMinutes,
                'total_seconds' => $totalSeconds,
                'total_weeks' => $totalWeeks,
                'remaining_days' => $remainingDays,
                'start_date' => $startDate->format('Y-m-d H:i:s'),
                'end_date' => $endDate->format('Y-m-d H:i:s'),
            ],
            'formula' => $formula,
            'inputs' => $inputs
        ];
    }

    private static function calculateDateAdd(array $inputs): array
    {
        $baseDate = Carbon::parse($inputs['base_date'] . ' ' . $inputs['base_time']);
        $resultDate = $baseDate->copy();

        // Add time components
        $resultDate->addYears($inputs['add_years'] ?? 0)
                  ->addMonths($inputs['add_months'] ?? 0)
                  ->addDays($inputs['add_days'] ?? 0)
                  ->addHours($inputs['add_hours'] ?? 0)
                  ->addMinutes($inputs['add_minutes'] ?? 0)
                  ->addSeconds($inputs['add_seconds'] ?? 0);

        $formula = "Date Addition:\n";
        $formula .= "Base Date: {$baseDate->format('Y-m-d H:i:s')}\n";
        $formula .= "Added:\n";
        if ($inputs['add_years'] ?? 0) $formula .= "- Years: {$inputs['add_years']}\n";
        if ($inputs['add_months'] ?? 0) $formula .= "- Months: {$inputs['add_months']}\n";
        if ($inputs['add_days'] ?? 0) $formula .= "- Days: {$inputs['add_days']}\n";
        if ($inputs['add_hours'] ?? 0) $formula .= "- Hours: {$inputs['add_hours']}\n";
        if ($inputs['add_minutes'] ?? 0) $formula .= "- Minutes: {$inputs['add_minutes']}\n";
        if ($inputs['add_seconds'] ?? 0) $formula .= "- Seconds: {$inputs['add_seconds']}\n";
        $formula .= "Result: {$resultDate->format('Y-m-d H:i:s')}";

        return [
            'results' => [
                'original_date' => $baseDate->format('Y-m-d H:i:s'),
                'result_date' => $resultDate->format('Y-m-d H:i:s'),
                'added_components' => [
                    'years' => $inputs['add_years'] ?? 0,
                    'months' => $inputs['add_months'] ?? 0,
                    'days' => $inputs['add_days'] ?? 0,
                    'hours' => $inputs['add_hours'] ?? 0,
                    'minutes' => $inputs['add_minutes'] ?? 0,
                    'seconds' => $inputs['add_seconds'] ?? 0,
                ]
            ],
            'formula' => $formula,
            'inputs' => $inputs
        ];
    }

    private static function calculateDateSubtract(array $inputs): array
    {
        $baseDate = Carbon::parse($inputs['base_date'] . ' ' . $inputs['base_time']);
        $resultDate = $baseDate->copy();

        // Subtract time components
        $resultDate->subYears($inputs['subtract_years'] ?? 0)
                  ->subMonths($inputs['subtract_months'] ?? 0)
                  ->subDays($inputs['subtract_days'] ?? 0)
                  ->subHours($inputs['subtract_hours'] ?? 0)
                  ->subMinutes($inputs['subtract_minutes'] ?? 0)
                  ->subSeconds($inputs['subtract_seconds'] ?? 0);

        $formula = "Date Subtraction:\n";
        $formula .= "Base Date: {$baseDate->format('Y-m-d H:i:s')}\n";
        $formula .= "Subtracted:\n";
        if ($inputs['subtract_years'] ?? 0) $formula .= "- Years: {$inputs['subtract_years']}\n";
        if ($inputs['subtract_months'] ?? 0) $formula .= "- Months: {$inputs['subtract_months']}\n";
        if ($inputs['subtract_days'] ?? 0) $formula .= "- Days: {$inputs['subtract_days']}\n";
        if ($inputs['subtract_hours'] ?? 0) $formula .= "- Hours: {$inputs['subtract_hours']}\n";
        if ($inputs['subtract_minutes'] ?? 0) $formula .= "- Minutes: {$inputs['subtract_minutes']}\n";
        if ($inputs['subtract_seconds'] ?? 0) $formula .= "- Seconds: {$inputs['subtract_seconds']}\n";
        $formula .= "Result: {$resultDate->format('Y-m-d H:i:s')}";

        return [
            'results' => [
                'original_date' => $baseDate->format('Y-m-d H:i:s'),
                'result_date' => $resultDate->format('Y-m-d H:i:s'),
                'subtracted_components' => [
                    'years' => $inputs['subtract_years'] ?? 0,
                    'months' => $inputs['subtract_months'] ?? 0,
                    'days' => $inputs['subtract_days'] ?? 0,
                    'hours' => $inputs['subtract_hours'] ?? 0,
                    'minutes' => $inputs['subtract_minutes'] ?? 0,
                    'seconds' => $inputs['subtract_seconds'] ?? 0,
                ]
            ],
            'formula' => $formula,
            'inputs' => $inputs
        ];
    }

    private static function calculateBusinessDays(array $inputs): array
    {
        $startDate = Carbon::parse($inputs['start_date']);
        $endDate = Carbon::parse($inputs['end_date']);
        
        $businessDays = 0;
        $currentDate = $startDate->copy();
        
        while ($currentDate->lte($endDate)) {
            if (!$currentDate->isWeekend()) {
                $businessDays++;
            }
            $currentDate->addDay();
        }

        $totalDays = $startDate->diffInDays($endDate) + 1;
        $weekendDays = $totalDays - $businessDays;

        $formula = "Business Days Calculation:\n";
        $formula .= "From: {$startDate->format('Y-m-d')}\n";
        $formula .= "To: {$endDate->format('Y-m-d')}\n";
        $formula .= "Total Days: {$totalDays}\n";
        $formula .= "Business Days: {$businessDays}\n";
        $formula .= "Weekend Days: {$weekendDays}";

        return [
            'results' => [
                'business_days' => $businessDays,
                'total_days' => $totalDays,
                'weekend_days' => $weekendDays,
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
            ],
            'formula' => $formula,
            'inputs' => $inputs
        ];
    }
}