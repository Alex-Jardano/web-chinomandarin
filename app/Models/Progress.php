<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Progress extends Model
{
    protected $fillable = ['word_id', 'correct_count', 'wrong_count', 'last_reviewed_at', 'next_review_at'];

    protected $casts = [
        'last_reviewed_at' => 'datetime',
        'next_review_at' => 'datetime',
    ];

    public function word(): BelongsTo
    {
        return $this->belongsTo(Word::class);
    }
}
