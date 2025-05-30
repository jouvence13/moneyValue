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
        Schema::create('pairs', function (Blueprint $table) {
            $table->id();
           $table->string('devise_from_code', 3); // Les 3 lettres des codes ISO
            $table->string('devise_to_code', 3);
            $table->decimal('rate', 15, 8); // Pour les taux de change précis
            $table->unsignedBigInteger('conversion_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pairs');
    }
};
