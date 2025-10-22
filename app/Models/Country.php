<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $table = 'countries';

    protected $fillable = [
        'countryName',
        'currency',
        'symbol',
        'dateFormat',
        'iso_code',
        'capital',
        'timezone',
        'language',
        'language_code',
        'continent',
        'continent_code',
        'flag_emoji',
        'flag_unicode',
        'flag_img',
        'phone_code',
        'borders',
    ];
}
