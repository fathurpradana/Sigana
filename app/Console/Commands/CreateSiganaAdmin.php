<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateSiganaAdmin extends Command
{
    protected $signature = 'sigana:create-admin';

    protected $description = 'Membuat atau memperbarui akun administrator SIGANA';

    public function handle(): int
    {
        $name = $this->ask('Nama admin', 'Administrator SIGANA');
        $email = strtolower(trim($this->ask('Email admin', 'admin@gmail.com')));

        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('Format email tidak valid.');
            return self::FAILURE;
        }

        $password = $this->secret('Kata sandi admin');
        $confirmation = $this->secret('Ulangi kata sandi admin');

        if (strlen($password) < 8 || $password !== $confirmation) {
            $this->error('Kata sandi minimal 8 karakter dan kedua input harus sama.');
            return self::FAILURE;
        }

        User::query()->updateOrCreate(
            ['email' => $email],
            ['name' => $name, 'password' => Hash::make($password), 'role' => 'admin'],
        );

        $this->info("Akun admin {$email} siap digunakan.");
        return self::SUCCESS;
    }
}
