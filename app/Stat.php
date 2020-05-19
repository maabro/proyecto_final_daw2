<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stat extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $primaryKey = 'stat_id';
    protected $keyType = 'string';
    protected $table = 'stats';

    public function teamStats()
    {
        return $this->belongsTo('App\Team','stat_team','team_id');
    }

    public function matchStats()
    {
        return $this->belongsTo('App\Match','stat_match','match_id');
    }
}
