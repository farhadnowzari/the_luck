<?php

namespace App\Classes\Rounds;

use App\Classes\Contests\ContestUtils;
use App\Contestant;
use App\Genre;
use Illuminate\Support\Collection;

class ScoreUtils {
    public static function calculateRoundScore(int $genreId, Contestant $contestant): float {
        $sick = $contestant->pivot->sick ?? false;
        $randomScore = ContestUtils::getRandomScore();
        $genre = $contestant->genres->where('id', $genreId)->first();
        //The null genre happens here if:
        //We change they way we are creating relations between contestant and genres.
        //Right now the relations are creating from the rounds not from the genres table directly.
        $genreStrengthScore = $genre->pivot->strength_score ?? 0;
        $contestantScore = $randomScore * $genreStrengthScore;
        if($sick) {
            $contestantScore = $contestantScore / 2;
            $contestantScore = round($contestantScore, 1);
        }
        return $contestantScore;
    }

    public static function calculateJudgementScore(float $rawScore, Genre $genre, Collection $judges, Contestant $contestant): float {
        $score = 0;
        foreach($judges as $judge) {
            $score += JudgeUtils::getJudgeScore($judge, $genre, $rawScore, $contestant);
        }
        return $score;
    }
}