<?php

namespace App;

use App\Task;
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
    public static function getPorcentaje($id){
        $pendiente = Task::where('id_proyecto' , $id)->count();
        $completadas =  Task::where(['id_proyecto' => $id,'estatus' => 'C'])->count();
       
        if($pendiente == 0 ){
            return 0;
        }else{
            $div =  $completadas / $pendiente ;
            return round($div * 100);
        }
       
    }
    public static function getColor($value){
        
        if($value < 21){
            return "bg-danger";
        }else if($value > 20 && $value < 41){
            return "bg-warning";
        }else if($value > 40 && $value < 61){
            return "bg-primary";
        }else if($value > 60 && $value < 81){
            return "bg-info";
        }else{
            return "bg->success";
        }
    }
}
