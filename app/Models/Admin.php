<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable, LogsActivity;

    protected $table = 'admins';

    protected $fillable = [
        'firstName',
        'lastName',
        'email',
        'password_hash',
        'photo',
    ];

    protected $hidden = [
        'password_hash',
        'remember_token',
    ];

    // Use password_hash as the password field
    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    // Activity log settings
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['firstName', 'lastName', 'email'])
            ->useLogName('admin')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
