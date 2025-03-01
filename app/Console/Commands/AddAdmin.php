<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class AddAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To add Admin via command line';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->ask('Masukan Nama Admin');
        $email = $this->ask('Masukan Email Admin');
        $password = $this->ask('Masukan Password Admin');

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $user->assignRole('admin');

        $this->info('Admin berhasil ditambahkan 🎉');
    }
}
