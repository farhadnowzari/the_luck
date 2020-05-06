<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Round extends Model
{
    public function contest(): BelongsTo {
        return $this->belongsTo(Contest::class, 'contest_id', 'id');
    }

    public function genre(): BelongsTo {
        return $this->belongsTo(Genre::class, 'genre_id', 'id');
    }
    
    public function judges(): BelongsToMany {
        return $this->belongsToMany(Judge::class, 'round_judge', 'judge_id', 'round_id');
    }

    public function contestants(): BelongsToMany {
        return $this
            ->belongsToMany(Contestant::class, 'round_contestant', 'contestant_id', 'round_id')
            ->withPivot(['sick', 'contestant_score', 'final_score']);
    }
}
