<?php

namespace App\Classes;

class Verify {

    public static function that(bool $condition, ?string $message = null): void {
        if(!$condition) {
            if($message !== null) {
                abort(400, $message);
            } else {
                abort(400, 'Expected condition expected to be true');
            }
        }
    }
}