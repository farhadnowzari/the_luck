<?php

namespace App\Classes\Contests;

use App\Classes\Verify;
use App\Contest;
use App\Contestant;
use App\Enums\RoundState;
use App\Genre;
use App\Judge;
use App\Round;
use Illuminate\Support\Facades\DB;

class ContestStorage {

    const CONTEST_RELATIONS = [
        'rounds.judges',
        'rounds.contestants',
        'contestants.genres'
    ];
    /** @var \App\Contest $contest */
    private $contest;

    #region head
    public function __construct(string $sessionId)
    {
        DB::transaction(function () use($sessionId) {
            Verify::that($sessionId !== null);
        
            $this->contest = new Contest();
            $this->contest->session_id = $sessionId;
            $this->contest->finished_rounds = 0;
            $this->createRounds(); 
            $this->reloadContest();
            $this->createContestants();
            $this->reloadContest();
            $this->assignContestantsToRounds();
            $this->reloadContest();
            $this->setContestantsRoundsStrengthPoint();
        });
    }

    public static function store(string $sessionId): self {
        return new self($sessionId);
    }
    #endregion
    
    #region create dependencies
    /**
     * Create rounds and assign judges to each round.
     */
    private function createRounds(): void {
        $activeGenres = Genre::where('active', true)->get()->shuffle();
        $this->contest->total_rounds = $activeGenres->count();
        $this->contest->save();
        $judgesPerRound = config('the_luck.judges_per_round');
        $judges = Judge::all()->shuffle()->take($judgesPerRound);
        foreach($activeGenres as $activeGenre) {
            $round = new Round();
            $round->contest_id = $this->contest->id;
            $round->genre_id = $activeGenre->id;
            $round->state = RoundState::NOT_STARTED;
            $round->save();
            $round->loadMissing('judges');
            foreach($judges as $judge) {
                $round->judges()->attach($judge->id);
            }
        }
    }

    /**
     * Create contestants for the contest and assign them to each round
     */
    private function createContestants(): void {
        $contestantsCount = config('the_luck.contestants_per_contest');
        for($i = 0; $i < $contestantsCount; $i++) {
            $contestant = new Contestant();
            $contestant->name = ContestUtils::getRandomName();
            $contestant->contest_id = $this->contest->id;
            $contestant->score = 0;
            $contestant->save();
        }
    }

    /**
     * This function was used to assign random judges to each round after reading the test again,
     * I realized that judges are selected randomly per contest and not per round.
     */
    /*
    private function assignJudgesToRound(Round $round): void {
        $judgesPerRound = config('the_luck.judges_per_round');
        $judges = Judge::all()->shuffle()->take($judgesPerRound);
        foreach($judges as $judge) {
            $round->judges()->attach($judge->id);
        }
    }
    */

    private function setContestantsRoundsStrengthPoint(): void {
        $rounds = $this->contest->rounds;
        $contestnats = $this->contest->contestants;
        /** @var \App\Contestant $contestant */
        foreach($contestnats as $contestant) {
            foreach($rounds as $round) {
                $contestant->genres()->attach($round->genre_id, [
                    'strength_score' => ContestUtils::getRandomScore()
                ]);
            }
        }
    }

    private function assignContestantsToRounds(): void {
        $contestants = $this->contest->contestants;
        /** @var \App\Round $round */
        foreach($this->contest->rounds as $round) {
            foreach($contestants as $contestant) {
                $round->contestants()->attach($contestant->id, [
                    'sick' => false,
                    'contestant_score' => 0,
                    'final_score' => 0
                ]);
            }
        }
    }
    #endregion

    private function reloadContest(): void {
        $this->contest->refresh();
        $this->contest->loadMissing(self::CONTEST_RELATIONS);
    }

    public function get(): Contest {
        $this->reloadContest();
        return $this->contest;
    }
}