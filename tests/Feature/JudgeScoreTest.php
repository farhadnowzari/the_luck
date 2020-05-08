<?php

namespace Tests\Feature;

use App\Classes\Rounds\JudgeUtils;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class JudgeScoreTest extends TestCase
{
    public function testHonestJudgeScore() {
        $randomScore = rand(1, 1000) / 10;
        $score = JudgeUtils::honestJudgeScore($randomScore);
        if($randomScore >= .1 && $randomScore <= 10) {
            $this->assertEquals(1, $score);
        }
        if($randomScore >= 10.1 && $randomScore <= 20) {
            $this->assertEquals(2, $score);
        }
        if($randomScore >= 20.1 && $randomScore <= 30) {
            $this->assertEquals(3, $score);
        }
        if($randomScore >= 30.1 && $randomScore <= 40) {
            $this->assertEquals(4, $score);
        }
        if($randomScore >= 40.1 && $randomScore <= 50) {
            $this->assertEquals(5, $score);
        }
        if($randomScore >= 50.1 && $randomScore <= 60) {
            $this->assertEquals(6, $score);
        }
        if($randomScore >= 60.1 && $randomScore <= 70) {
            $this->assertEquals(7, $score);
        }
        if($randomScore >= 70.1 && $randomScore <= 80) {
            $this->assertEquals(8, $score);
        }
        if($randomScore >= 80.1 && $randomScore <= 90) {
            $this->assertEquals(9, $score);
        }
        if($randomScore >= 90.1 && $randomScore <= 100) {
            $this->assertEquals(10, $score);
        }
    }
}
