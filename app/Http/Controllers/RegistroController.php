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

            $registrousuario->horasiniciales= $request->horasiniciales; 
            $registrousuario->horasfinales= $request->horasfinales; 
  
            $registrousuario->total_horas= $request->TotaDeHoras;

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
    public function show($id,$id_u)
    {
            $datosusuario =registro::join("users","users.id","=","registros.id_usuario")
            ->select("users.*","registros.*")
            ->where("registros.id_cupo","=",$id)
            ->where("users.id","=",$id_u)
            ->get();
    
            return response()->json($datosusuario);
    
        

    }

    function todosregistros($id){

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
    public function edit($id)
    {
        $registroedit = registro::find($id);

        return response()->json($registroedit);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\registro  $registro
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $actilizar = registro::find($request->id_registro);

        $actilizar->hora_ini= $request->horainicio; 
        $actilizar->hora_fin= $request->horafinal; 

        if($request->intervalo_activo == "1"){
            $actilizar->intervalo_ini= $request->intervaloinicio; 
            $actilizar->intervalo_fin= $request->intervalofinal;
        }
        $actilizar->total_horas= $request->total_horas_realizadas; 
        $actilizar->total_citas= $request->total_citas; 
        $actilizar->comentarios= $request->comentarios; 
        $actilizar->id_cupo = $request->cupo_id; 
        $actilizar->save(); 

        return 1;
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
