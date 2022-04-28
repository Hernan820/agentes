<?php
namespace App\Exports\Sheets;
use App\Models\User;
use App\Models\registro;
use DB;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
date_default_timezone_set("America/New_York");

class UserRegister implements  FromQuery,WithTitle
{

    private $fecha1;
    private $fecha2;
    private $id;
    private $nombre;


    public function __construct($fecha1,$fecha2 ,$id,$nombre)
    {
        $this->fecha1 = $fecha1;
        $this->fecha2  = $fecha2;
        $this->id  = $id;
        $this->nombre  = $nombre;

    }

    /**
     * @return Builder
     */


    public function query()
    {


        return registro::query()->leftJoin("cupos","cupos.id","=","registros.id_cupo")
        ->leftJoin('users','registros.id_usuario','=','users.id')

        ->select(DB::raw('users.id ,users.name, date_format(cupos.start, "%d-%m-%Y") as fecha  ,registros.horasiniciales,registros.horasfinales , registros.total_horas as HORAS, registros.total_citas AS CITAS ,
        "sumashoras->",
        (SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(registros.total_horas))) FROM registros INNER JOIN users ON users.id = registros.id_usuario INNER JOIN cupos on cupos.id = registros.id_cupo WHERE users.id = '.$this->id.' AND cupos.start >= "'.$this->fecha1.'" AND cupos.start <= "'.$this->fecha2.'" ) AS SUMA,
         "sumascitas->",
        (SELECT SUM(registros.total_citas) FROM registros INNER JOIN users ON users.id = registros.id_usuario INNER JOIN cupos on cupos.id = registros.id_cupo WHERE users.id = '.$this->id.' AND cupos.start >= "'.$this->fecha1.'" AND cupos.start <= "'.$this->fecha2.'") AS SUMACITA'
        ) 
        
        )

        ->where("cupos.start",">",$this->fecha1)
        ->where("cupos.start","<",$this->fecha2)
        ->where("users.id","=",$this->id)
        ->orderBy('cupos.start', 'DESC');
        

    }

    /**
     * @return string
     */
    public function title(): string
    {
        return  $this->nombre;
    }
}