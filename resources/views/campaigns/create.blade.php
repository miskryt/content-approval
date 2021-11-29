@extends('layouts.app')


@section('content')

<div class="container">
    {{ Breadcrumbs::render('campaigns.create') }}
    <div>
        <h2 class="">
            {{ __('New Campaign') }}
        </h2>
    </div>

    <div class="">
        <div class="">
            <div class="">
                <div class="">
                    <div class="">

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="card">
                            <div class="card-body">
                                {!! Form::open(['route' => 'campaigns.store','class'=>'needs-validation', '']) !!}

                                    <div class="form-group @error("name") alert alert-danger @enderror">
                                        <label>Name</label>
                                        {!! Form::text('name', null, ['required', 'autocomplete'=>'off', 'class' => 'form-control']) !!}
                                    </div>

                                    <div class="form-group @error("name") alert alert-danger @enderror">
                                        {!! Form::hidden('user_id') !!}
                                        <span id="owner">
                                                Not assigned yet
                                        </span>
                                        <button data-toggle="modal" data-target="#owner_modal" type="button" class="btn btn-info">Assign owner</button>
                                    </div>

                                    <div class="form-group @error("name") alert alert-danger @enderror">
                                        <label>Description</label>
                                        {!! Form::text('description', null, ['autocomplete'=>'off', 'class' => 'form-control']) !!}
                                    </div>

                                    <div class="form-group">
                                        <label>Campaign status</label>
                                        {!! Form::select('campaign_status_id', $statuses, null,  ['class' => 'form-control']) !!}
                                    </div>

                                    <div class="form-group @error("name") alert alert-danger @enderror">
                                        <label>Long Description</label>
                                        {!! Form::text('long_description', null, ['autocomplete'=>'off', 'class' => 'form-control']) !!}
                                    </div>


                                <button class="btn btn-primary" type="submit">Save</button>

                                {!! Form::close() !!}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('campaigns.modal.owners_table')

@endsection
