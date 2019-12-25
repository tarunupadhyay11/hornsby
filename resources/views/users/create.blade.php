@extends('layouts.backend')
@section('title', 'Add User')
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
	   <h2>Add User <span><i class="fa fa-pencil-square-o" aria-hidden="true"></i></span> </h2>	  
	 </div>
</div>
</div>
<div class="blocks">
<table class="table" style="margin-bottom: 20px;" id="myformdetaildive">
<thead class="right-col">
<tr>
<th style="background: #fff !important;color:#000 !important;">Form detail:</th>
<td></td>
</tr>
</thead>
<tbody class="left-col right-col">
</tbody>
</table>
</div>
</div>
</div><!---md4 end-->
<div class="col-md-6">
<input type="hidden" value="{{ route('users.edit', ':id') }}" id="useredit">
<input type="hidden" value="" id="usercountryval" >
<input type="hidden" value="" id="userstateval" >
<input type="hidden" value="0" id="editView" >
<div class="field-block">
<form id="regForm" action="{{ route('users.store') }}" method="post" name="frm"   class="new-haf" enctype="multipart/form-data">
{{ csrf_field() }}
<input type="hidden" name="chk_dictation" value="0">
<!-- One "tab" for each step in the form: -->
<div class="tab"> 
<h4 class="align-center">Choose a User <span>Type</span></h4>
<p class="ui-widget">
<input id="usertypes" value="" class=" form-control usertype" placeholder="User type" oninput="this.className = ''"  type="text" autocomplete="off"  name="usertypeu">
<input id="usertypesval" value="" class=" form-control" name="cmb_user"   type="hidden" autocomplete="off">
</p>
<hr>
</div>
<div class="tab"> 
<h4 class="align-center">Enter Your  <span>First</span> Name </h4>
<p><input class=" form-control" placeholder="First name" value="" oninput="this.className = ''" name="firstname" type="text" autocomplete="off"  autofocus>
</p>
<hr>
</div>
<div class="tab"> 
<h4 class="align-center">Enter Your  <span>Last</span> Name</h4>
<p><input class=" form-control" placeholder="Last name" value="" oninput="this.className = ''" name="lastname" type="text" autocomplete="off"  autofocus></p>
<hr>
</div>
<div class="tab"> 
<h4 class="align-center">Enter Your  <span>Display</span> Name</h4>
<p><input class=" form-control" placeholder="Display name" oninput="this.className = ''" value="" name="displayname" type="text" autocomplete="off" ></p>
<hr>
</div>
<div class="tab"> 
<h4 class="align-center">Enter Your  <span>Email</span> Address</h4>
<p><input class=" form-control" placeholder="Email" value=""  oninput="this.className = ''" name="email" type="email" autocomplete="off" ></p>
<hr>
</div>
<div class="tab"> 
<h4 class="align-center">Enter Your  <span>Fax </span> No.</h4>
<p><input class=" form-control" placeholder="Fax" value="" oninput="this.className = ''" name="txt_fax" type="number" autocomplete="off"  onKeyPress="if(this.value.length==10) return false;"></p>
<hr>
</div>
<div class="tab"> 
<h4 class="align-center">Choose a <span>Country</span></h4>
<p>  
<input id="country" value="" class=" form-control" placeholder="Country" oninput="this.className = ''"  type="text" autocomplete="off"  name="countryu">
<input id="countryval" value=""  class=" form-control" name="cmb_country"   type="hidden" autocomplete="off">
 </p>
<hr>
</div>
<div class="tab"> 
<h4 class="align-center">Choose a <span>State</span></h4>
<p>  
<input id="state"  value=""  class=" form-control" placeholder="State" oninput="this.className = ''"  type="text" autocomplete="off"  name="stateu">
<input id="stateval" value=""  name="state" class=" form-control"   type="hidden" autocomplete="off">
</p>	
<hr>
</div>
<div class="tab"> 
<h4 class="align-center">Choose a <span>City</span></h4>
<p> 
<input id="city"  value=""  class=" form-control" placeholder="City" oninput="this.className = ''" type="text" autocomplete="off"  name="cityu">
<input id="cityval" value="" name="city" class=" form-control"   type="hidden" autocomplete="off">
</p>
<hr>
</div>
<div class="tab"> 
<h4 class="align-center">Enter Your  <span>Address</span></h4>
<p>
<input class=" form-control" value=""  placeholder="Address" oninput="this.className = ''" name="address"  type="text" autocomplete="off">
</p>
<hr>
</div>
<div class="tab"> 
<h4 class="align-center">Choose a Defult <span>Trascriber</span></h4>
<p>  
<input id="trascriber"  name="utrascriber" class=" form-control" placeholder="Trascriber" oninput="this.className = ''" type="text" autocomplete="off" >
<input id="trascriberval"  name="cmb_trans" value="" class=" form-control" type="hidden" autocomplete="off">
</p>
<hr>
</div>
<div class="tab"> 
<h4 class="align-center">Enter Your  <span>Phone</span></h4>
<p> <input class=" form-control" value=""  placeholder="Phone" oninput="this.className = ''" name="phone" type="text" autocomplete="off" onchange="window.formatphone(this.value,this.name);"  > </p>
<hr>
</div>
<div class="tab"> 
<h4 class="align-center">Dictation <span> Pool</span></h4>
<p> <i style="float:left;"> Dictation Pool:</i><input class=" form-control" value=""  placeholder="Dictation Pool" oninput="this.className = ''" name="chk_dictation" type="checkbox"  style="width:10%;float:left;height: 22px;"> 
</p>
<hr>
</div>
<div class="tab"> 
<h4 class="align-center">Enter Your  <span>Note</span></h4>
<p><input  class=" form-control" value=""  placeholder="Notes" oninput="this.className = ''" name="notes" type="text" autocomplete="off"></p>
<hr>
</div>
<div class="tab"> 
<h4 class="align-center">Enter Your  <span>User</span> name</h4>
<p><input  class=" form-control" value=""  placeholder="Username" oninput="this.className = ''" name="username" type="text" autocomplete="off"></p>
<hr>
</div>
<div class="tab"> 
<h4 class="align-center">Enter Your <span>Password</span></h4>
<p><input class=" form-control" placeholder="Enter your Password" oninput="this.className = ''" name="password" type="password" autocomplete="off"></p>
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
</div><!--- col end --->
</div>
</div>
@endsection		
@section('page_scripts')
<script src="{{ asset('/js/user-management.js') }}"></script>           
@endsection