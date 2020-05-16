<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
/**
 * 
 */
class Team extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $primaryKey = 'team_id';
    protected $keyType = 'string';
    protected $table = 'teams';

    public function league()
    {
        return $this->belongsTo('App\League');
    }
}
