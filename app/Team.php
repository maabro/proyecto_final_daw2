<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
/**
 * Modelo para crear un equipo
 */
class Team extends Model
{
    /**
     * Desactiva el incremento de la id en la base de datos
     * @access public
     * @var Boolean 
     */
    public $incrementing = false;
    /**
     * Desactiva el campo timestamps
     * @access public
     * @var Boolean
     */
    public $timestamps = false;
    /**
     * Codigo del equipo
     * @access protected
     * @var String codigo del partido
     */
    protected $primaryKey = 'team_id';
    /**
     * Indica el tipo de clave primaria
     * @access protected
     * @var String tipo de clave primaria
     */
    protected $keyType = 'string';
    /**
     * Indica la tabla a la que pertenece el modelo en la base de datos
     * @access protected
     * @var String nombre de la tabla
     */
    protected $table = 'teams';
    /**
     * Relaciona la tabla leagues con la tabla teams
     */
    public function league()
    {
        return $this->belongsTo('App\League','team_league_id','league_id');
    }
    /**
     * Relaciona la tabla matches con la tabla teams para un equipo como local
     */
    public function homeTeamMatch()
    {
        return $this->hasMany('App\Match','match_ht',$this->primaryKey);
    }
    /**
     * Relaciona la tabla matches con la tabla teams para un equipo como visitante
     */
    public function awayTeamMatch()
    {
        return $this->hasMany('App\Match','match_at',$this->primaryKey);
    }
    /**
     * Relaciona la tabla stats con la tabla teams
     */
    public function statsTeams()
    {
        return $this->hasMany('App\Stat','stat_team',$this->primaryKey);
    }
}