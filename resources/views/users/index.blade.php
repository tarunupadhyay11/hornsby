@extends('layouts.backend')
@section('title', 'User Management')
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
	<div class="passwordvalue" style="color:red;font-size:20px;"></div>	
	<input type="hidden" value="{{ route('users.edit', ':id') }}" id="useredit">
	<div >	
	<a href="{{ route('users.create') }}" class="float-left mb-4 btn btn-primary btn-sm "> <i class="fas fa-plus"  aria-hidden="true"></i> Add New</a>	
	<table class="table cell-border " id="userdatatable"  style="width:100%" cellpadding="0"  cellspacing="0">
		<thead>
			<tr>
				<th>{{ __('Username') }}</th>
				<th>{{ __('First Name') }}</th>
				<th>{{ __('Last Name') }}</th>
				<th>{{ __('Display Name') }}</th>
				<th>{{ __('Email') }}</th>
				<th>{{ __('User Type') }}</th>
				<th>{{ __('Trans. per ref.') }}</th>
				<th>{{ __('Action') }}</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</div>
		</div>
	</div>
</div>
@endsection
@section('page_scripts')
<script src="{{ asset('/js/user-management.js') }}"></script>
@endsection