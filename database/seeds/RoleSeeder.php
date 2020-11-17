<?php

use App\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $manager = new Role();
        $manager->name = 'Project Manager';
        $manager->slug = 'project-manager';
        $manager->save();

        $developer = new Role();
        $developer->name = 'Web Developer';
        $developer->slug = 'web-developer';
        $developer->save();

        $manager = new Role();
        $manager->name = 'Administrator';
        $manager->slug = 'administrator';
        $manager->save();

        $manager = new Role();
        $manager->name = 'Manager';
        $manager->slug = 'manager';
        $manager->save();

        $manager = new Role();
        $manager->name = 'Author';
        $manager->slug = 'author';
        $manager->save();

        $manager = new Role();
        $manager->name = 'User';
        $manager->slug = 'user';
        $manager->save();
    }        
}
