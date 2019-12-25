@extends('layouts.backend')
@section('title', 'Edit User')
@section('content')
@push('page_css')
 <link href="{{ asset('/css/_user_management.css') }}" rel="stylesheet">
@endpush	
<div class="container" style="width:100%;max-width:100%;">
<div class="row">
<div class="col">
@if(Session::has('message'))
<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
@endif
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="container-fluid">
<div class="row" style="padding: 50px 0px;">
<div class="col-md-3">
<div class="bg-color">
<div class="blocks">
<div class="profile" style="text-align:center; display:block;">
	<div class="left-cnt">
	   <h2>User Details <span><i class="fa fa-pencil-square-o" aria-hidden="true"></i></span> </h2>	  
	 </div>
</div>
</div>
<div class="blocks">
<table class="table table-bordered" style="margin-bottom: 10px;">
<tbody class="left-col right-col">
<tr> 
<th>Usertype:</th>
<td>{{ $user->role->name?ucfirst($user->role->name):''}}</td>
<td><button class="btn btn-sm" onclick="window.editTab(0)"><i class="fa fa-edit"></i></button></td>
</tr>
<tr>     
<th scope="col">First Name:</th>
<td>{{ ucfirst($user->firstname) }}</td>
<td><button class="btn btn-sm" onclick="window.editTab(1)"><i class="fa fa-edit"></i></button></td>
</tr>
<tr>
<th> Last Name:</th>
<td>{{ucfirst($user->lastname) }}</td>
<td><button class="btn btn-sm" onclick="window.editTab(2)"><i class="fa fa-edit"></i></button></td>
</tr>
<tr>
<th> Display Name:</th>
<td>{{ucfirst($user->displayname) }}</td>
<td><button class="btn btn-sm" onclick="window.editTab(3)"><i class="fa fa-edit"></i></button></td>
</tr>
<tr>
<th> Email:</th>
<td>{{$user->email}}</td>
<td><button class="btn btn-sm" onclick="window.editTab(4)"><i class="fa fa-edit"></i></button></td>
</tr>
<tr> 
<th>Fax:</th>
<td>{{$user->fax}}</td>
<td><button class="btn btn-sm" onclick="window.editTab(5)"><i class="fa fa-edit"></i></button></td>
</tr> 
<tr> 
<th>Country:</th>
<td>{{$user->country?ucfirst($user->country_name):''}}</td>
<td><button class="btn btn-sm" onclick="window.editTab(6)"><i class="fa fa-edit"></i></button></td>
</tr>
<tr>
<th>State:</th>
<td>{{$user->state?ucfirst($user->state_name):''}}</td>
<td><button class="btn btn-sm" onclick="window.editTab(7)"><i class="fa fa-edit"></i></button></td>
</tr>
<tr>
<th>City:</th>
<td>{{$user->city?ucfirst($user->city_name):''}}</td>
<td><button class="btn btn-sm" onclick="window.editTab(8)"><i class="fa fa-edit"></i></button></td>
</tr>
<tr>
<th>Address:</th>
<td>{{ ucfirst($user->office) }}</td>
<td><button class="btn btn-sm" onclick="window.editTab(9)"><i class="fa fa-edit"></i></button></td>
</tr>
<tr>
<th>Default Transcriber:</th>
<td>{{ $user->default_transcriber?ucfirst($user->defaultTranscriber->displayname):'' }}</td>
<td><button class="btn btn-sm" onclick="window.editTab(10)"><i class="fa fa-edit"></i></button></td>
</tr>
<tr>
<th>Phone:</th>
<td>{{$user->phone}}</td>
<td><button class="btn btn-sm" onclick="window.editTab(11)"><i class="fa fa-edit"></i></button></td>
</tr>
<tr>
<th>Dictation Pool:</th>
<td> @if($user->dictation_pool==1) Yes  @else  No @endif</td>
<td><button class="btn btn-sm" onclick="window.editTab(12)"><i class="fa fa-edit"></i></button></td>
</tr>
<tr>
<th>Note:</th>
<td>{{ucfirst($user->notes)}} </td>
<td><button class="btn btn-sm" onclick="window.editTab(13)"><i class="fa fa-edit"></i></button></td>
</tr>
<tr>
<th>Username:</th>
<td>{{$user->username}}</td>
<td><button class="btn btn-sm" onclick="window.editTab(14)"><i class="fa fa-edit"></i></button></td>
</tr>
<tr>
<th>Password:</th>
<td>&nbsp;</td>
<td><button class="btn btn-sm" onclick="window.editTab(15)"><i class="fa fa-edit"></i></button></td>
</tr>
</tbody>
</table>
</div>
</div>
</div><!---md4 end-->
<div class="col-md-6">
<div class="field-block">
<form id="regForm" action="{{ route('users.update',['id'=>$user->id]) }}" method="POST" name="frm"  class="new-haf" enctype="multipart/form-data">
{!! csrf_field() !!}
<input name="_method" type="hidden" value="PATCH">
<input type="hidden" value="{{ route('users.edit', ':id') }}" id="useredit">
<input type="hidden" value="{{ $user->country }}" id="usercountryval" >
<input type="hidden" value="{{$user->state}}" id="userstateval" >
<input type="hidden" value="1" id="editView" >
<!-- One "tab" for each step in the form: -->
<div class="tab"> 
<h4 class="align-center">Choose a User <span>Type</span></h4>
<p class="ui-widget">
<input id="usertypes" value="{{$user->role->name?ucfirst($user->role->name):''}}" class=" form-control" placeholder="User type" oninput="this.className = ''"  type="text" autocomplete="off"  name="usertypeu">
<input id="usertypesval" value="{{$user->usertype}}" class=" form-control" name="cmb_user"   type="hidden" autocomplete="off">
</p>
<hr>
</div>
<div class="tab"> 
<h4 class="align-center">Enter your <span>First</span> Name </h4>
<p><input class=" form-control" placeholder="First name" value="@if(!empty($user->firstname)){{ucfirst(trim($user->firstname))}} @endif" oninput="this.className = ''" name="firstname" type="text" autocomplete="off"  autofocus>
<input type="hidden" name="id" value="{{$user->id}}">
<!--<input type="hidden" name="chk_dictation" value="{{ $user->dictation_pool }}" >!-->
<input type="hidden" name="chk_dictation" value="0">
</p>
<hr>
</div>
<div class="tab"> 
<h4 class="align-center">Enter your <span>Last</span> Name</h4>
<p><input class=" form-control" placeholder="Last name" value="@if(!empty($user->lastname)){{ucfirst(trim($user->lastname))}}@endif" oninput="this.className = ''" name="lastname" type="text" autocomplete="off"  autofocus></p>
<hr>
</div>
<div class="tab"> 
<h4 class="align-center">Enter your <span>Display</span> Name</h4>
<p><input class=" form-control" placeholder="Display name" oninput="this.className = ''" value="@if(!empty($user->displayname)){{ucfirst(trim($user->displayname))}} @endif" name="displayname" type="text" autocomplete="off" ></p>
<hr>
</div>

<div class="tab"> 
<h4 class="align-center">Enter Your <span>Email</span> Address</h4>
<p><input class=" form-control" placeholder="Email" value="@if(!empty($user->email)){{trim($user->email)}}@endif"  oninput="this.className = ''" name="email" type="email" autocomplete="off" ></p>
<hr>
</div>

<div class="tab"> 
<h4 class="align-center">Enter your <span>Fax </span> No.</h4>
<p><input class=" form-control" placeholder="Fax" value="@if(!empty($user->fax)){{$user->fax}}@endif" oninput="this.className = ''" name="txt_fax" type="number" autocomplete="off"  onKeyPress="if(this.value.length==10) return false;"></p>
<hr>
</div>

<div class="tab"> 
<h4 class="align-center">Choose a <span>Country</span></h4>
<p>  
<input id="country" value="{{$user->country?ucfirst(trim($user->country_name)):''}}" class=" form-control" placeholder="Country" oninput="this.className = ''"  type="text" autocomplete="off"  name="countryu">
<input id="countryval" value="{{$user->country}}" name="cmb_country" class=" form-control"   type="hidden" autocomplete="off">
 </p>
<hr>
</div>

<div class="tab"> 
<h4 class="align-center">Choose a <span>State</span></h4>
<p>  
<input id="state"  value="{{$user->state?ucfirst(trim($user->state_name)):''}}"  class=" form-control" placeholder="State" oninput="this.className = ''"  type="text" autocomplete="off"  name="stateu">
<input id="stateval" value="{{$user->state}}"  name="state" class=" form-control"   type="hidden" autocomplete="off">
</p>	
<hr>
</div>

<div class="tab"> 
<h4 class="align-center">Choose a <span>City</span></h4>
<p> 
<input id="city"  value="{{$user->city?ucfirst(trim($user->city_name)):''}}"  class=" form-control" placeholder="City" oninput="this.className = ''" type="text" autocomplete="off"  name="cityu">
<input id="cityval" value="{{$user->city}}" name="city" class=" form-control"   type="hidden" autocomplete="off">
</p>
<hr>
</div>

<div class="tab"> 
<h4 class="align-center">Enter your  <span>Address</span></h4>
<p>
<input class=" form-control" value="@if(!empty($user)){{ucfirst(trim($user->office))}}@endif"  placeholder="Address" oninput="this.className = ''" name="address"  type="text" >
</p>
<hr>
</div>

<div class="tab"> 
<h4 class="align-center">Choose a Defult <span>Trascriber</span></h4>
<p>  
<input id="trascriber" value="{{$user->default_transcriber?ucfirst(trim($user->defaultTranscriber->displayname)):''}}" class=" form-control" placeholder="Trascriber" oninput="this.className = ''" name="utrascriber"  type="text" autocomplete="off" >
<input id="trascriberval"  name="cmb_trans" value="{{$user->default_transcriber}}" class=" form-control" type="hidden" autocomplete="off">
</p>
<hr>
</div>

<div class="tab"> 
<h4 class="align-center">Enter your <span>Phone</span></h4>
<p> <input class=" form-control" value="@if(!empty($user->phone)){{$user->phone}}@endif"  placeholder="Phone" oninput="this.className = ''" name="phone" type="text" onchange="formatphone(this.value,this.name);" "> </p>
<hr>
</div>

<div class="tab"> 
<h4 class="align-center">Dictation <span> Pool</span></h4>
<p> <i style="float:left;"> Dictation Pool:</i><input class=" form-control" value="{{ $user->dictation_pool }}"  placeholder="Dictation Pool" oninput="this.className = ''" name="chk_dictation" type="checkbox"  style="width:10%;float:left;height: 22px;" @if($user->dictation_pool=='1')  checked="checked" @endif  autocomplete="off"> 
</p>
<hr>
</div>

<div class="tab"> 
<h4 class="align-center">Enter your <span>Note</span></h4>
<p><input  class=" form-control" value="@if(!empty($user->notes)){{ucfirst(trim($user->notes))}}@endif"  placeholder="Notes" oninput="this.className = ''" name="notes" type="text" autocomplete="off"></p>
<hr>
</div>


<div class="tab"> 
<h4 class="align-center">Enter your <span>User</span> name</h4>
<p><input  class=" form-control" value="@if($user){{trim($user->username)}}@endif"  placeholder="Username" oninput="this.className = ''" name="username" type="text" ></p>
<hr>
</div>


<div class="tab"> 
<h4 class="align-center">Change Your <span>Password</span></h4>
<p><input class=" form-control" placeholder="Change Password" oninput="this.className = ''" name="password" type="password" ></p>
</div>


<div style="overflow:auto;display:none" id="nextprediv">
<div class="nextprevbtn" style="text-align:center;" >
<button type="button" id="prevBtn" onclick="nextPrev(-1)">Back</button>
<button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
</div>
</div>
<!-- Circles which indicates the steps of the form: -->
<div style="text-align:center;margin-top:40px; display:none;">
<span class="step"></span>
<span class="step"></span>
<span class="step"></span>
<span class="step"></span>
<span class="step"></span>
<span class="step"></span>
<span class="step"></span>
<span class="step"></span>
<span class="step"></span>
<span class="step"></span>
<span class="step"></span>
<span class="step"></span>
<span class="step"></span>
<span class="step"></span>
<span class="step"></span>
<span class="step"></span>
</div>
</form>
</div>


</div><!---md8 end-->

</div><!---row end-->
</div><!---container fluid end-->
</div>
</div>
</div>
@endsection		
@section('page_scripts')
<script src="{{ asset('/js/user-management.js') }}"></script>
<script>
window.editTab(0); 
</script>
@endsection	