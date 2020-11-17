<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        
        //$this->call(UsersTableSeeder::class); //2020-11-11 add, for sanctum
                                                //mark it, 2020-11-16
        //$this->call(RoleSeeder::class);         //2020-11-16 add for user roles and permissions
        //$this->call(PermissionSeeder::class);   //2020-11-16 add for user roles and permissions
        //$this->call(UserSeeder::class);         //2020-11-16 assign roles and permissions into user1, user2 and user3
    }
}
