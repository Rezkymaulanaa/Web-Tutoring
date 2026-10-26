<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('course');
        });

        Schema::table('contents', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('title');
        });

        // Isi slug untuk data yang sudah ada. Slug course unik secara global,
        // slug materi cukup unik di dalam course-nya.
        $this->fillSlugs('courses', 'course', fn () => DB::table('courses'));

        foreach (DB::table('contents')->distinct()->pluck('course_id') as $courseId) {
            $this->fillSlugs('contents', 'title', fn () => DB::table('contents')->where('course_id', $courseId));
        }

        Schema::table('courses', function (Blueprint $table) {
            $table->string('slug')->nullable(false)->change();
            $table->unique('slug');
        });

        Schema::table('contents', function (Blueprint $table) {
            $table->string('slug')->nullable(false)->change();
            $table->unique(['course_id', 'slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contents', function (Blueprint $table) {
            $table->dropUnique(['course_id', 'slug']);
            $table->dropColumn('slug');
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn('slug');
        });
    }

    private function fillSlugs(string $table, string $sourceColumn, Closure $scope): void
    {
        $used = [];

        foreach ($scope()->orderBy('id')->get(['id', $sourceColumn]) as $row) {
            $base = Str::slug($row->{$sourceColumn}) ?: 'item';
            $slug = $base;

            for ($i = 2; in_array($slug, $used, true); $i++) {
                $slug = "{$base}-{$i}";
            }

            $used[] = $slug;
            DB::table($table)->where('id', $row->id)->update(['slug' => $slug]);
        }
    }
};
