<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:assign-role')]
#[Description('Command description')]
class AssignRole extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $username = (string) $this->ask('Username');
        $roleName = (string) $this->ask('Nama Role');
        $user = \App\Models\User::where('name', $username)->first();
        if (!$user) {
            $this->error("User dengan username {$username} tidak ditemukan");
            return;
        }
        $role = \Spatie\Permission\Models\Role::where('name', $roleName)->first();
        if (!$role) {
            $this->error("Role dengan nama {$roleName} tidak ditemukan");
            return;
        }
        $user->assignRole($role);
        $this->info("Role {$roleName} berhasil diberikan kepada user {$username}");
    }
}
