<?php

namespace Database\Seeders;

use App\Models\Group;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $grades         = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11']; // 11 класів
        $signs          = ['А', 'Б', 'В', 'Г', 'Д']; // 5 варіантів
        $occupations    = ['Філологія', 'Українська мова', 'Математика', 'Технології', 'Історія']; // 5 напрямків

        foreach ($grades as $grade) {
            $numOfGroups = rand(3, 5);
            for ($i = 0; $i < $numOfGroups; $i++) {
                Group::create([
                    'grade'         => $grade,
                    'sign'          => $signs[array_rand($signs)],
                    'occupation'    => $occupations[array_rand($occupations)],
                ]);
            }
        }
    }
}
