<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configuracoes_site', function (Blueprint $table) {
            $table->id();
            $table->string('titulo_missao')->nullable();
            $table->text('paragrafo1')->nullable();
            $table->text('paragrafo2')->nullable();
            $table->string('imagem_hero')->nullable(); // armazena path em storage/app/public/...
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('configuracoes_site');
    }
};
