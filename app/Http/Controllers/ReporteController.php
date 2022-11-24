<?php

namespace App\Http\Controllers;
use App\Models\User;
use DB;

use Illuminate\Http\Request;

class ReporteController extends Controller
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

    public function export($id)
    {
        ob_end_clean();
        ob_start();

        return Excel::download(new CitaExport($id), 'Registros.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function idusuarios()
    {
        $idusuario = User::select("users.id")
        ->where("users.estado_user","=",1)
        ->get() ;

       return response()->json($idusuario);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function mostrarReporte(Request $request)
    {
/*
        $consulta = "SELECT
        users.name,cupos.start, registros.horasiniciales,registros.horasfinales,registros.intervalo_ini,registros.intervalo_fin,
        registros.total_horas,registros.total_citas,
        (SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(registros.total_horas))) AS hours FROM registros 
         INNER JOIN cupos on cupos.id = registros.id_cupo
         WHERE registros.id_usuario = $id AND cupos.start BETWEEN '$request->fechainicio' AND '$request->fechafinal') AS horasTotal,
        (SELECT SUM(registros.total_citas) FROM registros
         INNER JOIN cupos on cupos.id = registros.id_cupo
         WHERE registros.id_usuario = $id AND cupos.start BETWEEN '$request->fechainicio' AND '$request->fechafinal') AS citasTotal
        FROM registros 
        INNER JOIN cupos on cupos.id = registros.id_cupo 
        INNER JOIN users on users.id = registros.id_usuario 
        where cupos.start BETWEEN '$request->fechainicio' AND '$request->fechafinal'  AND users.id = $id ORDER BY cupos.start ASC ;";
*/

        $consulta1 ="SELECT users.id, users.name, cupos.start, registros.horasiniciales , registros.horasfinales, registros.total_horas, registros.total_citas  FROM `registros`
        INNER JOIN users on users.id = registros.id_usuario  ;l
        INNER JOIN cupos on cupos.id = registros.id_cupo
        WHERE users.id IN (SELECT users.id FROM users WHERE users.estado_user = 1  ORDER BY users.id DESC) AND cupos.start BETWEEN '$request->fechainicio' AND '$request->fechafinal'
        AND registros.estado_registro is null
        ORDER BY users.id DESC";

        $reportehoras = DB::select($consulta1);

        $consulta2 = "SELECT users.id , users.name,SEC_TO_TIME(SUM(TIME_TO_SEC(registros.total_horas))) AS hours ,
        SUM(registros.total_citas) as citas
        FROM registros
        INNER JOIN users on users.id = registros.id_usuario
        INNER JOIN cupos on cupos.id = registros.id_cupo
         WHERE users.id IN (SELECT users.id FROM users WHERE users.estado_user = 1) AND cupos.start BETWEEN '$request->fechainicio' AND '$request->fechafinal' AND registros.estado_registro is null
        GROUP BY users.id , users.name
        ORDER BY users.id DESC";

         $totales = DB::select($consulta2);
         
         $consulta3 = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(registros.total_horas))) AS hours ,
         SUM(registros.total_citas) as citas
         FROM registros
         INNER JOIN users on users.id = registros.id_usuario
          INNER JOIN cupos on cupos.id = registros.id_cupo
         WHERE users.id IN (SELECT users.id FROM users WHERE users.estado_user = 1) 
         AND cupos.start BETWEEN '$request->fechainicio' AND '$request->fechafinal' AND registros.estado_registro is null";

         $totalfinal = DB::select($consulta3);


         return response()->json(['reportehoras' => $reportehoras, 'totales' => $totales, 'totalfinal' => $totalfinal],200);

    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('reporte.reportehoras');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function total(Request $request)
    {
        $sql = "SELECT
        SEC_TO_TIME(SUM(TIME_TO_SEC(registros.total_horas))) AS totalhoras,
        SUM(registros.total_citas) AS totalcitas
        FROM registros 
        INNER JOIN cupos on cupos.id = registros.id_cupo 
        where cupos.start BETWEEN '$request->fechainicio' AND '$request->fechafinal'  AND registros.id_usuario  IN(SELECT users.id FROM users WHERE users.estado_user = 1) ;";
    
       $total_reporte = DB::select($sql);

       return response()->json($total_reporte);


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function totalusuario($fecha1,$fecha2,$id){

        $sql = "SELECT users.name, users.email , paises.nombre_paises,'$fecha1' as fechauno,'$fecha2' as fechados,
        SEC_TO_TIME(SUM(TIME_TO_SEC(registros.total_horas))) AS totalhoras,
        SUM(registros.total_citas) AS totalcitas
        FROM registros 
        INNER JOIN users on users.id = registros.id_usuario  
        INNER JOIN cupos on cupos.id = registros.id_cupo
        INNER JOIN paises on paises.id = users.id_pais
        where cupos.start BETWEEN '$fecha1' AND '$fecha2' 
        AND registros.id_usuario = $id  AND registros.estado_registro IS NULL
        GROUP BY users.name, users.email,paises.nombre_paises;";
    
       $total_usuario = DB::select($sql);

       return response()->json($total_usuario);
        
    }

    function acceso($id){

        $sql = "UPDATE users 
        INNER JOIN model_has_roles ON users.id = model_has_roles.model_id  
        SET users.acceso =$id
        WHERE model_has_roles.role_id = 2;";
    
       $total_usuario = DB::select($sql);

       return 1 ;
    }

    function accesoagentes(){

        $acceso= User::join('model_has_roles','model_has_roles.model_id','=','users.id')
                 ->select("users.acceso")
                 ->where("model_has_roles.role_id","=",2)
                 ->first();

     return response()->json($acceso);

    }

}
