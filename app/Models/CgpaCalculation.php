<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CgpaCalculation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'calculation_name',
        'calculation_type',
        'subjects',
        'total_credits',
        'total_grade_points',
        'result',
        'formula_used'
    ];

    protected $casts = [
        'subjects' => 'array'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function calculateGPA(array $subjects): array
    {
        $totalCredits = 0;
        $totalGradePoints = 0;
        $gradePoints = [
            'A+' => 4.0, 'A' => 4.0, 'A-' => 3.7,
            'B+' => 3.3, 'B' => 3.0, 'B-' => 2.7,
            'C+' => 2.3, 'C' => 2.0, 'C-' => 1.7,
            'D+' => 1.3, 'D' => 1.0, 'F' => 0.0
        ];

        foreach ($subjects as $subject) {
            $credits = floatval($subject['credits']);
            $gradePoint = $gradePoints[$subject['grade']] ?? 0.0;
            
            $totalCredits += $credits;
            $totalGradePoints += $credits * $gradePoint;
        }

        $gpa = $totalCredits > 0 ? $totalGradePoints / $totalCredits : 0;

        return [
            'result' => round($gpa, 2),
            'total_credits' => $totalCredits,
            'total_grade_points' => $totalGradePoints,
            'formula' => "GPA = Total Grade Points ÷ Total Credits = {$totalGradePoints} ÷ {$totalCredits}",
            'subjects' => $subjects
        ];
    }

    public static function calculateCGPA(array $semesterGPAs): array
    {
        $totalCredits = 0;
        $totalGradePoints = 0;

        foreach ($semesterGPAs as $semester) {
            $credits = floatval($semester['credits']);
            $gpa = floatval($semester['gpa']);
            
            $totalCredits += $credits;
            $totalGradePoints += $credits * $gpa;
        }

        $cgpa = $totalCredits > 0 ? $totalGradePoints / $totalCredits : 0;

        return [
            'result' => round($cgpa, 2),
            'total_credits' => $totalCredits,
            'total_grade_points' => $totalGradePoints,
            'formula' => "CGPA = Total Grade Points ÷ Total Credits = {$totalGradePoints} ÷ {$totalCredits}",
            'semesters' => $semesterGPAs
        ];
    }
}