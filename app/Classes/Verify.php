<?php

namespace App\Classes;

class Verify {

    public static function that(bool $condition, ?string $message = null): void {
        if(!$condition) {
            if($message !== null) {
                abort($message);
            } else {
                abort('Expected condition expected to be true');
            }
        }
    }
}