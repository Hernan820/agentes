<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleHorariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_horarios', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_rangodefecha');
            $table->foreign('id_rangodefecha')->references('id')->on('rango_horarios');

            $table->unsignedBigInteger('id_horariousuario');
            $table->foreign('id_horariousuario')->references('id')->on('horario_usuarios');

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
        Schema::dropIfExists('detalle_horarios');
    }
}
