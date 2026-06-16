<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MacroTarget extends Model
{
    protected $fillable = [
        'user_id',
        'weight_kg',
        'height_cm',
        'age',
        'sex',
        'activity_level',
        'goal',
        'preset',
        'daily_calories',
        'protein_g',
        'carbs_g',
        'fat_g',
    ];

    protected $casts = [
        'weight_kg'      => 'decimal:2',
        'height_cm'      => 'decimal:2',
        'protein_g'      => 'decimal:2',
        'carbs_g'        => 'decimal:2',
        'fat_g'          => 'decimal:2',
        'age'            => 'integer',
        'daily_calories' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
