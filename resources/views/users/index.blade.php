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
    {{ Breadcrumbs::render('users') }}
    <div>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </div>

    <div class="">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">

                            @can('create', 'App\Model\User')
                                <a class="btn btn-info float-left" href="{{ route('users.create') }}">Add user</a>
                            @endcan

                            <form class="d-flex float-right" action="{{ route('users.index') }}" method="GET">
                                <input class="form-control me-2"  placeholder="Search" aria-label="Search" name="search" value="{{$search}}">
                                <a  href="{{route('users.index')}}" class="btn bg-transparent" style="margin-left: -40px; z-index: 100;">
                                    <i class="fa fa-times"></i>
                                </a>
                            </form>

                        </div>
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col"></th>
                                        <th scope="col">@sortablelink('first_name', 'First name')</th>
                                        <th scope="col">@sortablelink('last_name', 'Last name')</th>
                                        <th scope="col">@sortablelink('username', 'Username')</th>
                                        <th scope="col">@sortablelink('email', 'Email')</th>
                                        <th scope="col">@sortablelink('role_id', 'Role')</th>
                                        <th scope="col">Campaign</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @if($users->count() === 0)
                                        <tr>
                                            <td>
                                                There are no users
                                            </td>
                                        </tr>
                                    @endif

                                        @foreach ($users as $user)
                                            @if($user->role->name == "Super-Admin")
                                                @php $class = "alert-danger" @endphp
                                            @elseif($user->role->name == "Client")
                                                @php $class = "alert-primary" @endphp
                                            @elseif($user->role->name == "Influencer")
                                                @php $class = "alert-success" @endphp
                                            @endif
                                            <tr class="{!! $class ?? '' !!}">
                                                <td></td>
                                                <td>{{ $user->first_name }}</td>
                                                <td>{{ $user->last_name }}</td>
                                                <td>{{ $user->username }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->role->name ?? '' }}</td>
                                                <td>
                                                    @foreach ($user->campaigns as $campaign)
                                                        <p><a href="{{route('campaigns.show', ['id' => $campaign->id])}} ">{{$campaign->name}}</a></p>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    <a class="btn btn-info" href="{{ route('users.show',$user->id) }}">View</a>
                                                    <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">Edit</a>

                                                    @if($user->role->name != "Super-Admin")
                                                    {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
                                                    {!! Form::submit('Delete', ['class' => 'btn btn-danger confirm', 'data-confirm' => 'Are you sure you want to delete?']) !!}
                                                    {!! Form::close() !!}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                {!! $users->onEachSide(3)->appends(Request::except('page'))->links('vendor.pagination.bootstrap-5') !!}

                            </div>

                            <p>
                                Displaying {{$users->count()}} of {{ $users->total() }} users(s).
                            </p>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
