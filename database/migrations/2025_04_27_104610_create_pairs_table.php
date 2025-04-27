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
            $table->foreignId('devise_from_id')->constrained('currencies')->onDelete('cascade');
            $table->foreignId('devise_to_id')->constrained('currencies')->onDelete('cascade');
            $table->decimal('rate', 15, 8); // pour les taux de change précis
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
