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
        Schema::table('users', function (Blueprint $table) {
            // Cliente, Funcionario ou Administrador
            $table->enum('tipo', ['C', 'F', 'A']);

            // Acesso do utilizador bloqueado
            $table->boolean('bloqueado')->default(false);

            // Fotografia/Avatar do utilizador
            $table->string('foto_url')->nullable();

            // Utilizadores podem ser apagados com "soft deletes"
            $table->softDeletes();
        });

        Schema::create('clientes', function (Blueprint $table) {
            // Chave primária dos clientes é a mesma que a chave primária dos users
            // (Clientes é uma subclasse de Users)
            $table->bigInteger('id')->unsigned()->primary();
            $table->foreign('id')->references('id')->on('users');

            $table->string('nif', 9)->nullable();
            // VISA - Visa
            // PAYPAL - Paypal
            // MBWAY - MB way
            $table->enum('tipo_pagamento', ['VISA', 'PAYPAL', 'MBWAY'])->nullable();
            // Referência de pagamento varia consoante o tipo de pagamento
            // VISA -> Nº de cartão com 16 digitos
            // PAYPAL -> email
            // MBWay -> telemóvel PT - 9 digitos (1º digito é sempre 9)
            $table->string('ref_pagamento')->nullable();
            // custom data
            $table->json('custom')->nullable();
            $table->timestamps();
            // Clientes podem ser apagados com "soft deletes"
            $table->softDeletes();
        });

        // Parametros de configuração - só deverá haver 1 registo
        Schema::create('configuracao', function (Blueprint $table) {
            $table->id();
            $table->decimal('preco_bilhete_sem_iva', 8, 2);  // 8.85
            $table->integer('percentagem_iva');   // 13%
            // custom data
            $table->json('custom')->nullable();
        });

        // Salas
        Schema::create('salas', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            // custom data
            $table->json('custom')->nullable();
            $table->softDeletes();
        });

        // Lugares
        Schema::create('lugares', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sala_id');
            $table->foreign('sala_id')->references('id')->on('salas');
            $table->string('fila', 1);
            $table->integer('posicao');
            // custom data
            $table->json('custom')->nullable();
            $table->softDeletes();
        });

        // Géneros dos filmes
        Schema::create('generos', function (Blueprint $table) {
            $table->string('code', 20);
            $table->primary('code');
            $table->string('nome');
            // Generos de Filmes podem ser apagados com "soft deletes"
            $table->softDeletes();
        });

        // Filmes
        Schema::create('filmes', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('genero_code', 20);
            $table->foreign('genero_code')->references('code')->on('generos');
            $table->integer('ano');
            // Se cartaz é null, apresenta um default.
            $table->string('cartaz_url')->nullable();
            $table->text('sumario');
            // Trailer será um link externo
            $table->string('trailer_url')->nullable();
            // custom data
            $table->json('custom')->nullable();
            $table->timestamps();
        });

        // Sessões
        Schema::create('sessoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('filme_id');
            $table->foreign('filme_id')->references('id')->on('filmes');
            $table->foreignId('sala_id');
            $table->foreign('sala_id')->references('id')->on('salas');
            $table->date('data');
            $table->time('horario_inicio');
            $table->json('custom')->nullable();
            $table->timestamps();
        });

        // recibos das compras
        Schema::create('recibos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id');
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->date('data');
            $table->decimal('preco_total_sem_iva', 8, 2);
            $table->decimal('iva', 8, 2);
            $table->decimal('preco_total_com_iva', 8, 2);

            $table->string('nif', 9)->nullable();
            $table->string('nome_cliente');
            // VISA - Visa
            // PAYPAL - Paypal
            // MBWAY - MB way
            $table->enum('tipo_pagamento', ['VISA', 'PAYPAL', 'MBWAY']);
            // Referência de pagamento varia consoante o tipo de pagamento
            // VISA -> Nº de cartão com 16 digitos
            // PAYPAL -> email
            // MBWay -> telemóvel PT - 9 digitos (1º digito é sempre 9)
            $table->string('ref_pagamento');

            $table->string('recibo_pdf_url')->nullable();

            // custom data
            $table->json('custom')->nullable();

            $table->timestamps();
        });


        // Bilhetes
        Schema::create('bilhetes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recibo_id');
            $table->foreign('recibo_id')->references('id')->on('recibos');
            $table->foreignId('cliente_id');
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->foreignId('sessao_id');
            $table->foreign('sessao_id')->references('id')->on('sessoes');
            $table->foreignId('lugar_id');
            $table->foreign('lugar_id')->references('id')->on('lugares');
            $table->decimal('preco_sem_iva', 8, 2);
            $table->enum('estado', ['não usado', 'usado'])->default('não usado');
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
        //
    }
};
