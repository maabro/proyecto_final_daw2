<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
/**
 * Modelo para estadisticas
 */
class Stat extends Model
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
     * Codigo que identifica una estadistica
     * @access protected
     * @var String codigo estadistica
     */
    protected $primaryKey = 'stat_id';
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
    protected $table = 'stats';
    /**
     * Relaciona la tabla stats con la tabla teams
     */
    public function teamStats()
    {
        return $this->belongsTo('App\Team','stat_team','team_id');
    }
    /**
     * Relaciona la tabla stats con la tabla matches
     */
    public function matchStats()
    {
        return $this->belongsTo('App\Match','stat_match','match_id');
    }
}