<?php
namespace App\Exports\Sheets;
use App\Models\User;
use App\Models\registro;
use DB;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;

class UserRegister implements FromQuery, WithTitle
{
    private $fecha1;
    private $fecha2;
    private $id;


    public function __construct($fecha1,$fecha2 , $id)
    {
        $this->fecha1 = $fecha1;
        $this->fecha2  = $fecha2;
        $this->id  = $id;
    }

    /**
     * @return Builder
     */



    public function query()
    {
       /* $consulta = "SELECT
        users.name,cupos.start, registros.hora_ini,registros.hora_fin,registros.intervalo_ini,registros.intervalo_fin,
        registros.total_horas,registros.total_citas,
        (SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(registros.total_horas))) AS hours FROM registros 
         INNER JOIN cupos on cupos.id = registros.id_cupo
         WHERE registros.id_usuario = $this->id AND cupos.start BETWEEN '$this->fecha1' AND '$this->fecha2') AS horasTotal,
        (SELECT SUM(registros.total_citas) FROM registros
         INNER JOIN cupos on cupos.id = registros.id_cupo
         WHERE registros.id_usuario = $this->id AND cupos.start BETWEEN '$this->fecha1' AND '$this->fecha2') AS citasTotal
        FROM registros 
        INNER JOIN cupos on cupos.id = registros.id_cupo 
        INNER JOIN users on users.id = registros.id_usuario 
        where cupos.start BETWEEN '$this->fecha1' AND '$this->fecha2'  AND users.id = $this->id ORDER BY cupos.start ASC ;";


       return   $reportehoras = DB::select($consulta);*/

       return  registro::join("cupos","cupos.id","=","registros.id_cupo")
    ->join('users','registros.id_usuario','=','users.id')
    ->select('users.name',
    DB::raw('SEC_TO_TIME(SUM(TIME_TO_SEC(total_horas))) AS hours'),
    DB::raw('SUM(registros.total_citas) as citas'),
    DB::raw('(SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(total_horas))) AS total_horas FROM registros) AS total_tiempo'),
    DB::raw('(SELECT SUM(total_citas) FROM registros) AS total_citas') )
    ->where("cupos.start",">=",$this->fecha1)
    ->where("users.id","=",$this->id)
    ->groupBy('users.name')
    ->get();


    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Month ' . $this->id;
    }
}