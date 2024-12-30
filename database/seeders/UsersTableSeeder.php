<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();

        // Specialization IDs from 1 to 25
        $specializations = range(1, 25);

        // Number of users per specialization
        $usersPerSpecialization = 3;

        foreach ($specializations as $specialization) {
            for ($i = 0; $i < $usersPerSpecialization; $i++) {
                DB::table('users')->insert([
                    'name' => $faker->name,
                    'MobileNumber' => $faker->regexify('[0-9]{10}'), // Generates a 10-digit number
                    'email' => $faker->unique()->safeEmail,
                    'Specialization' => $specialization,
                    'password' => Hash::make('password'), // Default password
                ]);
            }
        }
    }
}
