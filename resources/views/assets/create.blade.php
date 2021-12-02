@extends('layouts.app')
@section('content')


    <div class="container">
        {{ Breadcrumbs::render('member.asset.create', $campaign, $user) }}
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
        <h4>Create an asset for {{($campaign->name)}} campaign</h4>
        <div class="card  mb-3" >

            <div class="card-header">

            </div>

            <div class="card-body">

                <form action="{{ route('assets.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="campaign_id" value="{{$campaign->id}}">
                    <input type="hidden" name="user_id" value="{{$user->id}}">

                    <div class="form-group @error("content_type") alert alert-danger @enderror" id="">
                        <label for="assetCaption">Content type</label>
                        <input type="text" class="form-control" name="content_type" placeholder="Instagram story, Instagram post, Facebook post, etc."/>
                    </div>

                    <div class="form-group @error("caption") alert alert-danger @enderror" id="">
                        <label for="assetCaption">Caption text</label>
                        <textarea class="form-control" id="assetCaption" rows="3" name="caption"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="typeSelect">File type</label>

                        <select class="form-control" id="typeSelect" name="file_type">
                            <option value="image">Image</option>
                            <option value="video">Video</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlFile1">File input</label>
                        <input type="file" name="file" class="form-control-file" id="exampleFormControlFile1">
                    </div>

                    <button type="submit" class="btn btn-info">Submit for approval</button>
                </form>

            </div>
        </div>
    </div>
@endsection
