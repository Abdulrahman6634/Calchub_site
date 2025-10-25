<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'password_reset_token',
        'password_reset_token_expires_at',
        'password_reset_email_sent_at',
        'password_reset_attempts',
        'password_reset_locked_until',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'password_reset_token', // Hide the reset token as well
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'password_reset_token_expires_at' => 'datetime',
            'password_reset_email_sent_at' => 'datetime',
            'password_reset_locked_until' => 'datetime',
        ];
    }

    /**
     * Get the CGPA calculations for the user.
     */
    public function cgpaCalculations(): HasMany
    {
        return $this->hasMany(CgpaCalculation::class);
    }

    /**
     * Get the percentage calculations for the user.
     */
    public function percentageCalculations(): HasMany
    {
        return $this->hasMany(PercentageCalculation::class);
    }

    /**
     * Get the currency conversions for the user.
     */
    public function currencyConversions(): HasMany
    {
        return $this->hasMany(CurrencyConversion::class);
    }

    /**
     * Get the profit and loss calculations for the user.
     */
    public function profitLossCalculations(): HasMany
    {
        return $this->hasMany(ProfitLossCalculation::class);
    }

    /**
     * Get the calorie calculations for the user.
     */
    public function calorieCalculations(): HasMany
    {
        return $this->hasMany(CalorieCalculation::class);
    }

    /**
     * Get the date time calculations for the user.
     */
    public function dateTimeCalculations(): HasMany
    {
        return $this->hasMany(DateTimeCalculation::class);
    }

    /**
     * Get the BMI calculations for the user.
     */
    public function bmiCalculations(): HasMany
    {
        return $this->hasMany(BmiCalculation::class);
    }

    /**
     * Get the loan calculations for the user.
     */
    public function loanCalculations(): HasMany
    {
        return $this->hasMany(LoanCalculation::class);
    }

    /**
     * Check if the user is currently locked from password reset attempts.
     */
    public function isPasswordResetLocked(): bool
    {
        return $this->password_reset_locked_until && now()->lt($this->password_reset_locked_until);
    }

    /**
     * Check if the password reset token is expired.
     */
    public function isPasswordResetTokenExpired(): bool
    {
        return !$this->password_reset_token_expires_at || now()->gt($this->password_reset_token_expires_at);
    }

    /**
     * Clear all password reset fields.
     */
    public function clearPasswordResetFields(): void
    {
        $this->update([
            'password_reset_token' => null,
            'password_reset_token_expires_at' => null,
            'password_reset_email_sent_at' => null,
            'password_reset_attempts' => 0,
            'password_reset_locked_until' => null,
        ]);
    }
}