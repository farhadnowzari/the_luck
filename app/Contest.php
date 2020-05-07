<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contest extends Model
{
    public function contestants(): HasMany {
        return $this->hasMany(Contestant::class);
    }

    public function rounds(): HasMany {
        return $this->hasMany(Round::class);
    }
}
