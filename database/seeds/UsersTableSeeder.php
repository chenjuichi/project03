<?php

use App\User;                   //2020-11-11 add, for sanctum
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
        //
        //$faker = Faker\Factory::create('zh_TW');
        factory(User::class, 100)->create(); //2020-11-11 add, for sanctum
    }
}
