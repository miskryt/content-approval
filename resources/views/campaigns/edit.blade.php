@extends('layouts.app')


@section('content')

    <div class="container">
        {{ Breadcrumbs::render('campaigns.edit', $campaign) }}
        <div class="">
            @if(session('message'))
                <p class="alert alert-info">{!! session('message') !!}</p>
            @endif
            <h4>Campaign: {{($campaign->name)}} </h4>
        </div>
        <div class="card mb-3 " >

            <div class="card-header ">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                    Details
                </button>
            </div>

            <div class="card-body collapse accordion-collapse" id="collapseExample">
                {!! Form::open(['route' => ['campaigns.update', $campaign->id], 'method' => 'put']) !!}

                <div class="form-group @error("name") alert alert-danger @enderror">
                    <label>Campaign name</label>
                    {!! Form::text('name', $campaign->name, ['required', 'autocomplete'=>'off', 'class' => 'form-control']) !!}
                </div>

                <div class="form-group @error("description") alert alert-danger @enderror">
                    <label>Description</label>
                    {!! Form::text('description', $campaign->description, ['autocomplete'=>'off', 'class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    <label>Campaign status</label>
                    {!! Form::select('campaign_status_id', $statuses, $campaign->campaign_status_id,  ['class' => 'form-control']) !!}
                </div>

                <div class="form-group @error("long_description") alert alert-danger @enderror">
                    <label>Long Description</label>
                    {!! Form::textarea('long_description', $campaign->long_description, ['autocomplete'=>'off', 'class' => 'form-control']) !!}
                </div>

                <button class="btn btn-primary save" disabled type="submit">Save</button>

                {!! Form::close() !!}
            </div>
        </div>

        <div class="row">
            <div class="col-4">
                <h4>Campaign Clients (Owners)</h4>
            </div>
            <div class="col-8">
                <a href="{{route('campaigns.show', $campaign->id)}}" class="float-right">Members</a>
            </div>
        </div>


        <div class="card  mb-3" >
            <div class="card-header">

                <a type="button" class="btn btn-info" href="{{route('campaigns.addclients', $campaign->id)}}">Add clients</a>

                <form class="d-flex float-right" action="{{ route('campaigns.edit', $campaign->id) }}" method="GET">
                    <input class="form-control me-2" placeholder="Search" aria-label="Search" name="search" value="{{$search}}">
                    <a  href="{{route('campaigns.edit', $campaign->id)}}" class="btn bg-transparent" style="margin-left: -40px; z-index: 100;">
                        <i class="fa fa-times"></i>
                    </a>
                </form>

            </div>
            <div class="card-body">
                <form action="{{ route('campaigns.removeclients', $campaign->id) }}" method="POST">
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

                        @foreach($users as $user)
                            <tr>
                                <th scope="row">
                                    <!-- Default unchecked -->
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input select-item" name="user_id[]" value="{{$user->id}}" id="{{$user->id}}">
                                        <label class="custom-control-label" for="{{$user->id}}"></label>
                                    </div>
                                </th>
                                <td>{{$user->first_name}}</td>
                                <td>{{$user->last_name}}</td>
                                <td>{{$user->username}}</td>
                                <td>{{$user->email}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <button type="submit" class="btn btn-warning">Delete</button>
                </form>

                {!! $users->onEachSide(3)->appends(Request::except('page'))->links('vendor.pagination.bootstrap-5') !!}

                <p>
                    Displaying {{$users->count()}} of {{ $users->total() }} users(s).
                </p>
            </div>
        </div>

    </div>


@endsection
