<?php

namespace Database\Seeders;

use App\Models\Group;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('uk_UA');
        $groups = Group::all(); // Всі групи, які були створені в GroupSeeder

        foreach ($groups as $group) {
            $numOfStudents = rand(25, 30); // В кожній групі від 25 до 30 учнів
            for ($i = 0; $i < $numOfStudents; $i++) {
                $group->students()->create([
                    'first_name'    => $faker->firstName,
                    'mid_name'      => $faker->firstName,
                    'last_name'     => $faker->lastName,
                ]);
            }
        }
    }
}
