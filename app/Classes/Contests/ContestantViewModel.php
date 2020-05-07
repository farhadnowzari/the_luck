<?php

namespace App\Classes\Contests;

use App\Contestant;

class ContestantViewModel {
    /** @var int $id */
    public $id;
    /** @var string $name */
    public $name;
    /** @var float $score */
    public $score;
    /** @var bool $sick */
    public $sick = false;

    public function __construct(Contestant $model)
    {
        $this->id = $model->id;
        $this->name = $model->name;
        $this->score = $model->score;
        if(isset($model->pivot->sick)) {
            $this->sick = $model->pivot->sick;
        }
    }

    public static function build(Contestant $model): self {
        return new self($model);
    }
}