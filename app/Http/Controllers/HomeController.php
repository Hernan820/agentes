<?php

namespace App\Http\Controllers;

use App\Models\registro;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('calendario.calendar');
    }

    function vistausuarios(){
        return view('auth.register');

    }

    /*
    *
    *
    */
    function usuarios(Request $request){

        $user= User::where("users.email","=",$request->email)
        ->count();

        if($user == 0){
            $usuario= new User;
            $usuario->name = $request-> name; 
            $usuario->email = $request-> email;
            $usuario->password = Hash::make($request->password);
            $usuario->save();
    
            $usuario->assignRole($request['rol']);

            return (response()->json(true));
        }else{
            return (response()->json(false));
        }

    }
}
