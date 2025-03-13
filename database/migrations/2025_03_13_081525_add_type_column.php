<?php

use App\Models\AnimeWatchHistory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('anime_watch_histories', function (Blueprint $table) {
            $table->string('type')->nullable();
        });

        AnimeWatchHistory::where('type', null)->update(['type' => 'anime']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('anime_watch_histories', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
