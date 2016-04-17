@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Searching questions</h1>

                {{ Form::open(['url' => route('questionsSearch'), 'method' => 'GET']) }}

                <div class="form-group">
                    {{ Form::label('Search:') }}
                    {{ Form::text('query', null,  ['class' => 'form-control']) }}
                </div>

                {{ Form::submit('Search', array('class' => 'btn btn-block btn-primary')) }}

                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection
