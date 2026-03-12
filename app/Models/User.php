<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'firstName',
        'lastName',
        'email',
        'password_hash',
        'status',
        'contributions',
        'knowledge_points',
        'helpful_votes',
        'profile_picture_url',
    ];


    protected $hidden = [
        'password_hash',
        'remember_token',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function articles()
    {
        return $this->hasMany(Article::class, 'user_id');
    }

    public function admin()
    {
        return $this->hasOne(Admin::class, 'user_id');
    }

    public function isAdmin()
    {
        return $this->admin !== null;
    }
    public function isBanned()
    {
        return $this->status === 'banned';
    }
    // In User.php
    public function getRouteKeyName()
    {
        return 'user_id';
    }
}
