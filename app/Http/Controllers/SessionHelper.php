<?php

namespace App\Http\Controllers;

trait SessionHelper {
    public function getSessionId() {
        return request()->session()->getId();
    }
}