<?php

namespace App\Exports;

use App\Models\User;
use App\Exports\Sheets\UserRegister;
use DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

date_default_timezone_set("America/New_York");

class RegistroExports implements WithMultipleSheets
{

    use Exportable;

    protected $fecha1;

    protected $fecha2;


    public function __construct( $fecha1, $fecha2)
    {
        $this->fecha1 = $fecha1;
        $this->fecha2 = $fecha2;

    }

/*
public function metodouser( $fecha1, $fecha2)
{
    $this->fecha1 = $fecha1;
    $this->fecha1 = $fecha1;
}*/
    /**
     * @return array
     */

    public function sheets(): array
    {
        $sheets = [];

        $usuarios = User::join("registros","registros.id_usuario","=","users.id")
        ->join("cupos","cupos.id","=","registros.id_cupo")
        ->select( DB::raw("users.id") , DB::raw("users.name"))
         ->where("users.estado_user","!=","0")
         ->where("cupos.start",">=",$this->fecha1)
         ->where("cupos.start","<=",$this->fecha2)
         ->groupBy('users.name','users.id')
         ->get();

       //  foreach(range(1,3) as $id) {
       //     $sheets[] = new UserRegister($this->fecha1,$this->fecha2, $id);
       // }

        foreach($usuarios as $user) {
            $sheets[] = new UserRegister($this->fecha1,$this->fecha2, $user->id,$user->name);
        }

        return $sheets;

       // persona{"id"1,"name""admin","em
    }
}