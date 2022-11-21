<?php

namespace App\Http\Controllers;

use App\Models\registrohoarios;
use Illuminate\Http\Request;
use App\Models\User;
use DB;

class RegistrohoariosController extends Controller
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
        $array = [1,2,3,4,5,6,7];

        foreach($array as $numero){
            $fecha ="fechadia".$numero;
            $horasini ="horas_iniciales_dia".$numero;
            $horasfin ="horas_finales_dia".$numero;
            $totalh ="total_horasdia".$numero;

            if($request-> $horasini != ""){

            $horariousuario = new registrohoarios;
            $horariousuario->fecha_horario = $request-> $fecha ;
            $horariousuario->horasiniciales = $request-> $horasini;
            $horariousuario->horasfinales = $request->$horasfin ;
            $horariousuario->total_horas = $request->$totalh ;
            $horariousuario->estado_horario = 1 ;
            $horariousuario->id_usuario = $request->usuarios ;
            $horariousuario->save();
        }

         }
         return 1;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\registrohoarios  $registrohoarios
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $usuarios = User::join("model_has_roles","model_has_roles.model_id","=","users.id")
                          ->join("roles","roles.id","=","model_has_roles.role_id")  
                          ->select("users.*")
                          ->where("roles.id","=",2)
                          ->get();

        return response()->json($usuarios);    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\registrohoarios  $registrohoarios
     * @return \Illuminate\Http\Response
     */
    public function edit(registrohoarios $registrohoarios)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\registrohoarios  $registrohoarios
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, registrohoarios $registrohoarios)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\registrohoarios  $registrohoarios
     * @return \Illuminate\Http\Response
     */
    public function destroy(registrohoarios $registrohoarios)
    {
        //
    }

    /**
     * **************
     */

     public function listausuarios(){

        $sql = 'SELECT users.id, users.name FROM `users` 
        LEFT JOIN model_has_roles on model_has_roles.model_id = users.id
        LEFT JOIN roles ON roles.id = model_has_roles.role_id
        WHERE roles.id = 2 AND users.estado_user = 1 ;';
        
        $usuarios = DB::select($sql);
        return $usuarios;
     }
}
