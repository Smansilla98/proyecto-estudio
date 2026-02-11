<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('partituras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ritmo_id')->constrained('ritmos')->onDelete('cascade');
            $table->string('archivo_pdf')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partituras');
    }
};

