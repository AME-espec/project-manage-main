<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'proyectos';

    protected $primaryKey = 'id_proyecto';

    protected $fillable = ['id_manager', 'nombre', 'descripcion'];

    public $timestamps = false;


    public function manager ()
    {
    	return $this->belongsTo('App\User', 'id_manager');
    }

    public function tasks ()
    {
    	return $this->hasMany('App\Task', 'id_proyecto');
    }

    public function getFechaRegistroAttribute ($created_at)
    {
        $fecha = new \DateTime($created_at);

        return $fecha->format('Y-m-d');
    }
}
