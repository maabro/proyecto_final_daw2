<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class League extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $primaryKey = 'league_id';
    protected $keyType = 'string';
    protected $table = 'leagues';
    
    public function teams()
    {
        return $this->hasMany('App\Team');
    }
}
