@extends('layouts.app')
@section('content')


    <div class="container">
        {{ Breadcrumbs::render('member.asset.edit', $campaign, $user) }}
        @if(session('message'))
            <p class="alert alert-info">{!! session('message') !!}</p>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h4>Editing the asset</h4>
        <h4>Campaign: {!! $campaign->name !!}</h4>
        <h4>Member: {!! $user->first_name.' '.$user->last_name !!}</h4>


        @foreach($asset->revisionHistory as $history )
            @if($history->key == 'created_at' && !$history->old_value)
                <li>{{ $history->userResponsible()->first_name }} created this resource at {{ $history->newValue() }}</li>
            @else
                <li>{{ $history->userResponsible()->first_name }} changed {{ $history->fieldName() }} from {{ $history->oldValue() }} to {{ $history->newValue() }}</li>
            @endif
        @endforeach

        <div class="card  mb-3" >

            <div class="card-header">
                {!! Form::open(['method' => 'DELETE','route' => ['assets.destroy', $asset->id, $campaign->id, $user->id],'style'=>'display:inline']) !!}
                {!! Form::submit('Delete', ['class' => 'btn btn-danger confirm', 'data-confirm' => 'Are you sure you want to delete?']) !!}
                {!! Form::close() !!}
            </div>

            <div class="card-body">

                <form action="{{ route('assets.update', $asset->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group" id="">
                        <label for="assetCaption">Caption text</label>
                        <textarea class="form-control" id="assetCaption" rows="3" name="caption">
                            {!! $asset->caption !!}
                        </textarea>
                    </div>

                    <div class="form-group">
                        <label for="typeSelect">File type</label>

                        <select class="form-control" id="typeSelect" name="type">
                            <option value="image">Image</option>
                            <option value="video">Video</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlFile1">File input</label>
                        <input type="file" name="file" class="form-control-file" id="exampleFormControlFile1">
                    </div>

                    <button type="submit" class="btn btn-info">Save</button>
                </form>

            </div>
        </div>
    </div>
@endsection
