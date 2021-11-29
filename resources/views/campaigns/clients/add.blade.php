@extends('layouts.app')
@section('content')


    <div class="container">
        {{ Breadcrumbs::render('campaigns.view.addclients', $campaign) }}
        @if(session('message'))
            <p class="alert alert-info">{!! session('message') !!}</p>
        @endif
        <h4>Add Clients (Owners) to {{($campaign->name)}}</h4>
        <div class="card  mb-3" >

            <div class="card-header">

                <form class="d-flex float-right" action="{{ route('campaigns.addclients', $campaign->id) }}" method="GET">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search" value="{{$search}}">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>

            </div>

            <div class="card-body">
                <form action="{{ route('campaigns.addclients', $campaign->id) }}" method="POST">
                    @csrf
                    <table class="table">
                    <thead>
                    <tr>
                        <th scope="col" >
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="select_all">
                                <label class="custom-control-label" for="select_all">Select all</label>
                            </div>
                        </th>
                        <th scope="col">@sortablelink('first_name', 'First name')</th>
                        <th scope="col">@sortablelink('last_name', 'Last name')</th>
                        <th scope="col">@sortablelink('username', 'Username')</th>
                        <th scope="col">@sortablelink('email', 'Email')</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>

                    @if($users->count() === 0)
                        <tr>
                            <td>
                                There are no clients
                            </td>
                        </tr>
                    @endif

                    @foreach ($users as $user)
                        <tr>
                            <th scope="row">
                                <!-- Default unchecked -->
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input select-item" name="user_id[]" value="{{$user->id}}" id="{{$user->id}}">
                                    <label class="custom-control-label" for="{{$user->id}}"></label>
                                </div>
                            </th>
                            <td>{{ $user->first_name }}</td>
                            <td>{{ $user->last_name }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                    <button type="submit" class="btn btn-info">Save</button>
                </form>

                {!! $users->onEachSide(3)->appends(Request::except('page'))->links('vendor.pagination.bootstrap-5') !!}

                <p>
                    Displaying {{$users->count()}} of {{ $users->total() }} users(s).
                </p>
            </div>
        </div>
    </div>
@endsection
