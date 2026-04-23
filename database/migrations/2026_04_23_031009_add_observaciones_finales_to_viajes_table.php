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
        Schema::table('Viajes', function (Blueprint $table) {
            $table->text('ObservacionesFinales')->nullable()->after('Notas');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('Viajes', function (Blueprint $table) {
            //
        });
    }
};
