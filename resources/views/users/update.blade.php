@extends('layouts.app')

@section('content')
<div class="container">
	@if(session()->has('status'))
		<p class="alert alert-info">
			{{	session()->get('status') }}
		</p>
	@endif
    <div class="col-sm-6 col-sm-offset-3">
    	<div class="panel panel-default">
    		<div class="panel-heading">
    			Edit User
    		</div>
    		<div class="panel-body">
				{{ Form::model($user, ['url' => route('users.store') .'/'. $user->id , 'method' => 'PUT' ]) }}
					@if (isset($errors) && (count($errors) > 0))
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-group">
                        {{ Form::label('name', 'Name') }} <em>*</em>
                        {{ Form::text('name', null, ['class' => 'form-control', 'id' => 'name', 'required' => 'required']) }}
                    </div>

                    <div class="form-group">
                        {{ Form::label('email', 'Email') }} <em>*</em>
                        {{ Form::email('email', null, ['class' => 'form-control', 'id' => 'email']) }}
                    </div>
                
                    <div class="form-group">
                        {{ Form::label('public', 'Public') }}
                        {{ Form::hidden('public',0) }}
                        {{ Form::checkbox('public',1) }}
                    </div>

                    <div class="form-group">
                        {{ Form::submit('Submit', ['class' => 'btn btn-success']) }}
                    </div>
				{{ Form::close() }}
    		</div>
		</div>
	</div>
</div>
@endsection