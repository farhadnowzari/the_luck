<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Contestant extends Model
{
    public function contest(): BelongsTo {
        return $this->belongsTo(Contest::class, 'contest_id', 'id');
    }

    public function genres(): BelongsToMany {
        return $this
            ->belongsToMany(Genre::class, 'contestant_genre', 'contestant_id', 'genre_id')
            ->withPivot(['strength_score']);
    }
}
