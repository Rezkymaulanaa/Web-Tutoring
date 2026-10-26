<?php

namespace App\Models;

use App\Models\Concerns\HasSlug;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['course', 'deskripsi', 'start_date', 'end_date', 'user_id'])]
class Course extends Model
{
    use HasFactory, HasSlug;

    /**
     * URL course memakai slug, misalnya /courses/matematika-dasar.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected function slugSourceColumn(): string
    {
        return 'course';
    }

    /**
     * Guru pengajar course ini.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Materi diurutkan sesuai urutan dibuat. Tanpa ORDER BY, database bebas memakai urutan index
     * (misalnya urut abjad slug), sehingga "Materi 1, 2, 3" bisa tertukar.
     */
    public function contents(): HasMany
    {
        return $this->hasMany(Content::class)->orderBy('id');
    }

    /**
     * Cari berdasarkan nama course atau nama pengajarnya.
     */
    public function scopeSearch(Builder $query, ?string $term): void
    {
        $query->when($term, fn (Builder $query) => $query->where(function (Builder $query) use ($term) {
            $query->where('course', 'like', "%{$term}%")
                ->orWhereHas('user', fn (Builder $query) => $query->where('nama', 'like', "%{$term}%"));
        }));
    }

    /**
     * Hitung jumlah materi dan materi yang sudah dibuka user dalam satu query (tanpa N+1).
     */
    public function scopeWithProgressFor(Builder $query, ?User $user): void
    {
        $query->withCount('contents')->when($user, fn (Builder $query) => $query->withCount([
            'contents as viewed_contents_count' => fn (Builder $query) => $query->whereHas(
                'viewers', fn (Builder $query) => $query->whereKey($user->id),
            ),
        ]));
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    /**
     * Persentase materi yang sudah dibuka. Butuh scope withProgressFor().
     */
    protected function progress(): Attribute
    {
        return Attribute::get(fn () => $this->contents_count > 0
            ? (int) round(($this->viewed_contents_count ?? 0) / $this->contents_count * 100)
            : 0);
    }
}
