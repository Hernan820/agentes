<?php

namespace App\Http\Controllers;
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
    public function mostrarReporte(Request $request)
    {
        $sql = "SELECT users.name, '$request->fechainicio' as fecha_inicio, '$request->fechafinal' as fecha_final ,SEC_TO_TIME(SUM(TIME_TO_SEC(total_horas))) AS horas, 
        SUM(registros.total_citas) as citas , 
        (SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(total_horas)))  FROM registros INNER JOIN cupos on cupos.id = registros.id_cupo WHERE cupos.start BETWEEN '$request->fechainicio' AND '$request->fechafinal') AS total_tiempo,
         (SELECT SUM(total_citas) FROM registros INNER JOIN cupos on cupos.id = registros.id_cupo WHERE cupos.start BETWEEN '$request->fechainicio' AND '$request->fechafinal' ) AS total_citas 
         FROM registros
          INNER JOIN cupos on cupos.id = registros.id_cupo 
          INNER JOIN users on users.id = registros.id_usuario 
          WHERE cupos.start BETWEEN '$request->fechainicio' AND '$request->fechafinal' AND users.estado_user = 1 GROUP BY users.name;";

        $reportehoras = DB::select($sql);
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
    public function edit($id)
    {
        //
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
