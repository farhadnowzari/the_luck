<?php

namespace App\Classes\Contests;

use App\Round;

class RoundViewModel {

    /** @var int $id */
    public $id;
    /** @var int $genreId */
    public $genreId;
    /** @var string $genreText */
    public $genreText;
    /** @var string $state */
    public $state;
    /** @var \Illuminate\Support\Collection $judges */
    public $judges;
    /** @var \Illuminate\Support\Collection $contestants */
    public $contestants;

    public function __construct(Round $model)
    {
        $this->id = $model->id;
        $this->genreId = $model->id;
        $this->genreText = trans('strings.'.$model->genre->type);
        $this->state = $model->state;
        $this->initJudges($model);
        $this->initContestants($model);
    }

    public static function build(Round $round): self {
        return new self($round);
    }

    private function initJudges(Round $model): void {
        $this->judges = $model->judges->map(function($judge) {
            return JudgeViewModel::build($judge);
        })->values();
    }

    private function initContestants(Round $model) {
        $this->contestants = $model
            ->contestants
            ->sortBy('id')
            ->map(function($contestant) {
                return ContestantViewModel::build($contestant);
            })->values();
    }

}