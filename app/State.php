<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\City;
use App\Country;

class State extends Model
{
    public $table = 'tran_state';

    public function cities()
    {
    	return $this->hasMany(City::class, 'stateid', 'id');
    }

    public function country()
    {
    	return $this->belongsTo(Country::class, 'countryid');
    }
	
	public static function searchStateByName($q,$cid)
    {
		return self::select('id','name')->where('name','LIKE',"{$q}%")->where('countryid',$cid)->get(); 
    }
}
