<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeagueSeason extends Pivot
{
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string';
    protected $table = 'league_seasons';
}
