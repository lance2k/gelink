<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LinkVisit extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'ip_address',
        'user_agent',
        'visited_at',
    ];
    protected $casts = [
        'visited_at' => 'datetime',
    ];

    public function link(): BelongsTo
    {
       return $this->belongsTo(Link::class);
    }

}
