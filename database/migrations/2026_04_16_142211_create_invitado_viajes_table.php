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
        Schema::create('invitados_viaje', function (Blueprint $table) {
            $table->id('IdInvitacion');
            $table->unsignedBigInteger('IdViaje');
            $table->string('Correo');
            $table->timestamps();

            $table->foreign('IdViaje')->references('IdViaje')->on('Viajes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitados_viaje');
    }
};
