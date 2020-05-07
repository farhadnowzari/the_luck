<?php

namespace App\Http\Controllers;

trait SessionHelper {
    public function getSessionId() {
        return request()->session()->getId();
    }

    public function getSessionIdFromHeader(): string {
        return request()->header('session_id');
    }
}