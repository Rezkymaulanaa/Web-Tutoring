<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function instructor() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function contents()
    {
        return $this->hasMany(Content::class);
    }
}
