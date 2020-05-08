<?php

namespace App\Classes\Rounds;

use App\Classes\Contests\ContestUtils;
use App\Classes\Verify;
use App\Enums\RoundState;
use App\Round;
use Illuminate\Support\Facades\DB;

class RoundUtils {

    public static function validateBySessionId(int $roundId, string $sessionId): Round {
        $round = Round::with([
            'contest',
            'genre',
            'judges',
            'contestants.genres'
        ])
            ->where('id', $roundId)
            ->where('state', '!=', RoundState::FINISHED) //We dont want to do anything about finished rounds
            ->first();
        Verify::that($round !== null && $round->contest->session_id === $sessionId);
        return $round;
    }

    public static function evaluateRound(Round $round): Round {
        $round = DB::transaction(function () use($round) {
            $round->state = RoundState::FINISHED;
            $round->save();
            $round->contest->finished_rounds += 1;
            $round->contest->save();
            $contestants = [];
            $judges = $round->judges;
            foreach($round->contestants as $contestant) {
                $contestantScore = ScoreUtils::calculateRoundScore($round->genre_id, $contestant);
                $finalScore = ScoreUtils::calculateJudgementScore($contestantScore, $round->genre, $judges, $contestant);
                $sick = $contestant->pivot->sick;
                $contestants[$contestant->id] = [
                    'contestant_score' => $contestantScore,
                    'final_score' => $finalScore,
                    'sick' => $sick,
                ];
                $contestant->score += $finalScore;
                $contestant->save();
            }
            $round->contestants()->sync($contestants);
            return $round;
        });
        return $round;
    }

    public static function startRound(Round $round): Round {
        $round = DB::transaction(function () use($round) {
            $round->state = RoundState::STARTED;
            $round->save();
            //Lets set the sickness probability on contestants

            //** @var \App\Contestant $contestant */
            $contestants = [];
            foreach($round->contestants as $contestant) {
                $sick = ContestUtils::contestantGetsSick();
                $contestants[$contestant->id] = [
                    'sick' => $sick,
                    'contestant_score' => 0,
                    'final_score' => 0
                ];
            }
            $round->contestants()->sync($contestants);
            return $round;
        });
        return $round;
    }
}