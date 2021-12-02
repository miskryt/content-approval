@extends('layouts.app')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('campaign.assets.view', $campaign, $user) }}
        @if(session('message'))
            <p class="alert alert-info">{!! session('message') !!}</p>
        @endif
        <h4>Campaign: {!! $campaign->name !!}</h4>
        <h4>Member: {!! $user->first_name.' '.$user->last_name !!}</h4>


        <div class="card  mb-3" >

            <div class="card-header">
                @can('create', App\Models\Asset::class)
                <a class="btn btn-info float-left" href="{{ route('member.asset.create', [$campaign->id]) }}">Add asset</a>
                @endcan
            </div>

            <div class="card-body">

                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">@sortablelink('content_type', 'Content type')</th>
                        <th scope="col">@sortablelink('created_at', 'Date')</th>
                        <th scope="col">@sortablelink('status', 'Status')</th>
                        <th scope="col">@sortablelink('revisions', 'Revisions')</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>

                    @if($assets->count() === 0)
                        <tr>
                            <td>
                                There are no assets
                            </td>
                        </tr>
                    @endif
                    @foreach($assets as $asset)
                        <tr>
                            <td>{{$asset->content_type}}</td>
                            <td>{{$asset->created_at}}</td>
                            <td>{{$asset->status->name}}</td>
                            <td>{{$asset->revisionHistory()->count()}}</td>
                            <td>
                                @if($asset->canBeOpened())
                                    <a class="" href="{{route('assets.show', [$asset->id, $campaign->id])}}">Open</a>
                                @else
                                    <span class="badge badge-primary">On review</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {!! $assets->onEachSide(3)->appends(Request::except('page'))->links('vendor.pagination.bootstrap-5') !!}

                <p>
                    Displaying {{$assets->count()}} of {{ $assets->total() }} asset(s).
                </p>

            </div>
        </div>

    </div>
@endsection
