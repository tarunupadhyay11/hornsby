<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Role;
use App\City;
use App\State;
use App\Country;
use Illuminate\Support\Facades\Hash;
use App\Events\User\Created;
use App\Events\User\Updated;;
use App\Events\User\Viewed;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'tran_user';

    /**
     * Do not user timestamps
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'middlename', 'lastname', 'display_name', 'email', 'password','default_transcriber','block','username','password_string',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
	
	protected $dispatchesEvents = [
        'created' => Created::class,
		'updated' => Updated::class,		
    ];

    public function role()
    {
        return $this->hasOne(Role::class, 'type', 'usertype');
    }
	
	public function city()
    {
        return $this->hasOne(City::class, 'id', 'city');
    }
	
	public function state()
    {
        return $this->hasOne(State::class, 'id', 'state');
    }
	
	public function country()
    {
        return $this->hasOne(Country::class, 'id', 'country');
    }	
	
	public function defaultTranscriber()
    {
        return $this->belongsTo(self::class, 'default_transcriber', 'id'); 
    }
	

    public function hasRole($roleName)
    {
        return $this->role->name === $roleName;
    }
    public static function allTranscribers()
    {
        return self::getAllByType(Role::ROLE_TRANSCRIBER)
            ->where('id', '!=', auth()->id())
            ->get();
    }

    public static function getAllByType($type)
    {
        $users = self::whereHas('role', function($query) use ($type) {
            $query->where('name', $type);
        })->with('role');

        return $users;
    }

    public static function allRadiologists()
    {
        return self::getAllByType(Role::ROLE_RADIOLOGIST)
            ->get();
    }

    public static function getAllReferrers()
    {
        return self::getAllByType(Role::ROLE_REFERRER)
            ->get();
    }
	
	public static function updateUserById($id,$data)
    {
        return self::find($id)->update($data);
    }	
	
	public static function getAllUsers()
    {
		return self::with('role')->with('defaultTranscriber')
					->where('username','!=','admin')
					->where('id','!=','53')
					->orderBy('username')
					->get() ;
    }
	
	public function getCountryNameAttribute()
	{
		return Country::find("{$this->country}")?Country::find("{$this->country}")->name:'';
	}
	
	public function getStateNameAttribute()
	{
		return State::find("{$this->state}")?State::find("{$this->state}")->name:'';
	}
	
	public function getCityNameAttribute()
	{
		return City::find("{$this->city}")?City::find("{$this->city}")->name:'';
	}	
		
	public static function insertUser($request)
    {
		$user = new User;		
        $user->firstname = $request->firstname;
		$user->lastname = $request->lastname;
		$user->displayname = $request->displayname;
		$user->email = $request->email?$request->email:'';
		$user->usertype = $request->cmb_user;
	    $user->country = $request->cmb_country;
		$user->state = $request->state;
		$user->city = $request->city;
		$request->fax? $user->fax = $request->fax:'';
		$request->phone? $user->phone = $request->phone:'';
		$request->address? $user->office = $request->address:'';
		$user->username = $request->username;
		$user->password = Hash::make($request->password);
		$user->password_string = $request->password;
		$request->cmb_trans?$user->default_transcriber = $request->cmb_trans:0;
		$user->dictation_pool = $request->chk_dictation;
		$request->notes?$user->notes = $request->notes:'';
		$user->curr_date = date('m-d-Y H:i:s');
		$user->created_at = date("Y-m-d h:i:s");
        $user->save();	
        return  $user->id;		
	}
	
	public static function updateUser($request)
    {	
		$user = User::find($request->id);
        if($request->filled('firstname')) $user->firstname = $request->firstname;
        if($request->filled('lastname')) $user->lastname = $request->lastname;
        if($request->filled('displayname')) $user->displayname = $request->displayname;
		if($request->filled('email')) $user->email = $request->email;
		if($request->filled('cmb_user')) $user->usertype = $request->cmb_user;
		if($request->filled('cmb_country')) $user->country = $request->cmb_country;
		if($request->filled('state')) $user->state = $request->state;
		if($request->filled('city')) $user->city = $request->city;
		if($request->filled('fax')) $user->fax = $request->fax;
		if($request->filled('phone')) $user->phone = $request->phone;
		if($request->filled('address')) $user->office = $request->address;
		if($request->filled('username')) $user->username = $request->username;
		if($request->filled('password')) $user->password = Hash::make($request->password);
		if($request->filled('password')) $user->password_string = $request->password;
		if($request->filled('cmb_trans')) $user->default_transcriber = $request->cmb_trans;
		if($request->filled('chk_dictation')) $user->dictation_pool = $request->chk_dictation;
		if($request->filled('notes')) $user->notes = $request->notes;
		$user->curr_date = date('m-d-Y H:i:s');
		$user->created_at = date("Y-m-d h:i:s");
        $user->save();	
        return  $user->id;		
	}
	
	public static function getAllTranscriberList()
    {
		return self::select('id','displayname as name')->where('usertype',3)->get();
    }	
	
	public static function getUserPasswordById($id)
	{
	   $user = self::find($id);
	   // Then fire the event..
	   static::$dispatcher->dispatch(new Viewed($user));
	   return $user;
	}
	
	public static function getUserByUsername($username)
	{
	   $user = self::where('username',$username)->get()->first();
	   return $user;
	}
	
	public static function searchUserByDisplayname($q)
    {
		return self::select('id','displayname as name')->where('displayname','LIKE',"{$q}%")->where('usertype',3)->get(); 
    }
	  
}
