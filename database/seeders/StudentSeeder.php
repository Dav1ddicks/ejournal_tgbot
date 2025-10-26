<?php

namespace Database\Seeders;

use App\Models\Group;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Faker\Provider\Person;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Створення об'єкта Faker з українською локалізацією
        $faker = Faker::create('uk_UA');
        $groups = Group::all(); // Всі групи, які були створені в GroupSeeder

        foreach ($groups as $group) {
            $numOfStudents = rand(25, 30); // В кожній групі від 25 до 30 учнів
            for ($i = 0; $i < $numOfStudents; $i++) {
                // Вибір випадкового гендеру
                $gender = $faker->randomElement([Person::GENDER_MALE, Person::GENDER_FEMALE]);

                // Генерація даних студента
                $group->students()->create([
                    'first_name'    => $faker->firstName($gender), // Використовуємо метод firstName для генерації імені за гендером
                    'mid_name'      => $faker->middleName($gender), // Використовуємо middleName для по-батькові
                    'last_name'     => $faker->lastName, // Генерація прізвища
                ]);
            }
        }
    }
}
