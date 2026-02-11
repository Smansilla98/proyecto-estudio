<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ritmo_tambor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ritmo_id')->constrained('ritmos')->onDelete('cascade');
            $table->foreignId('tambor_id')->constrained('tambores')->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['ritmo_id', 'tambor_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ritmo_tambor');
    }
};

