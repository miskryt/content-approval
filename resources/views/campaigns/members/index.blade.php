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
                <h4>Your assets</h4>
            </div>
        </div>


        <div class="card  mb-3" >

            <div class="card-header">
                <a class="btn btn-info float-left" href="{{ route('member.asset.create', [$campaign->id, $user->id]) }}">Add asset</a>
            </div>

            <div class="card-body">

                <div class="card-columns">

                    @if($assets->count() === 0)
                        User has no assets
                    @endif

                    @foreach($assets as $asset)

                        <a href="{{route('assets.edit', [$asset->id, $campaign->id, $user->id])}}">
                            <div class="card" style="">

                                @if($asset->type === 'image')
                                    @if(!empty($asset->file))
                                        <img class="card-img-top" src="{{asset($asset->file)}}" alt="Card image cap">
                                    @endif
                                @else
                                    <video width="340" controls >
                                        <source src="{{asset($asset->file)}}">
                                    </video>
                                @endif

                                <div class="card-body">
                                    <p class="card-text">
                                        {!! $asset->caption !!}
                                    </p>

                                    <p class="card-text">
                                        <small class="text-muted">
                                            {{$asset->created_at}}
                                        </small>
                                    </p>

                                    <span class="badge badge-secondary">{{$asset->revisionHistory()->count()}} revisions</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
@endsection
