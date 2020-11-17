<?php
use App\User; //2020-11-11 add, for sanctum
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        /* 
        //  Faker\Factory can take a locale as an argument, 
        //  to return localized data. If no localized provider 
        //  is found, the factory fallbacks to the default locale (en_US).
        */
        //$faker = Faker\Factory::create('zh_TW');
        factory(User::class, 100)->create(); //2020-11-11 add, for sanctum
    }
}
