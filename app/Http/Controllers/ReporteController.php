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
    public function mostrarReporte(Request $request, $id)
    {

        $consulta = "SELECT
        users.name,cupos.start, registros.hora_ini,registros.hora_fin,registros.intervalo_ini,registros.intervalo_fin,
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


        $reportehoras = DB::select($consulta);
        return response()->json($reportehoras);
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
    public function destroy($id)
    {
        //
    }
}
