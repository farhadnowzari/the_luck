<?php

namespace App\Http\Controllers;

use App\Classes\Contests\ContestViewModel;
use App\Classes\Contests\RoundViewModel;
use App\Classes\Rounds\RoundUtils;
use Illuminate\Http\Request;

class RoundsController extends Controller
{
    use SessionHelper;

    public function startRound(Request $request) {
        $sessionId = $this->getSessionIdFromHeader();
        $round = RoundUtils::validateBySessionId($request->roundId, $sessionId);
        $round = RoundUtils::startRound($round);
        $round->refresh();
        $round->loadMissing([
            'contest',
            'genre',
            'judges',
            'contestants.genres'
        ]);
        return response()->json(RoundViewModel::build($round));
    }

    public function evaluateRound(Request $request) {
        $sessionId = $this->getSessionIdFromHeader();
        $round = RoundUtils::validateBySessionId($request->roundId, $sessionId);
        $round = RoundUtils::evaludateRound($round);
        $round->refresh();
        $round->loadMissing('contest');
        $contest = $round->contest;
        $contest->loadMissing([
            'rounds.judges',
            'rounds.contestants',
            'contestants'
        ]);
        $contestViewModel = ContestViewModel::build($contest);
        return response()->json($contestViewModel);
    }
}
