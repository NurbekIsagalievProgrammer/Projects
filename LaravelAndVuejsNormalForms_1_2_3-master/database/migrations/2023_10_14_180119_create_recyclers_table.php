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
        Schema::create('recyclers', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('status'); 
            $table->string('system_id', 8); 
            $table->string('address', 255);
            $table->string('serial_number', 10); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recyclers');
    }
};
