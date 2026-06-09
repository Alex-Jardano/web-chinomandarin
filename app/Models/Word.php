<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Word extends Model
{
    protected $fillable = [
        'lesson_id', 'character', 'pinyin', 'translation',
        'emoji', 'type', 'hsk_level', 'example_sentence', 'example_pinyin', 'example_translation',
    ];

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    public function progress(): HasOne
    {
        return $this->hasOne(Progress::class);
    }
}
