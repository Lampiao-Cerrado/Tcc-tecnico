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
        Schema::create('prematriculas', function (Blueprint $table) {
            $table->id();
            $table->longText('encrypted_nome_crianca');
            $table->longText('encrypted_data_nascimento');
            $table->longText('encrypted_nome_responsavel');
            $table->longText('encrypted_telefone');
            $table->longText('encrypted_email');
            $table->longText('encrypted_turma');
            $table->longText('encrypted_periodo');
            $table->longText('encrypted_key');
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
        Schema::dropIfExists('prematriculas');
    }
};
