<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
/**
 * Modelo para crea un partido
 */
class Match extends Model
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
     * Codigo del partido
     * @access protected
     * @var String codigo del partido
     */
    protected $primaryKey = 'match_id';
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
    protected $table = 'matches';
    /**
     * Relaciona la tabla matches con la tabla teams para un equipo como local
     */
    public function homeTeam()
    {
        return $this->belongsTo('App\Team','match_ht','team_id');
    }
    /**
     * Relaciona la tabla matches con la tabla teams para un equipo como visitante
     */
    public function awayTeam()
    {
        return $this->belongsTo('App\Team','match_at','team_id');
    }
    /**
     * Relaciona la tabla matches con la tabla stats
     */
    public function statsMatch()
    {
        return $this->hasMany('App\Stat','stat_match',$this->primaryKey);
    }
    /**
     * Relaciona la tabla leagues con la tabla matches
     */
    public function league()
    {
        return $this->belongsTo('App\League','match_league','league_id');
    }
}