<?php

namespace App\Http\Controllers;
use DateTime;
use App\Models\registrohoarios;
use Illuminate\Http\Request;
use App\Models\User;
use DB;
use App\Models\registro;
use App\Models\cupo;

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
    public function horasdefecha($fecha)
    {
        $horas = registrohoarios::select('registrohoarios.*')
                ->where('registrohoarios.fecha_horario','like',$fecha.'%')
                ->where('registrohoarios.id_usuario','=',auth()->user()->id)
                ->where('registrohoarios.estado_horario','=',1)
                ->get();
        return $horas;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        foreach(explode(',',$request->usuarios) as $idusuario){

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
                $horariousuario->id_usuario = $idusuario ;
                $horariousuario->save();

                if($request-> $horasini == 0 &&  $request->$horasfin == 0){
                    $idcupo = cupo::where('cupos.start','=',$request-> $fecha )
                           ->where('cupos.estado_cupo','=',NULL )->get();

                    $registrousuario = new registro;
                    $registrousuario->horasiniciales= $request-> $horasini; 
                    $registrousuario->horasfinales= $request->$horasfin; 
                    $registrousuario->total_horas= $request->$totalh;
                    $registrousuario->total_citas= 0; 
                    $registrousuario->comentarios= 'Este dia es OFF';
                    $registrousuario->id_usuario= $idusuario;
                    $registrousuario->id_cupo =  $idcupo[0]->id;
                    $registrousuario->save(); 
                }

               }
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
                          ->where("users.estado_user","=",1)
                          ->where("roles.id","=",2)
                          ->get();

        return response()->json($usuarios);    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\registrohoarios  $registrohoarios
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {   
        $id_registros =explode(',',$request->idhorarios);

        foreach($id_registros as $id){  
            $horariousuario = registrohoarios::find($id);
            $horariousuario->estado_horario = 0 ;
            $horariousuario->save();
        }
        return $id_registros;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\registrohoarios  $registrohoarios
     * @return \Illuminate\Http\Response
     */
    public function usuariosemana($ano,$semana)
    {
        $week = $semana;
        $year = $ano;
    
        $timestamp = mktime( 0, 0, 0, 1, 1,  $year ) + ( $week * 7 * 24 * 60 * 60 );
        $timestamp_for_monday = $timestamp - 86400 * ( date( 'N', $timestamp ) - 1 );
        $date_for_monday = date( 'Y-m-d', $timestamp_for_monday );
    
    
    
        $diaInicio="Monday";
        $diaFin="Sunday";
        $hoy = $date_for_monday;
    
        $strFecha = strtotime($hoy);
    
        $fechaInicio = date('Y-m-d',strtotime('last '.$diaInicio,$strFecha));
        $fechaFin = date('Y-m-d',strtotime('next '.$diaFin,$strFecha));
    
        if(date("l",$strFecha)==$diaInicio){
            $fechaInicio= date("Y-m-d",$strFecha);
        }
        if(date("l",$strFecha)==$diaFin){
            $fechaFin= date("Y-m-d",$strFecha);
        }

        $sql = "SELECT users.* FROM users
        INNER JOIN model_has_roles on model_has_roles.model_id = users.id
        INNER JOIN roles on roles.id = model_has_roles.role_id
        WHERE NOT EXISTS (SELECT NULL FROM registrohoarios WHERE registrohoarios.id_usuario = users.id AND registrohoarios.fecha_horario BETWEEN '$fechaInicio' AND '$fechaFin' AND registrohoarios.estado_horario = 1 ) AND roles.id =2 AND users.estado_user = 1;";

        $usuarios = DB::select($sql);
        return $usuarios;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\registrohoarios  $registrohoarios
     * @return \Illuminate\Http\Response
     */
    public function registrosedit(Request $request)
    {
        $sql = "SELECT users.id as iduser,users.name ,registrohoarios.* FROM  registrohoarios
        INNER JOIN users ON users.id = registrohoarios.id_usuario
        WHERE  registrohoarios.id IN($request->idhorarios) AND registrohoarios.estado_horario = 1;";

        $usuarios = DB::select($sql);
        return $usuarios;
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

         /**
     * **************
     */

     function semana($ano,$semana_no,$id){
    $week = $semana_no;
    $year = $ano;

    $timestamp = mktime( 0, 0, 0, 1, 1,  $year ) + ( $week * 7 * 24 * 60 * 60 );
    $timestamp_for_monday = $timestamp - 86400 * ( date( 'N', $timestamp ) - 1 );
    $date_for_monday = date( 'Y-m-d', $timestamp_for_monday );

    $diaInicio="Monday";
    $diaFin="Sunday";
    $hoy = $date_for_monday;

    $strFecha = strtotime($hoy);

    $fechaInicio = date('Y-m-d',strtotime('last '.$diaInicio,$strFecha));
    $fechaFin = date('Y-m-d',strtotime('next '.$diaFin,$strFecha));

    if(date("l",$strFecha)==$diaInicio){
        $fechaInicio= date("Y-m-d",$strFecha);
    }
    if(date("l",$strFecha)==$diaFin){
        $fechaFin= date("Y-m-d",$strFecha);
    }


    $consulta1 ="SELECT registrohoarios.id as idh ,users.id, users.name, users.id_pais as pais , registrohoarios.fecha_horario, registrohoarios.horasiniciales, registrohoarios.horasfinales, registrohoarios.total_horas  FROM  registrohoarios
    INNER JOIN users on users.id = registrohoarios.id_usuario
    WHERE  registrohoarios.fecha_horario BETWEEN '$fechaInicio' AND '$fechaFin' AND registrohoarios.estado_horario = 1 AND users.id IN($id);";

    $horasuser = DB::select($consulta1);

    $consulta2 ="SELECT users.id,( HOUR(SEC_TO_TIME(SUM(TIME_TO_SEC(registrohoarios.total_horas))))) as TotalHoras FROM  registrohoarios
    INNER JOIN users on users.id = registrohoarios.id_usuario
    WHERE  registrohoarios.fecha_horario BETWEEN '$fechaInicio' AND '$fechaFin' AND registrohoarios.estado_horario = 1 AND users.id IN($id) GROUP BY users.id;";

    $totalhoras = DB::select($consulta2);

    

    return response()->json(['horasuser' => $horasuser, 'totalhoras' => $totalhoras],200);


       // return $fechaInicio ,$fechaFin ;
     }


              /**
     * **************
     */
     function usuarioshorarios($ano,$semana_no){

        $week = $semana_no;
        $year = $ano;
    
        $timestamp = mktime( 0, 0, 0, 1, 1,  $year ) + ( $week * 7 * 24 * 60 * 60 );
        $timestamp_for_monday = $timestamp - 86400 * ( date( 'N', $timestamp ) - 1 );
        $date_for_monday = date( 'Y-m-d', $timestamp_for_monday );
    
        $diaInicio="Monday";
        $diaFin="Sunday";
        $hoy = $date_for_monday;
    
        $strFecha = strtotime($hoy);
    
        $fechaInicio = date('Y-m-d',strtotime('last '.$diaInicio,$strFecha));
        $fechaFin = date('Y-m-d',strtotime('next '.$diaFin,$strFecha));
    
        if(date("l",$strFecha)==$diaInicio){
            $fechaInicio= date("Y-m-d",$strFecha);
        }
        if(date("l",$strFecha)==$diaFin){
            $fechaFin= date("Y-m-d",$strFecha);
        }

        $consulta ="SELECT registrohoarios.id as idregistro ,users.id FROM  registrohoarios
        INNER JOIN users on users.id = registrohoarios.id_usuario
        WHERE  registrohoarios.fecha_horario BETWEEN '$fechaInicio' AND '$fechaFin' AND registrohoarios.estado_horario = 1
        GROUP BY users.id 
        ORDER BY idregistro ASC;";

        $usuarios = DB::select($consulta);

        return response()->json($usuarios);
     }


     public function update(Request $request){

        if ($request->edicion == 'edicion') {

            $horariousuario = registrohoarios::find($request->id_registro);

            $idcupo = cupo::where('cupos.start','=',$horariousuario->fecha_horario )
            ->where('cupos.estado_cupo','=',NULL )->get();

            $countregistro = registro::where('registros.id_cupo','=',$idcupo[0]->id)
                               ->where('registros.id_usuario','=',$horariousuario->id_usuario)
                               ->where('registros.estado_registro','=',null)->count();

            $usuarioregistro=registro::where('registros.id_cupo','=',$idcupo[0]->id)
                               ->where('registros.id_usuario','=',$horariousuario->id_usuario)
                               ->where('registros.estado_registro','=',null)->get();

            if($horariousuario->hiniciales == 0 && $horariousuario->hfinales == 0 && $request->hiniciales != 0 && $request->hfinales != 0  ){
                    
                if($idcupo[0]->start > date('Y-m-d').' 00:00:00'){
                    if($countregistro > 0 ){
                        $registrousuario =registro::find($usuarioregistro[0]->id);
                        $registrousuario->estado_registro= 0; 
                        $registrousuario->save(); 
                    }
                }

            }


            $horariousuario->horasiniciales =$request->hiniciales;
            $horariousuario->horasfinales =$request->hfinales;
            $horariousuario->total_horas = $request->TotaDeHoras ;
            $horariousuario->save();


            if($request->hiniciales == 0 && $request->hfinales == 0 ){
                if($idcupo[0]->start > date('Y-m-d').' 00:00:00'){

                if($countregistro === 0){

                $registrousuario = new registro;
                $registrousuario->horasiniciales= $request->hiniciales; 
                $registrousuario->horasfinales= $request->hfinales; 
                $registrousuario->total_horas= $request->TotaDeHoras;
                $registrousuario->total_citas= 0; 
                $registrousuario->comentarios= 'Este dia es OFF';
                $registrousuario->id_usuario= $horariousuario->id_usuario ;
                $registrousuario->id_cupo =  $idcupo[0]->id;
                $registrousuario->save(); 

                }else{

                        $registrousuario =registro::find($usuarioregistro[0]->id);
                        $registrousuario->horasiniciales= $request->hiniciales; 
                        $registrousuario->horasfinales= $request->hfinales; 
                        $registrousuario->total_horas= $request->TotaDeHoras;
                        $registrousuario->total_citas= 0; 
                        $registrousuario->comentarios= 'Este dia es OFF';
                        $registrousuario->id_usuario= $horariousuario->id_usuario ;
                        $registrousuario->id_cupo =  $idcupo[0]->id;
                        $registrousuario->save(); 
        
                }
            }
            }

            return 1 ;
        }
        
    }
}
