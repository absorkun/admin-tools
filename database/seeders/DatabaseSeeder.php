<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admins = ['absor', 'maykada', 'el'];
        $pandis = ['pandi'];
        $helpdesks = ['rangga', 'wahyudi', 'shifa', 'natasia'];

        Role::firstOrCreate(['name' => 'super_admin']);
        Role::firstOrCreate(['name' => 'pandi']);
        Role::firstOrCreate(['name' => 'helpdesk']);

        foreach ($admins as $name) {
            User::firstOrCreate(['name' => $name], [
                'email' => "$name@email.com",
                'password' => bcrypt('password'),
            ])->assignRole('super_admin');
        }

        foreach ($pandis as $name) {
            User::firstOrCreate(['name' => $name], [
                'email' => "$name@email.com",
                'password' => bcrypt('password'),
            ])->assignRole('pandi');
        }

        foreach ($helpdesks as $name) {
            User::firstOrCreate(['name' => $name], [
                'email' => "$name@email.com",
                'password' => bcrypt('password'),
            ])->assignRole('helpdesk');
        }
    }
}
