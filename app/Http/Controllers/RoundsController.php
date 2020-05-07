<?php

namespace App\Http\Controllers;

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
        return response()->json($contest);
    }
}
