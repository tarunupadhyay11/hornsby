<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\State;

class City extends Model
{
    public $table = 'tran_city';

    protected $fillable = [
    	'name', 'stateid'
    ];

    public function state()
    {
    	return $this->belongsTo(State::class, 'stateid');
    }	
	
	public static function searchCityByName($q,$sid)
    {
		return self::select('id','name')->where('name','LIKE',"{$q}%")->where('stateid',$sid)->get(); 
    }
}
