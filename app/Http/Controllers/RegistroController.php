<?php

namespace App\Http\Controllers;

use App\Models\registro;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class RegistroController extends Controller
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
        $registrousuario = new registro;
        $registrousuario->hora_ini= $request->horainicio; 
        $registrousuario->hora_fin= $request->horafinal; 
        $registrousuario->intervalo_ini= $request->intervaloinicio; 
        $registrousuario->intervalo_fin= $request->intervalofinal; 
        $registrousuario->total_horas= $request->total_horas_realizadas; 
        $registrousuario->total_citas= $request->total_citas; 
        $registrousuario->comentarios= $request->comentarios; 
        $registrousuario->id_usuario= auth()->user()->id;
        $registrousuario->id_cupo = $request->cupo_id; 
        $registrousuario->save(); 

        return 1;

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\registro  $registro
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $datos = registro::join("users","users.id","=","registros.id_usuario")
        ->select("users.*","registros.*")
        ->where("registros.id_cupo","=",$id)
        ->get();

        return response()->json($datos);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\registro  $registro
     * @return \Illuminate\Http\Response
     */
    public function edit(registro $registro)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\registro  $registro
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, registro $registro)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\registro  $registro
     * @return \Illuminate\Http\Response
     */
    public function destroy(registro $registro)
    {
        //
    }
}
