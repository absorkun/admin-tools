<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

#[Signature('admin:add')]
#[Description('Command description')]
class AddAdmin extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $roleName = 'super_admin';
        if (!$role = Role::query()->where('name', $roleName)->first()) {
            $this->error("Role {$role} belum didaftarkan");
        }

        $name = (string) $this->ask('Masukkan username');
        if (!$name) {
            $this->error('Username perlu diisi dengan benar');
            return;
        }

        $user = User::whereNotNull('name')->where('name', $name)->first();
        if (!$user) {
            $this->error("User dengan username {$name} tidak ditemukan");
            return;
        }
        
        $user->assignRole([$roleName]);
        $this->info("{$user->name} berhasil ditambahkan sebagai {$roleName}");
    }
}
