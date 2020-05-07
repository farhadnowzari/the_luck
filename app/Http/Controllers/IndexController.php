<?php

namespace App\Http\Controllers;

use App\Classes\Contests\ContestStorage;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    use SessionHelper;
    public function index() {
        
        return view('index')->with([
            'sessionId' => $this->getSessionId()
        ]);
    }
}
