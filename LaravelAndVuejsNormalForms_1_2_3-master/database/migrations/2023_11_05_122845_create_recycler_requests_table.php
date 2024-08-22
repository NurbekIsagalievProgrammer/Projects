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
        Schema::create('recycler_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('status')->default(0);
            $table->foreignId('recycler_id')->constrained('recyclers');
            $table->foreignId('theme_id')->constrained('recycler_themes');
            $table->foreignId('solution_id')->nullable()->constrained('recycler_solutions');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recycler_requests');
    }
};
