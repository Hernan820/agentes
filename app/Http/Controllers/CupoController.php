<?php

namespace App\Http\Controllers;

use App\Models\cupo;
use Carbon\CarbonPeriod;
use Carbon\Carbon;

use Illuminate\Http\Request;

class CupoController extends Controller
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
    public function create(Request $request)
    {
          $period = CarbonPeriod::create($request->start, $request->end);
        foreach ($period as $date) {   
            $cupo = new cupo;
            $cupo->start= $date;
            $cupo->end= $date;
            $cupo->title="Día De Trabajo";
            $cupo->save();  
        }
        return 1;
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
     * @param  \App\Models\cupo  $cupo
     * @return \Illuminate\Http\Response
     */
    public function show(cupo $cupo)
    {
        $resultado = cupo::all();
        return $resultado;   
     }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\cupo  $cupo
     * @return \Illuminate\Http\Response
     */
    public function vistaregistro($id)
    {
        $cupo = cupo::find($id);
        return view("registros.registroAgente", compact('cupo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\cupo  $cupo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, cupo $cupo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\cupo  $cupo
     * @return \Illuminate\Http\Response
     */
    public function destroy(cupo $cupo)
    {
        //
    }
}
