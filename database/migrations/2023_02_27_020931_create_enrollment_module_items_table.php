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
        Schema::create('enrollment_module_items', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->unsignedBigInteger('enrollment_id');
            $table->unsignedBigInteger('enrollment_module_id');
            $table->unsignedBigInteger('module_item_id');
            $table->timestamp('completed_at')->nullable();

            # Quiz
            $table->unsignedBigInteger('answer_id')->nullable();
            $table->boolean('is_correct')->nullable();

            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enrollment_module_items');
    }
};
