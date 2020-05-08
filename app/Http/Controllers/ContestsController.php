<?php

namespace App\Http\Controllers;

use App\Classes\Contests\ContestStorage;
use App\Classes\Contests\ContestUtils;
use App\Classes\Contests\ContestViewModel;
use App\Contest;
use Illuminate\Http\Request;

class ContestsController extends Controller
{
    use SessionHelper;

    const RELATIONS = [
        'rounds.judges',
        'rounds.contestants',
        'contestants'
    ];
    
    public function createContest(Request $request) {
        $sessionId = $this->getSessionIdFromHeader();
        if(ContestUtils::canCreateContest($sessionId)) {
            ContestStorage::store($sessionId);
            return response()->json();
        } else {
            abort(400, 'Having more that one ongoing contests is not allowed');
        }
    }

    public function listOldContests(Request $request) {
        $sessionId = $this->getSessionIdFromHeader();
        $contests = Contest::with(self::RELATIONS)
            ->orderBy('created_at')
            ->whereRaw('total_rounds = finished_rounds')
            ->where('session_id', $sessionId)
            ->get()
            ->map(function($contest) {
                return ContestViewModel::build($contest);
            })
            ->values();
        $highestScoreContest = $contests->sortByDesc('highestScore')->first();
        return response()->json([
            'contests' => $contests,
            'winnerOfAllTimes' => [
                'winnerName' => $highestScoreContest->winnerName ?? null,
                'score' => $highestScoreContest->highestScore ?? null,
                'createdAt' => $highestScoreContest->createdAt ?? null 
            ]
        ]);
    }

    public function retrieveOpenContest(Request $request) {
        $sessionId = $this->getSessionIdFromHeader();
        $openContest = ContestUtils::retrieveOnGoingContest($sessionId);
        if($openContest !== null) {
            $openContest->loadMissing(self::RELATIONS);
            return response()->json(ContestViewModel::build($openContest));
        }
        return response()->json();
    }
}
