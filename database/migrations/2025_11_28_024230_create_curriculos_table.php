<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurriculosTable extends Migration
{
    public function up()
    {
        Schema::create('curriculos', function (Blueprint $table) {
            $table->id();
            // campos sensíveis criptografados (armazenamos base64)
            $table->text('encrypted_nome')->nullable();
            $table->text('encrypted_email')->nullable();
            $table->text('encrypted_telefone')->nullable();
            $table->text('encrypted_area_interesse')->nullable();
            $table->text('encrypted_mensagem')->nullable();

            // AES key criptografada com RSA (base64)
            $table->text('encrypted_key')->nullable();

            // arquivo criptografado armazenado em storage/app/private/curriculos/...
            $table->string('file_path')->nullable();
            $table->string('file_original_name')->nullable();
            $table->string('file_sha256')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('curriculos');
    }
}
