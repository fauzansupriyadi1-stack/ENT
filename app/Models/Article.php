<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'user_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'image',
        'status',
        'is_breaking',
        'views_count',
        'published_at',
    ];

    protected $casts = [
        'is_breaking' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function heroSlot()
    {
        return $this->hasOne(HeroSlot::class);
    }

    public function views()
    {
        return $this->hasMany(ArticleView::class);
    }
}
