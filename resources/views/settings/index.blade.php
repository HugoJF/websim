@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Settings</h1>

                {{ Form::open(['url' => route('profileSettingsSubmit')]) }}

                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="filter_answered_questions" value="1" {{ Setting::get('filter_answered_questions') ? 'checked' : '' }}>
                        Filter already answered questions:
                    </label>
                </div>

                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="filter_answered_tests" value="1" {{ Setting::get('filter_answered_tests') ? 'checked' : '' }}>
                        Filter already answered tests:
                    </label>
                </div>

                {{ Form::submit('Save settings', array('class' => 'btn btn-block btn-primary')) }}


                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection
