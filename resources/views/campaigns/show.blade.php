@extends('layouts.app')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('campaigns.view', $campaign) }}
        @if(session('message'))
            <p class="alert alert-info">{!! session('message') !!}</p>
        @endif
        <h4>Campaign: {!! $campaign->name !!}</h4>
        <div class="card mb-3 " >
            <div class="card-header">

            </div>
            <div class="card-body">
                <table class="table">
                    <tbody>
                    <tr>
                        <td>CLIENTS</td>
                        <td>
                            @if($campaign->getOwners())
                                @foreach($campaign->getOwners() as $client)
                                    <a href="/users/show/{{$client->id}}">{!! $client->first_name.' '.$client->last_name !!} </a>,&nbsp;
                                @endforeach
                            @else
                                Not assigned yet
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>DESCRIPTION</td>
                        <td>{!! $campaign->description !!}</td>
                    </tr>
                    <tr>
                        <td>STATUS</td>
                        <td>{!! $campaign->statuses->name !!}</td>
                    </tr>
                    <tr>
                        <td>LONG DESCRIPTION</td>
                        <td>{!! $campaign->long_description !!}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>


        <div class="row">
            <div class="col-4">
                <h4>Campaign Members (Influencers)</h4>
            </div>
            <div class="col-8">
                <a href="{{route('campaigns.edit', $campaign->id)}}" class="float-right">Clients</a>
            </div>
        </div>


        <div class="card  mb-3" >
            <div class="card-header">

                @can('addMembers', App\Models\Campaign::class)
                <a type="button" class="btn btn-info" href="{{route('campaigns.addmembers', $campaign->id)}}">Add members</a>
                @endcan

                <form class="d-flex float-right" action="{{ route('campaigns.show', $campaign->id) }}" method="GET">
                    <input class="form-control me-2" placeholder="Search" aria-label="Search" name="search" value="{{$search}}">
                    <a  href="{{route('campaigns.show', $campaign->id)}}" class="btn bg-transparent" style="margin-left: -40px; z-index: 100;">
                        <i class="fa fa-times"></i>
                    </a>
                </form>

            </div>
            <div class="card-body">
                <form action="{{ route('campaigns.removemembers', $campaign->id) }}" method="POST">
                    @csrf
                    <table class="table">
                        <thead>
                        <tr>
                            @can('removeMembers', App\Models\Campaign::class)
                            <th scope="col" >
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="select_all">
                                    <label class="custom-control-label" for="select_all">Select all</label>
                                </div>
                            </th>
                            @endcan
                            <th scope="col">@sortablelink('first_name', 'First name')</th>
                            <th scope="col">@sortablelink('last_name', 'Last name')</th>
                            <th scope="col">@sortablelink('username', 'Username')</th>
                            <th scope="col">@sortablelink('email', 'Email')</th>
                            <th scope="col">Assets</th>
                        </tr>
                        </thead>
                        <tbody>

                        @if($users->count() === 0)
                            <tr>
                                <td>
                                    There are no members
                                </td>
                            </tr>
                        @endif
                        @foreach($users as $user)
                        <tr>
                            @can('removeMembers', App\Models\Campaign::class)
                            <th scope="row">
                                <!-- Default unchecked -->
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input select-item" name="user_id[]" value="{{$user->id}}" id="{{$user->id}}">
                                    <label class="custom-control-label" for="{{$user->id}}"></label>
                                </div>
                            </th>
                            @endcan
                            <td>{{$user->first_name}}</td>
                            <td>{{$user->last_name}}</td>
                            <td>{{$user->username}}</td>
                            <td>{{$user->email}}</td>
                            <td><a class="" href="{{route('campaigns.showMemberAssets', [$campaign->id, $user->id])}}">Assets</a></td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>

                    @can('removeMembers', App\Models\Campaign::class)
                    <button type="submit" class="btn btn-warning">Delete</button>
                    @endcan
                </form>

                {!! $users->onEachSide(3)->appends(Request::except('page'))->links('vendor.pagination.bootstrap-5') !!}

                <p>
                    Displaying {{$users->count()}} of {{ $users->total() }} users(s).
                </p>
            </div>
        </div>
    </div>
@endsection
