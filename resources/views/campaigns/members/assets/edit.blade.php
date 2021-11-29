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
        <div class="card  mb-3" >

            <div class="card-header">
                @foreach($asset->revisionHistory as $history )
                    <li>{{ $history->userResponsible()->first_name }} changed {{ $history->fieldName() }} from {{ $history->oldValue() }} to {{ $history->newValue() }}</li>
                @endforeach
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
