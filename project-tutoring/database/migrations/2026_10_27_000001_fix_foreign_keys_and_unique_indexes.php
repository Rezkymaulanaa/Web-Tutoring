<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Riwayat belajar ikut terhapus saat user atau materinya dihapus.
        // Sebelumnya foreign key tanpa cascade membuat penghapusan gagal (error 500).
        Schema::table('content_history', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['content_id']);

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('content_id')->references('id')->on('contents')->cascadeOnDelete();
        });

        // Hapus baris riwayat ganda (sisakan yang terbaru) sebelum memasang unique index.
        $duplicates = DB::table('content_history')
            ->select('user_id', 'content_id', DB::raw('MAX(id) as keep_id'))
            ->groupBy('user_id', 'content_id')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        foreach ($duplicates as $duplicate) {
            DB::table('content_history')
                ->where('user_id', $duplicate->user_id)
                ->where('content_id', $duplicate->content_id)
                ->where('id', '!=', $duplicate->keep_id)
                ->delete();
        }

        Schema::table('content_history', function (Blueprint $table) {
            $table->unique(['user_id', 'content_id']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->unique('username');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['username']);
        });

        Schema::table('content_history', function (Blueprint $table) {
            $table->dropUnique(['user_id', 'content_id']);

            $table->dropForeign(['user_id']);
            $table->dropForeign(['content_id']);

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('content_id')->references('id')->on('contents');
        });
    }
};
