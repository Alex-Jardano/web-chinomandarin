<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lesson extends Model
{
    protected $fillable = ['title', 'slug', 'description', 'hsk_level', 'order', 'emoji'];

    public function words(): HasMany
    {
        return $this->hasMany(Word::class);
    }
}
