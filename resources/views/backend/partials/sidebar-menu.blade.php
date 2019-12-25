<!-- Sidebar -->
<ul class="sidebar navbar-nav toggled">
	
	@if(auth()->user()->hasRole('admin'))
	<li class="nav-item">
		<a class="nav-link" href="{{ route('users.index') }}">
			<i class="fas fa-fw fa-users"></i>
			<span>User Management</span>
			<span class="badge badge-info">{{ \App\User::all()->count() }}</span>
		</a>
	</li>
	@endif
</ul>