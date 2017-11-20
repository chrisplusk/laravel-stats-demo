@extends('layouts.app')

@section('content')
<div class="container">
	@if(session()->has('status'))
		<p class="alert alert-info">
			{{	session()->get('status') }}
		</p>
	@endif
	<div class="panel panel-default">
		<div class="panel-heading">
			Users
			@can('create', \App\User::class)
                <a href="{{ route('users.create') }}" class="btn btn-success btn-xs">Add User</a>
            @endcan
		</div>
        @if (count($users))
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Admin</th>
                            <th>Created On</th>
                            <th>Last Updated</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        @can('view', $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->admin }}</td>
                            <td>{{ $user->created_at->format('m-d-Y') }}</td>
                            <td>{{ $user->updated_at->format('m-d-Y') }}</td>
                            <td>
                            @can('update', $user)
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-success btn-xs">Edit</a>
                                <a href="{{ route('users.show', $user->id) }}" class="btn btn-info btn-xs">View</a>
                                @can('delete', $user)
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline-block">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button class="btn btn-danger btn-xs" onclick="return confirm('Are you sure?')">
                                            <span>DELETE</span>
                                        </button>
                                    </form>
                                @endcan
                            @endcan
                            </td>
                        </tr>
                        @endcan
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="text-center">
                {{ $users->links() }}
            </div>
        @else
            <p class="alert alert-info">
                No Listing Found
            </p>
        @endif
	</div>
</div>
@endsection