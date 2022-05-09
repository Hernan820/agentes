<?php

use Faker\Factory as Faker;
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    // $administrador = Role::create(['name' => 'administrador']);
    // $agente = Role::create(['name' => 'agente']);

   $user = User::create([
         'name' => 'admin',
         'email' => 'admin@gmail.com',
         'password' => Hash::make('admin123')

     ]);
     $user->assignRole('administrador'); 

    }
}
