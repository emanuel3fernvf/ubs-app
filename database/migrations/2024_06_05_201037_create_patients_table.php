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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('cpf');
            $table->date('birth_date');
            $table->string('phone');
            $table->enum('status', ['active', 'inactive']);

            $table->string('address_street');
            $table->string('address_number');
            $table->string('address_complement');
            $table->string('address_neighborhood');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
