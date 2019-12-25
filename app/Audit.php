<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Audit extends Model
{
	protected $fillable = ['status','status_insert','userid','curr_date_time'];

	public $timestamps = false;
    public $table = 'tran_audit';
	
	public static $actions = [
	   'created'=>'Add User',
       'updated'=>'Update User',
	   'deleted'=>'Disable User',
	   'view_password'=>'View Password',
	   'reset_password'=>'Reset Password'
     ];
	 
	 public static function getActionByKey($key)
    {
		if (array_key_exists($key, self::$actions)) {
		   return self::$actions[$key];
		}
		else{
			return '';
		}
	}
	
	public static function getActionList()
    {
		   return self::$actions;
	}

}
