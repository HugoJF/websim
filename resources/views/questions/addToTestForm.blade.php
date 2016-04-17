@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Add question to:</h1>
                <div class="list-group">
                    {{ Form::open() }}

                       @foreach($tests as $test)

                            <button type="submit" href="#" name="test_id" value="{{ $test->id }}" class="list-group-item">{{ $test->name }}</button>

                       @endforeach
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
