<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'miguel',
            'email' => 'correo@correo.com',
            'password' => Hash::make(12345678),
            'url' => 'http://codigoconjuan.com',
        ]);

        

        $user2 = User::create([
            'name' => 'alonso',
            'email' => 'correo2@correo.com',
            'password' => Hash::make(12345678),
            'url' => 'http://codigoconjuan.com',
        ]);

        
            
        
        // DB::table('users')->insert([
        //     'name' => 'miguel',
        //     'email' => 'correo@correo.com',
        //     'password' => Hash::make(12345678),
        //     'url' => 'http://codigoconjuan.com',
        //     'created_at' => date('Y-m-d H:i:s'),
        //     'updated_at' => date('Y-m-d H:i:s'),
        // ]);


        // DB::table('users')->insert([
        //     'name' => 'alonso',
        //     'email' => 'correo2@correo.com',
        //     'password' => Hash::make(12345678),
        //     'url' => 'http://codigoconjuan.com',
        //     'created_at' => date('Y-m-d H:i:s'),
        //     'updated_at' => date('Y-m-d H:i:s'),
        // ]);

    }
}
