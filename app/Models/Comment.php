<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'article_id',
        'user_id',
        'nested_ID',
        'content',
    ];

    // 🔗 Each comment belongs to an article
    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    // 🔗 Each comment belongs to a user (author)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 🔗 Parent comment (if it's a reply)
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'nested_ID');
    }

    // 🔁 Replies to this comment
    public function replies()
    {
        return $this->hasMany(Comment::class, 'nested_ID');
    }
}
