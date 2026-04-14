<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use function Laravel\Prompts\text;

#[Signature('user:add')]
#[Description('Command description')]
class AddUser extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = (string) $this->ask('Username');
        $email = (string) $this->ask('Email');
        $password = (string) $this->secret('Password');
        
        if (!$name || !$email || !$password) {
            $this->error("Filed tersebut wajib diisi");
            return;
        }

        $hashedPassword = Hash::make($password);

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => $hashedPassword,
        ]);;

        $this->info("User berhasil dibuat");
    }
}
