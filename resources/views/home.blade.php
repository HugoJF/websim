@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Welcome, {{ Auth::user()->name }}</h1>

                <br>

                <div class="row">
                    @foreach($test_attempts as $test_attempt)
                        <div class="col-md-6">
                            <div class="jumbotron">
                                <h2>Unfinished attempt</h2>
                                <p>You started test {{ $test_attempt->test->name }} and still didn't finish</p>
                                <p><a class="btn btn-primary btn-lg" href="{{ $test_attempt->getViewURL() }}" role="button">Continue</a></p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
