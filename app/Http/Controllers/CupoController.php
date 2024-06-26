<?php

namespace App\Http\Controllers;

use App\Models\cupo;
use App\Models\registro;

use Carbon\CarbonPeriod;
use Carbon\Carbon;

use Illuminate\Http\Request;
use DB;

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
           // $cupo->vista=1;
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
        $period = CarbonPeriod::create($request->start, $request->end);
        foreach ($period as $date) {   
            $cupo = new cupo;
            $cupo->start= $date;
            $cupo->end= $date;
            $cupo->title="Horario dia";
            $cupo->vista=2;
            $cupo->save();  
        }
        return 1;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\cupo  $cupo
     * @return \Illuminate\Http\Response
     */
    public function show(cupo $cupo)
    {
       $sql =  "SELECT * FROM `cupos`;";
       $resultado = DB::select($sql);
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

        if(auth()->user()->acceso == 1){
            $cupo = cupo::find($id);
            return view("registros.registroAgente", compact('cupo'));
        }else{
            return view('errors.404');
        }

     
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
    public function destroy($id)
    {
        $consultaDatos = registro::
        where("registros.id_cupo","=",$id)
        ->count();


        if($consultaDatos == 0)
        {
            $cupo =cupo::find($id);
            $cupo->delete();

            return (response()->json(true));
        }else{
            return response()->json(false);
        }
    }
/*


*/
    public function cuposhorario(){
        $sql =  "SELECT * FROM `cupos` WHERE cupos.vista = 2;";
        $resultado = DB::select($sql);
         return $resultado;  

    }

    public function vistahorarios($id)
    {
            $cupo = cupo::find($id);
            return view("registros.registroAgente", compact('cupo'));  
    }
}
