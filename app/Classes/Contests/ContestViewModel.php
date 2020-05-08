<?php

namespace App\Classes\Contests;

use App\Contest;

class ContestViewModel {
    /** @var int $id */
    public $id;
    /** @var int $totalRounds */
    public $totalRounds;
    /** @var int $finishedRounds */
    public $finishedRounds;
    /** @var string $createdAt */
    public $createdAt;

    /** @var float $highestScore */
    public $highestScore;
    /** @var string $winnerName */
    public $winnerName;

    /** @var \Illuminate\Support\Collection $rounds */
    public $rounds;
    /** @var \Illuminate\Support\Collection $contestants */
    public $contestants;

    public function __construct(Contest $model)
    {
        $this->id = $model->id;
        $this->totalRounds = $model->total_rounds;
        $this->finishedRounds = $model->finished_rounds;
        $this->createdAt = $model->created_at->format('Y-m-d H:i:s');
        $this->initRounds($model);
        $this->initContestants($model);
        $this->setWinnerScore();
        
    }

    public static function build(Contest $model): self {
        return new self($model);
    }

    private function initRounds(Contest $model): void {
        $this->rounds = $model
            ->rounds
            ->sortBy('id')
            ->map(function($round) {
                return RoundViewModel::build($round);
            })
            ->values();
    }

    private function initContestants(Contest $model): void {
        $this->contestants = $model
            ->contestants
            ->sortByDesc('score')
            ->map(function($contestant) {
                return ContestantViewModel::build($contestant);
            })
            ->values();
    }

    private function setWinnerScore() {
        $winner = $this->contestants->sortByDesc('score')->first();
        $this->winnerName = $winner->name;
        $this->highestScore = $winner->score;
    }
}