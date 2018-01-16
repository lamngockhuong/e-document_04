<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'firstname',
        'lastname',
        'avatar',
        'free_download',
        'uploaded_count',
        'wallet',
        'status',
        'role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function favorites()
    {
        return $this->belongsToMany(Document::class, 'favorites');
    }

    /**
     * Bcrypt the user's password
     *
     * @param  $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function getAvatarUrlAttribute()
    {
        return asset(config('setting.avatar_folder') . '/' . $this->avatar);
    }

    public function getDefaultAvatarUrlAttribute()
    {
        return asset('templates/e-document/images/user_small.png');
    }

    public function getFullnameAttribute()
    {
        return $this->lastname . ' ' . $this->firstname;
    }
}
