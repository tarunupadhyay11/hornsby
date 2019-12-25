<?php

namespace App\Http\Controllers;

use App\User;
use App\City;
use App\State;
use App\Country;
use App\Role;
use Illuminate\Http\Request;
use DB;
use Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
	 public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         return view('users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  
        $validatedData = $request->validate([
	        'firstname' => 'required',
			'lastname' => 'required',
			'displayname' => 'required',
			'cmb_user' => 'required|integer|min:0',
			'cmb_country' => 'required|integer|min:0',
			'state' => 'required|integer|min:0',
			'city' => 'required|integer|min:0',
			'username' => 'required|unique:tran_user|max:200',
			'password' => 'required'
		]);	
	
		User::insertUser($request);
		session()->flash('message', 'User Added Successfully!'); 
		session()->flash('alert-class', 'alert-success'); 
		return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $data['user'] = User::find($user->id);		
        return view('users.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {	
		User::updateUser($request);
		session()->flash('message', 'User Updated Successfully!'); 
		session()->flash('alert-class', 'alert-success'); 
		return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    public function getAll($type)
    {
        $users = User::getAllByType($type)->get();
        return $users;
    }
	
	public function getUsers(Request $request)
    { 		
		$result = User::getAllUsers();	
		return response()->json(['data' => $result], 200);       
    }
	
	public function ShowPassword(Request $request)
    { 
        if ($request->isMethod('post')) {
        	$id = $request->id;
			$user = User::getUserPasswordById($id);			  
			return response()->json(['status' => 'success','password' => $user->password_string], 200);   
        }
        else{
             return redirect()->back();
         }
    }
    
    public function ResetPassword(Request $request)
    { 
        if ($request->isMethod('post')) {
			$id = $request->id;
			$passwordStr = rand(100000, 999999);
			$password = Hash::make($passwordStr);
			$data = array('password'=>$password,'password_string'=>$passwordStr);
			User::updateUserById($id,$data);
            return response()->json(['status' => 'success','password' => $passwordStr], 200); 
        }
        else{
             return redirect()->back();
         }
    }
	
	public function changeStatus(Request $request)
    { 
        if ($request->isMethod('post')) {
			$id = $request->id;
			$status = $request->status;
			$data = array('block'=>$status);
			$user = User::updateUserById($id,$data);
            return response()->json(['status' => 'success','user' => $user], 200); 
        }
        else{
             return redirect()->back();
         }
    }
	
	public function getUsertypes(Request $request)
    { 
	   return Role::searchRolesByName($request->get('q'));       
    }
	
	public function getCountries(Request $request)
    { 
	   return Country::searchCountryByName($request->get('q'));         
    }
	
	public function getStates(Request $request)
    { 
	   return State::searchStateByName($request->get('q'),$request->cid);          
    }
	
	public function getCities(Request $request)
    {
	   return City::searchCityByName($request->get('q'),$request->sid);         
    }
	
	public function getTranscriber(Request $request)
    {  
        return User::searchUserByDisplayname($request->get('q'));       
    }
}
