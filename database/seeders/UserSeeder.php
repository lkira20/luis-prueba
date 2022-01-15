<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'nombre' => 'luis',
            'email' => 'luisalbertobri16@gmail.com',
            'password' => bcrypt('12345678'),
            'edad' => 23,
            'fecha_nacimiento' => '1998-10-07',
            'sexo' => 'hombre',
            'dni' => 26734165,
            'direccion' => 'la coromoto',
            'pais' => 'Venezuela',
            'telefono' => '+58243394579',
        ]);
    }
}
