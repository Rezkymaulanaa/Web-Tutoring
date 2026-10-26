<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    public function isAdmin()
    {
        return $this->role === 'Admin';
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function contents()
    {
        return $this->hasMany(Content::class);
    }

    public function contentHistory()
    {
        return $this->belongsToMany(Content::class, 'content_history');
    }

    public function viewedContents()
    {
        return $this->belongsToMany(Content::class, 'content_history')->withTimestamps();
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }
}
