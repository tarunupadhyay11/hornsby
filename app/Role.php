<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $table = 'tran_user_type';

    const ROLE_ADMIN = 'admin';
    const ROLE_RADIOLOGIST = 'radiologist';
    const ROLE_TRANSCRIBER = 'transcriber';
    const ROLE_REFERRER = 'referrer';
	
	public static function searchRolesByName($q)
    {
		return self::select('id','name')->where('name','LIKE',"{$q}%")->get(); 
    }	
}
