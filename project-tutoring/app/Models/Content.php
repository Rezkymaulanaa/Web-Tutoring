<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['course_id', 'user_id', 'title', 'content', 'youtube_link'])]
class Content extends Model
{
    use HasFactory;

    /**
     * Link YouTube yang diterima: youtu.be/ID, youtube.com/watch?v=ID, /embed/ID, dan /shorts/ID.
     * Grup pertama berisi ID video (11 karakter).
     */
    public const YOUTUBE_PATTERN = '~^https?://(?:www\.|m\.)?(?:youtu\.be/|youtube\.com/(?:watch\?(?:\S*&)?v=|embed/|shorts/))([A-Za-z0-9_-]{11})(?:[?&#/]\S*)?$~';

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * URL embed YouTube yang aman dipakai sebagai src iframe, atau null jika link tidak valid.
     */
    protected function youtubeEmbedUrl(): Attribute
    {
        return Attribute::get(function () {
            if (! $this->youtube_link || ! preg_match(self::YOUTUBE_PATTERN, $this->youtube_link, $matches)) {
                return null;
            }

            return 'https://www.youtube.com/embed/'.$matches[1];
        });
    }
}
