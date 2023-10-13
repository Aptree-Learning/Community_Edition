<?php

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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->string('first_name', 255)->nullable();
            $table->string('last_name', 255)->nullable();
            $table->string('go_by_name', 255)->nullable();
            $table->string('gender', 10)->default('male');
            $table->date('date_of_birth')->nullable();
            $table->string('street_address_1')->nullable();
            $table->string('street_address_2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('home_phone_number')->nullable();
            $table->string('cell_phone_number')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->string('emergency_phone_number')->nullable();

            $table->string('company')->nullable();
            $table->string('plan')->nullable();
            $table->string('group')->nullable();

            $table->string('physician_name')->nullable();
            $table->string('physician_phone_number')->nullable();
            $table->string('physician_state')->nullable();
            $table->string('physician_city')->nullable();
            $table->string('physician_zip')->nullable();
            $table->string('physician_street')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name');
            $table->dropColumn(['first_name', 'last_name', 'go_by_name', 'gender', 'date_of_birth', 'street_address_1', 'street_address_2', 'city', 'state', 'zip_code', 'home_phone_number', 'cell_phone_number', 'emergency_contact', 'emergency_phone_number', 'company', 'plan', 'group', 'physician_name', 'physician_phone_number', 'physician_state', 'physician_city', 'physician_zip', 'physician_street']);
        });
    }
};
