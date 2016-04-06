@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Reporting a question:</h1>

                {{ Form::open(['url' => route('questionsFlag')]) }}

                <div class="form-group">
                    {{ Form::label('Flagging reason') }}
                    {{ Form::text('flag_reason', null,  ['class' => 'form-control']) }}
                </div>

                <div class="form-group">
                    {{ Form::label('Details:') }}
                    {{ Form::textarea('flag_details', null, ['style' => 'width: 100%']) }}
                </div>

                {{ Form::submit('Submit report', array('class' => 'btn btn-block btn-primary')) }}


                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection
