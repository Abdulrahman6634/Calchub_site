<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CurrencyConversion extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'from_currency',
        'to_currency',
        'amount',
        'converted_amount',
        'rate',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'converted_amount' => 'decimal:2',
        'rate' => 'decimal:6'
    ];

    /**
     * Get the user that owns the currency conversion.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}