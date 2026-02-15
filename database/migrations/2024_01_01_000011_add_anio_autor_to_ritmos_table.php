<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ritmos', function (Blueprint $table) {
            $table->integer('anio')->nullable()->after('nombre');
            $table->string('autor')->nullable()->after('anio');
            $table->string('tipo')->nullable()->after('autor')->comment('Autor, Ritmo Popular, Adaptación');
            $table->boolean('opcional')->default(false)->after('tipo');
            $table->string('anio_opcional')->nullable()->after('opcional')->comment('Años alternativos para ritmos opcionales');
        });
    }

    public function down(): void
    {
        Schema::table('ritmos', function (Blueprint $table) {
            $table->dropColumn(['anio', 'autor', 'tipo', 'opcional', 'anio_opcional']);
        });
    }
};

