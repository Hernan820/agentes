<?php

namespace App\Http\Controllers;

use App\Models\horario_usuario;
use App\Models\detalle_horario;

use Illuminate\Http\Request;

class HorarioUsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\horario_usuario  $horario_usuario
     * @return \Illuminate\Http\Response
     */
    public function show($id ,$fecha)
    {

        $horario = detalle_horario::join("horario_usuarios","horario_usuarios.id", "=", "detalle_horarios.id_horariousuario")
                                ->join("rango_horarios","rango_horarios.id", "=", "detalle_horarios.id_rangodefecha")
                                ->select("horario_usuarios.*")
                                ->where("detalle_horarios.id_usuario","=",$id)
                                ->where("horario_usuarios.dia","=",$fecha)
                                ->get();

        return $horario;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\horario_usuario  $horario_usuario
     * @return \Illuminate\Http\Response
     */
    public function edit(horario_usuario $horario_usuario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\horario_usuario  $horario_usuario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, horario_usuario $horario_usuario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\horario_usuario  $horario_usuario
     * @return \Illuminate\Http\Response
     */
    public function destroy(horario_usuario $horario_usuario)
    {
        //
    }
}
