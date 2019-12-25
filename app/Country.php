<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\State;

class Country extends Model
{
    public $table = 'tran_country';

    protected $fillable = [
    	'name'
    ];

    public function states()
    {
    	return $this->hasMany(State::class, 'countryid');
    }
	
	public static function searchCountryByName($q)
    {
		return self::select('id','name')->where('name','LIKE',"{$q}%")->get(); 
    }
}
