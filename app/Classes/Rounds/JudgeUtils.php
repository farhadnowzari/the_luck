<?php

namespace App\Classes\Rounds;

use App\Classes\Contests\ContestUtils;
use App\Contestant;
use App\Enums\GenreType;
use App\Enums\JudgeQuality;
use App\Genre;
use App\Judge;

class JudgeUtils {
    public static function getJudgeScore(Judge $judge, Genre $genre, float $rawScore, Contestant $contestant): float {

        if($judge->quality === JudgeQuality::FRIENDLY) {
            return self::friendlyJudgeScore($judge, $rawScore, $contestant);
        }
        if($judge->quality === JudgeQuality::HONEST) {
            return self::honestJudgeScore($rawScore);
        }
        if($judge->quality === JudgeQuality::MEAN) {
            return self::meanJudgeScore($rawScore);
        }
        if($judge->quality === JudgeQuality::RANDOM) {
            return self::randomJudgeScore();
        }
        if($judge->quality === JudgeQuality::ROCK) {
            return self::rockJudgeScore($genre, $rawScore);
        }
        return 0;
    }

    private static function friendlyJudgeScore(Judge $judge, float $rawScore, Contestant $contestant): float {
        if($contestant->pivot->sick) {
            return $judge->bonus_point;
        }
        if($rawScore > 3) {
            return 8;
        }
        return 7;
    }

    private static function honestJudgeScore(float $rawScore): float {
        $remaning = $rawScore % 10;
        $quotient = $rawScore / 10;
        if($remaning === 0) {
            return $quotient;
        }
        return intval($quotient) + 1;
    }

    private static function meanJudgeScore(float $rawScore): float {
        if($rawScore < 90) return 2;
        return 10;
    }

    private static function randomJudgeScore(): float {
        return ContestUtils::getRandomScore();
    }

    private static function rockJudgeScore(Genre $genre, float $rawScore): float {
        if($genre->type !== GenreType::ROCK) {
            return self::randomJudgeScore();
        }
        if($rawScore <= 50) {
            return 5;
        }
        if($rawScore > 50 && $rawScore <= 74.9) {
            return 8;
        }
        if($rawScore >= 75) {
            return 10;
        }
    }
}