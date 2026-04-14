<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

#[Signature('role:add')]
#[Description('Command description')]
class AddRole extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = (string) $this->ask('Nama Role');
        if ($name) {
            Role::create(['name' => $name]);
            $this->info("Role {$name} berhasil ditambahkan");
        } else {
            $this->error('Nama role perlu diisi dengan benar');
        }
    }
}
