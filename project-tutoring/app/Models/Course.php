<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['course', 'deskripsi', 'start_date', 'end_date', 'user_id'])]
class Course extends Model
{
    use HasFactory;

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
