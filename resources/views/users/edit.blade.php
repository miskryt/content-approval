@extends('layouts.app')

@section('content')


    <div class="container">
        <div>
            <h2 class="">
                {{ __('Users') }}
            </h2>
        </div>

        <div class="">
            <div class="">
                <div class="">
                    <div class="">
                        <div class="">
                            <div class="">
                                User editing
                            </div>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="card">
                                <div class="card-body">
                                    {!! Form::open(['route' => ['users.update', $user->id ?? 0], 'method' => 'put']) !!}

                                    <div class="text-center mb-4">
                                        <h1 class="h3 font-weight-normal">{{$user->name ?? 'New user'}}</h1>
                                        <p>Set user data and select a role</p>
                                    </div>

                                    <div class="form-group @error("first_name") alert alert-danger @enderror">
                                        <label>First Name</label>
                                        {!! Form::text('first_name', $user->first_name, ['required', 'autocomplete'=>'off', 'class' => 'form-control']) !!}
                                    </div>

                                    <div class="form-group @error("last_name") alert alert-danger @enderror">
                                        <label>Last Name</label>
                                        {!! Form::text('last_name', $user->last_name, ['required', 'autocomplete'=>'off', 'class' => 'form-control']) !!}
                                    </div>

                                    <div class="form-group @error("username") alert alert-danger @enderror">
                                        <label>Username</label>
                                        {!! Form::text('username', $user->username, ['required', 'autocomplete'=>'off', 'class' => 'form-control']) !!}
                                    </div>

                                    <div class="form-group @error("email") alert alert-danger @enderror">
                                        <label>Email</label>
                                        {!! Form::text('email', $user->email ?? '', ['required', 'autocomplete'=>'off', 'class' => 'form-control']) !!}
                                    </div>

                                    <div class="form-group @error("password") alert alert-danger @enderror">
                                        <label>Password</label>
                                        {!! Form::text('password', null, ['autocomplete'=>'off', 'id' => 'inputPassword', 'class' => 'form-control']) !!}
                                    </div>

                                    <div class="form-group">
                                        <label>Role</label>
                                        @if($user->role->name == "Super-Admin")
                                            {!! Form::select('role_id', $roles, $user?->role?->id,  ['class' => 'form-control', 'disabled']) !!}
                                        @else
                                            {!! Form::select('role_id', $roles, $user?->role?->id,  ['class' => 'form-control']) !!}
                                        @endif
                                    </div>

                                    <button class="btn btn-primary" type="submit">Save</button>

                                    {!! Form::close() !!}
                                </div>








                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
