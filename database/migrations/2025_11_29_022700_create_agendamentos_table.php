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
        Schema::create('agendamentos', function (Blueprint $table) {
            $table->id();
            $table->json('encrypted_nome');
            $table->json('encrypted_telefone');
            $table->json('encrypted_email')->nullable();
            $table->json('encrypted_data_visita');
            $table->json('encrypted_hora');
            $table->json('encrypted_mensagem')->nullable();
            $table->string('encrypted_key'); // AES key protegida com RSA
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
        Schema::dropIfExists('agendamentos');
    }
};
