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
        //registro con un solo credencial
    	User::create([
    		'name'=>'Jhonny Fernandez',
    		'email'=>'jhonnyfernandez@gmail.com',
    		'password'=>bcrypt('jfv123')
    	]);

        // otros 
        user::factory(99)->create();
    }
}
