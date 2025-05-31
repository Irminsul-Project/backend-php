<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KnowlageLavel;

class KnowlageLavelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $KnowlageLavels = [
            1 => [
                "code" => "Factual Knowledge",
                "order" => 1,
                "description" => "The basic elements students must know to be acquainted with a discipline or solve problems."
            ],
            2 => [
                "code" => "Conceptual Knowledge",
                "order" => 2,
                "description" => "The interrelationships among the basic elements within a larger structure that enable them to function together."
            ],
            3 => [
                "code" => "Procedural Knowledge",
                "order" => 3,
                "description" => "How to do something, methods of inquiry, and criteria for using skills, algorithms, techniques, and methods."
            ],
            4 => [
                "code" => "Metacognitive Knowledge",
                "order" => 4,
                "description" => "Knowledge of cognition in general, as well as awareness and knowledge of one's own cognition"
            ]
        ];

        foreach ($KnowlageLavels as $Id => $Data) {
            KnowlageLavel::updateOrCreate(["id" => $Id], $Data);
        }
    }
}
