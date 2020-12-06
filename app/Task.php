<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tareas';

    protected $primaryKey = 'id';

    protected $fillable = ['id_proyecto', 'descripcion', 'comentario', 'estatus', 'fecha_inicio', 'fecha_final', 'fecha_limite', 'estado'];

    public $timestamps = false;


    public function project ()
    {
    	return $this->belongsTo('App\Project', 'id_proyecto');
    }

    // public function employee ()
    // {
    // 	return $this->belongsTo('App\User', 'id_empleado');
    // }

    public function getEstatusColorAttribute ()
    {
        if($this->estatus == 'E')
            return '<span class="badge badge-warning">En Espera</span>';

        if($this->estatus == 'P')
            return '<span class="badge badge-info">En Proceso</span>';

        return '<span class="badge badge-success">Completo</span>';
    }

    public function getFechaRegistroAttribute ($fecha_registro)
    {
        $fecha = new \DateTime($fecha_registro);

        return $fecha->format('Y-m-d');
    }

}
