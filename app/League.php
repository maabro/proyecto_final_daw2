<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
/**
 * Modelo para crear una liga
 */
class League extends Model
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
     * Codigo de la liga
     * @access protected
     * @var String codigo de liga
     */
    protected $primaryKey = 'league_id';
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
    protected $table = 'leagues';
    /**
     * Relaciona la tabla leagues con teams
     */
    public function teams()
    {
        return $this->hasMany('App\Team','team_league_id',$this->primaryKey);
    }
    /**
     * Relaciona la tabla macthes con la tabla leagues
     */
    public function matches()
    {
        return $this->hasMany('App\Match','match_league',$this->primaryKey);
    }
}
