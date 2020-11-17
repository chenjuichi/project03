<?php

use App\Role;
use App\User;
use App\Permission;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $administrator = Role::where('slug','administrator')->first();
        $manager = Role::where('slug', 'project-manager')->first();
        $user = Role::where('slug', 'user')->first();
        $createTasks = Permission::where('slug','create-tasks')->first();
        $manageUsers = Permission::where('slug','manage-users')->first();
        $readcontents = Permission::where('slug','read-contents')->first();

        $user1 =User::where('name','Dr. Kristofer Jenkins')->first();
        $user1->roles()->attach($administrator);
        $user1->permissions()->attach($createTasks);

        $user2 =User::where('name','Chloe Howe Sr.')->first();
        $user2->roles()->attach($manager);
        $user2->permissions()->attach($manageUsers);

        $user3 =User::where('name','Dr. Timmy Schinner')->first();
        $user3->roles()->attach($user);
        $user3->permissions()->attach($readcontents);
  }
}
