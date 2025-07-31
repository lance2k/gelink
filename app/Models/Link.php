<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Link extends Model
{
    protected $fillable = [
        'short_code',
        'long_url',
        'is_custom'
    ];
    protected $casts = [
        'is_custom' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function visits(): HasMany
    {
        return $this->hasMany(LinkVisit::class);
    }
}
