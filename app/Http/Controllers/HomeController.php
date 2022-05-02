<?php

namespace App\Http\Controllers;

use App\Models\paises;
use App\Models\registro;
use App\Models\User;
use DB;
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
            $usuario ->id_pais = $request-> paises;

            $usuario->password = Hash::make($request->password);
            $usuario->estado_user = 1;
            $usuario->save();
    
            $usuario->assignRole($request['rol']);

            return (response()->json(true));
        }else{
            return (response()->json(false));
        }

    }
    /*
    *
    *
    */
    function mostrarusuarios(){

        $sql = 'SELECT users.*,paises.*,users.id as iduser,users.email, (CASE WHEN roles.name = "administrador" THEN "administrador" ELSE (CASE WHEN roles.name = "usuario" THEN "confirmacion de citas" ELSE (CASE WHEN roles.name = "agente" THEN "agente" END)  END) END) AS rol FROM `users` 
        LEFT JOIN model_has_roles on model_has_roles.model_id = users.id
        LEFT JOIN roles ON roles.id = model_has_roles.role_id
        LEFT JOIN paises on paises.id = users.id_pais
         WHERE users.estado_user = 1 AND roles.id IN(1,2)';

        $listaUsuarios = DB::select($sql);
        return $listaUsuarios;
    }
        /*
    *
    *
    */
    function editarusuario($id){
        
        $datosusuario= User::leftjoin('paises','paises.id','=','users.id_pais')
        ->select('users.*','users.id as idusuario','paises.*','paises.id as idpais') 
        ->where('users.id',"=",$id) 
        ->get()
        ->first();


        
        $rol = DB::table('roles') ->join('model_has_roles','model_has_roles.role_id','=','roles.id')
         ->select('roles.id', 'roles.name', 'model_has_roles.model_id') 
        ->where('model_id',"=",$id) 
        ->where(function ($query) {
            $query->where("roles.name", "=","administrador")
                  ->orwhere("roles.name", "=","agente");
        })
        ->get()
        ->first();
        
        return response()->json(['datosusuario' => $datosusuario, 'rol' => $rol],200);
    }
            /*
    *
    *
    */
    function actualizarusuario(Request $request){

        $role = DB::table('roles') ->join('model_has_roles', 'model_has_roles.role_id', '=', 'roles.id')
        ->select('roles.id', 'roles.name', 'model_has_roles.model_id') 
       ->where('model_id',"=",$request->id_user) 
       ->get()
       ->first();

       $User= User::find($request->id_user);
       $User ->name = $request-> name;
       $User ->email = $request-> email;
       $User ->id_pais = $request-> paises;

       if($request->cambiar_contra != ""){
        $User->password = Hash::make($request->password);
       }

        if($request->rol != $role){
            $User->roles()->detach();
            $User->assignRole($request->rol ); 
        }

       $User->save();

       return $request->cambiar_contra;
    }
                /*
    *
    *
    */
    function eliminarusuario($id){

        $eliminacionusuaio = User::find($id);
        $eliminacionusuaio->estado_user = 0 ;
        $eliminacionusuaio->save();
        return 1;
    }

    function paises(){
        $paises = paises::all();
        return (response()->json($paises));
        }
}
