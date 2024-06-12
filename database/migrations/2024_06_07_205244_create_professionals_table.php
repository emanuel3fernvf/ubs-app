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
        Schema::create('specialties', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->enum('status', ['active', 'inactive']);

            $table->timestamps();
        });

        Schema::create('professionals', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('crm', 50);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('specialty_id');
            $table->enum('status', ['active', 'inactive']);

            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('specialty_id')->references('id')->on('specialties');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professionals');
    }
};
