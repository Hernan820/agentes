<?php

namespace App\Http\Controllers;
use DB;
use App\Models\registro;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\registrohoarios;
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
    public function conteo($id,$idcup)
    {
        $conteouser = registro:: where("id_usuario","=",$id )->where("id_cupo","=",$idcup )
        ->where("registros.estado_registro","=",null)
        ->count();

        return response()->json($conteouser);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $conteoregistro = registro:: where("id_usuario","=",auth()->user()->id )->where("id_cupo","=",$request->cupo_id )
        ->where("registros.estado_registro","=",null)
        ->count();


        if($conteoregistro == 0){
            $registrousuario = new registro;
            $registrousuario->horasiniciales= $request->horasiniciales; 
            $registrousuario->horasfinales= $request->horasfinales; 
            $registrousuario->total_horas= $request->TotaDeHoras;
            $registrousuario->total_citas=$request->total_citas; 
            $registrousuario->comentarios= $request->comentarios;
            $registrousuario->motivo= $request->motivoshorario;  
            $registrousuario->id_usuario= auth()->user()->id;
            $registrousuario->id_cupo = $request->cupo_id; 
            $registrousuario->save(); 

             return 1 ;
        }else {
            return 2;
        }
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
            ->where(function ($query) {
                $query->where("registros.estado_registro","=",null);
            })
            ->get();
            return response()->json($datosusuario);
    }

    function todosregistros($id){
        $datos = registro::join("users","users.id","=","registros.id_usuario")
        ->select("users.*","registros.*")
        ->where("registros.id_cupo","=",$id)
        ->where("registros.estado_registro","=",null)
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

        if ( isset($request->edicion) ) {
            if ($request->edicion == 'edicion') {
            $horariousuario = registrohoarios::find($request->id_registro);
            $horariousuario->horasiniciales =$request->hiniciales;
            $horariousuario->horasfinales =$request->hfinales;
            $horariousuario->total_horas = $request->TotaDeHoras ;
            $horariousuario->save();
            return 1 ;
            }
        }else{

        $actilizar = registro::find($request->id_registro);
        $actilizar->horasiniciales= $request->horasiniciales; 
        $actilizar->horasfinales= $request->horasfinales; 
        $actilizar->total_horas= $request->TotaDeHoras;
        $actilizar->total_citas= $request->total_citas; 
        $actilizar->comentarios= $request->comentarios; 
        $actilizar->motivo= $request->motivoshorario;  

        $actilizar->save();
        return 1;   
 
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\registro  $registro
     * @return \Illuminate\Http\Response
     */
    public function eliminar($id)
    {

    $registro = registro::find($id);
    $registro->estado_registro = 0;
    $registro->save();

    return 1 ;
    }
}
