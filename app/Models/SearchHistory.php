<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SearchHistory extends Model
{
    use HasFactory;

    protected $fillable = ['city', 'country', 'weather_data'];

    protected $casts = [
        'weather_data' => 'array',
    ];
}
