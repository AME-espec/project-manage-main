<?php

namespace App;

use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class UsersTask extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users_task';

    protected $primaryKey = 'id';

    protected $fillable = ['id_tarea', 'user_id'];

    public $timestamps = true;

    public function user ()
    {
    	return $this->belongsTo('App\User', 'id');
    }

    public function task ()
    {
    	return $this->belongsTo('App\Task', 'id_tarea');
    }

    public static function employes($id)
    {
        $all = DB::table('users_task')->where('id_tarea', $id)->get();
        $result = null;$c=0;
        if($all)
            foreach($all as $a){
                
                $user = User::find($a->user_id);
              

                if( $c == count( $all ) - 1) { 

                    $result .= $user->name;

                }else{
                    $result .= $user->name . ", ";
                }
                $c++;
            }

        return $result;
    }

    public static function OneEmployee($id){

     $user = \App\UsersTask::where('user_id', '=', $id)->first();
        
     return $user;
    }
}
