<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('module_items', function (Blueprint $table) {
            $table->after('video', function() use($table) {
                $table->json('video_response')->nullable();
                $table->string('video_id')->nullable();
                $table->string('video_format')->nullable();
                $table->string('video_embed_url')->nullable();
                $table->string('video_source')->nullable();
                $table->string('video_player')->nullable();
                $table->string('video_thumbnail')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('module_items', function (Blueprint $table) {
            $table->dropColumn('video_response');
            $table->dropColumn('video_id');
            $table->dropColumn('video_format');
            $table->dropColumn('video_embed_url');
            $table->dropColumn('video_source');
            $table->dropColumn('video_player');
            $table->dropColumn('video_thumbnail');
        });
    }
};
