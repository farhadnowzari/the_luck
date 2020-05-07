<?php

namespace App\Classes\Contests;

use App\Judge;

class JudgeViewModel {
    public $id;
    public $name;

    public function __construct(Judge $judge)
    {
        $this->id = $judge->id;
        $this->name = $judge->name;
    }

    public static function build(Judge $judge): self {
        return new self($judge);
    }
}