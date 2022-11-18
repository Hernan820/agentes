<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrohoariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrohoarios', function (Blueprint $table) {
            $table->id();
            $table->datetime("fecha_horario");
            $table->text("horasiniciales")->nullable(); 
            $table->text("horasfinales")->nullable(); 
            $table->time("total_horas")->nullable();
            $table->text("comentarios")->nullable();
            $table->text("estado_horario")->nullable();
            $table->unsignedBigInteger('id_usuario');
            $table->foreign('id_usuario')->references('id')->on('users');
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
        Schema::dropIfExists('registrohoarios');
    }
}
