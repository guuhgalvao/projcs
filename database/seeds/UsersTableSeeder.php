<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([[
            'name' => 'Administrador',
            'email' => 'admin@admin.com',
            'nickname' => 'admin',
            'password' => bcrypt('testando'),
        ], [
            'name' => 'Funcionario',
            'email' => 'funcionario@funcionario.com',
            'nickname' => 'funcionario',
            'password' => bcrypt('testando'),
        ]]);
    }
}
