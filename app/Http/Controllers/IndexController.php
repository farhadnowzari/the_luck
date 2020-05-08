<?php

namespace App\Http\Controllers;

class IndexController extends Controller
{
    use SessionHelper;
    public function index() {
        return view('index')->with([
            'sessionId' => $this->getSessionId()
        ]);
    }
}
