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
        Schema::create('konto', function (Blueprint $table) {
            $table->id('kontoid');
            $table->string('name');
        });

        Schema::create('kategorie', function (Blueprint $table) {
            $table->id('kategorieid');
            $table->string('bezeichnung');
        });

        Schema::create('kontobewegung', function (Blueprint $table) {
            $table->id('kontobewegungid');
            $table->unsignedBigInteger('konto_id');
            $table->foreign('konto_id')->references('kontoid')->on('konto');
            $table->unsignedBigInteger('kategorie_id');
            $table->foreign('kategorie_id')->references('kategorieid')->on('kategorie');
            $table->date('date');
            $table->boolean('fix');
            $table->double('geldwert');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kontobewegung');
        Schema::dropIfExists('kategorie');
        Schema::dropIfExists('konto');
    }
};
