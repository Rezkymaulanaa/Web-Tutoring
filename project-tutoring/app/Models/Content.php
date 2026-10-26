<?php

namespace App\Models;

use App\Models\Concerns\HasSlug;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['course_id', 'user_id', 'title', 'content', 'youtube_link'])]
class Content extends Model
{
    use HasFactory, HasSlug;

    /**
     * Link YouTube yang diterima: youtu.be/ID, youtube.com/watch?v=ID, /embed/ID, dan /shorts/ID.
     * Grup pertama berisi ID video (11 karakter).
     */
    public const YOUTUBE_PATTERN = '~^https?://(?:www\.|m\.)?(?:youtu\.be/|youtube\.com/(?:watch\?(?:\S*&)?v=|embed/|shorts/))([A-Za-z0-9_-]{11})(?:[?&#/]\S*)?$~';

    /**
     * URL materi memakai slug, misalnya /content/matematika-dasar/bab-1-bilangan-bulat.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected function slugSourceColumn(): string
    {
        return 'title';
    }

    /**
     * Judul materi yang sama boleh dipakai di course yang berbeda.
     */
    protected function slugUniquenessScope(): Builder
    {
        return static::query()->where('course_id', $this->course_id);
    }

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
