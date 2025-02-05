<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 25; $i++) {
            $name = $faker->name; 
            $email = Str::slug($name, '.') . '@example.com';

            DB::table('employees')->insert([
                'name' => $name,
                'email' => strtolower($email),
                'salary' => rand(3000000, 10000000),
                'position' => $faker->jobTitle,
                'address' => $faker->address,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
        echo "Karyawan berhasil ditambahkan.\n";
    }
}
