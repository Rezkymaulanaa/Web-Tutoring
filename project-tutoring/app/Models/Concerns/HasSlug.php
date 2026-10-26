<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

/**
 * Mengisi kolom `slug` secara otomatis dari kolom sumber (misalnya nama course),
 * dan menambahkan akhiran -2, -3, ... jika slug yang sama sudah dipakai.
 */
trait HasSlug
{
    /**
     * Kolom yang dijadikan sumber slug.
     */
    abstract protected function slugSourceColumn(): string;

    protected static function bootHasSlug(): void
    {
        static::saving(function (self $model) {
            if ($model->slug && ! $model->isDirty($model->slugSourceColumn())) {
                return;
            }

            $model->slug = $model->uniqueSlug(Str::slug($model->{$model->slugSourceColumn()}) ?: 'item');
        });
    }

    /**
     * Data lain yang slug-nya tidak boleh sama. Bisa dipersempit, misalnya per course.
     */
    protected function slugUniquenessScope(): Builder
    {
        return static::query();
    }

    private function uniqueSlug(string $base): string
    {
        $slug = $base;

        for ($i = 2; $this->slugExists($slug); $i++) {
            $slug = "{$base}-{$i}";
        }

        return $slug;
    }

    private function slugExists(string $slug): bool
    {
        return $this->slugUniquenessScope()
            ->where('slug', $slug)
            ->when($this->exists, fn (Builder $query) => $query->whereKeyNot($this->getKey()))
            ->exists();
    }
}
