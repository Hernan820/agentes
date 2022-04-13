<?php

namespace App\Exports;

use App\User;
use App\Exports\Sheets\UserRegister;
use DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class RegistroExports implements WithMultipleSheets
{

    use Exportable;

    protected $fecha1;

    protected $fecha2;


    public function __construct( $fecha1, $fecha2)
    {
        $this->fecha1 = $fecha1;
        $this->fecha1 = $fecha1;
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



        foreach(range(1,2) as $id) {
            $sheets[] = new UserRegister($this->fecha1,$this->fecha2, $id);
        }

        return $sheets;
    }
}