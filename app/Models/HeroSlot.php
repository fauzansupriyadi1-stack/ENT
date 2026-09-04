<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroSlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'slot_code',
        'article_id',
        'override_title',
        'is_manual',
    ];

    protected $casts = [
        'is_manual' => 'boolean',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
