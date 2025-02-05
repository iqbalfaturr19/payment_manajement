<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userExists = DB::table('users')->where('email', 'admin@admin')->exists();

        if (!$userExists) {
            DB::table('users')->insert([
                'name' => 'Admin',
                'email' => 'admin@test.com',
                'password' => Hash::make('qweasd123'),
                'role' => 'admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            echo "Admin berhasil ditambahkan.\n";
        } else {
            echo "Admin sudah ada, seeder tidak dijalankan.\n";
        }
    }
}
