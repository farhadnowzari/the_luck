<?php

use App\Enums\JudgeQuality;
use App\Judge;
use Illuminate\Database\Seeder;

class JudgeSeeder extends Seeder
{
    const JUDGES = [
        JudgeQuality::FRIENDLY => [
            'name' => 'Mark',
            'bonus_point' => 10
        ],
        JudgeQuality::HONEST => [
            'name' => 'Anita',
            'bonus_point' => 0
        ],
        JudgeQuality::MEAN => [
            'name' => 'Simon',
            'bonus_point' => 0
        ],
        JudgeQuality::RANDOM => [
            'name' => 'Sara',
            'bonus_point' => 0
        ],
        JudgeQuality::ROCK => [
            'name' => 'Jack',
            'bonus_point' => 0
        ]
    ];

    public function run()
    {
        foreach(self::JUDGES as $judgeQuality => $properties) {
            $judgeModel = new Judge();
            $judgeModel->bonus_point = $properties['bonus_point'];
            $judgeModel->name = $properties['name'];
            $judgeModel->quality = $judgeQuality;
            $judgeModel->save();
        }
    }
}
