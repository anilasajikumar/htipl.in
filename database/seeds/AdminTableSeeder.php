<?php

use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $admin = [
           [
            'first_name' => 'Admin',
            'email'=> 'admin@htipl.in',
            'password'=> bcrypt('HTI#adm20!')
           ],
     ];

     DB::table('users')->updateOrInsert(
         ['email' => $admin[0]['email']],
         $admin[0]
     );
    }
}
