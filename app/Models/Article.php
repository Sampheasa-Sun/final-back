<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Article extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'title',
        'content',
        'user_id',
        'categories',
        'status',
        'published_at',
        'image_url',  // add this line
    ];

    protected $casts = [
        'categories' => 'array',
        'published_at' => 'datetime',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title', 'content', 'status', 'published_at'])
            ->useLogName('article')
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Article \"{$this->title}\" was {$eventName}");
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // public function tags()
    // {
    //     return $this->belongsToMany(Tag::class, 'article_tags');
    // }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function scopeUnderReview($query)
    {
        return $query->where('status', 'Under_Review');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
    public function getImageUrlAttribute()
    {
        $value = $this->attributes['image_url'] ?? null;

        return $value ? asset('storage/' . $value) : null;
    }
}
