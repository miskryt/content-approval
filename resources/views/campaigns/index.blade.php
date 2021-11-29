@extends('layouts.app')

@section('content')
    <script>
        $(document).ready(function (){
            $('.confirm').on('click', function (e) {
                return !!confirm($(this).data('confirm'));
            });
        })
    </script>
    <div class="container">
        {{ Breadcrumbs::render('campaigns') }}
        <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Campaigns') }}
            </h2>
        </div>

        <div class="">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">


                                @can('create', 'App\Model\Campaign')
                                    <a class="btn btn-info float-left" href="{{ route('campaigns.create') }}">Add campaign</a>
                                @endcan

                                <form class="d-flex float-right" action="{{ route('campaigns.index') }}" method="GET">
                                    <input class="form-control me-2" placeholder="Search" aria-label="Search" name="search" value="{{$search}}">
                                    <a  href="{{route('campaigns.index')}}" class="btn bg-transparent" style="margin-left: -40px; z-index: 100;">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </form>

                            </div>

                            @if(session('message'))
                                <p class="alert alert-info">{!! session('message') !!}</p>
                            @endif


                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th scope="col"></th>
                                            <th scope="col">@sortablelink('name', 'Name')</th>
                                            <th scope="col">@sortablelink('campaign_status_id', 'Status')</th>
                                            <th scope="col">@sortablelink('description', 'Description')</th>
                                            <th scope="col">@sortablelink('long_description', 'Long Description')</th>
                                            <th scope="col"></th>
                                            <th scope="col"></th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @if($campaigns->count() === 0)
                                            <tr>
                                                <td>
                                                    There are no campaigns
                                                </td>
                                            </tr>
                                        @endif

                                        @foreach ($campaigns as $campaign)
                                            <tr>
                                                <td></td>
                                                <td>{{ $campaign->name }}</td>
                                                <td>{!! $campaign->statuses?->name !!}</td>
                                                <td>
                                                    <span data-toggle="tooltip" data-placement="top" title="{{$campaign->description}}">
                                                        {!! substr($campaign->description, 0, 30)."..." !!}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span data-toggle="tooltip" data-placement="top" title="{{$campaign->long_description}}">
                                                        {!! substr($campaign->long_description, 0, 30)."..." !!}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a class="btn btn-info" href="{{ route('campaigns.show',$campaign->id) }}">View</a>
                                                    <a class="btn btn-primary" href="{{ route('campaigns.edit',$campaign->id) }}">Edit</a>
                                                    {!! Form::open(['method' => 'DELETE','route' => ['campaigns.destroy', $campaign->id],'style'=>'display:inline']) !!}
                                                    {!! Form::submit('Delete', ['class' => 'btn btn-danger confirm', 'data-confirm' => 'Are you sure you want to delete?']) !!}
                                                    {!! Form::close() !!}
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>

                                    {!! $campaigns->onEachSide(3)->appends(Request::except('page'))->links('vendor.pagination.bootstrap-5') !!}

                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
