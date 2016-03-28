@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Create test</h1>

                {{ Form::open(['url' => 'test/create']) }}

                <div class="form-group">
                    {{ Form::label('Test name:') }}
                    {{ Form::text('test_name', null,  ['class' => 'form-control']) }}
                </div>

                {{ Form::submit('Create test', array('class' => 'btn btn-block btn-primary')) }}


                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection
