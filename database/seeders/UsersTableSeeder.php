<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $instructor = Role::firstOrCreate(['name' => 'instructor']);
        $learner = Role::firstOrCreate(['name' => 'learner']);
        $manager = Role::firstOrCreate(['name' => 'manager']);


        $adminUser = User::firstOrCreate(
            [   'email' => 'admin@admin.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('password')
            ]
        );

        $adminUser->assignRole('admin');
    }
}
