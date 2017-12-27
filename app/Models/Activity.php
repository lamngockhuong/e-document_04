<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'target_id',
        'target_type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function activiable()
    {
        return $this->morphTo();
    }
}
