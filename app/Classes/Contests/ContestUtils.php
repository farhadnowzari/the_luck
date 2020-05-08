<?php

namespace App\Classes\Contests;

use App\Contest;
use App\Judge;
use App\Round;

class ContestUtils 
{
    const NAMES = [
        'Farhad',
        'Kamran',
        'Keivan',
        'John',
        'Markus',
        'Sebastian',
        'Anna',
        'Julia',
        'Jenifer',
        'Geralt',
        'Dante',
        'Hooman',
        'Shirin',
        'Fariborz',
        'Babak',
        'Pooneh',
        'Pouya',
        'Baran',
        'Dimitri',
        'Dastan',
        'Frank',
        'Joey',
        'Ross',
        'Monica',
        'Rachel',
        'Phoebe',
        'Daniel',
        'Sepehr',
    ];

    public static function contestantGetsSick(): bool {
        $sicknessPercentage = intval(config('the_luck.sickness_probability'));
        $randomNumber = rand(0, 100);
        return $randomNumber <= $sicknessPercentage;
    }

    public static function getRandomName(): string {
        $namesLength = count(self::NAMES);
        $randomIndex = rand(0, $namesLength-1);
        return self::NAMES[$randomIndex];
    }

    public static function getRandomScore(): float {
        return rand(1, 100) / 10;
    }

    public static function canCreateContest(string $sessionId): bool {
        return self::retrieveOnGoingContest($sessionId) === null;
    }

    public static function retrieveOnGoingContest(string $sessionId): ?Contest {
        return Contest::whereRaw('total_rounds > finished_rounds')->where('session_id', $sessionId)->first();
    }
}