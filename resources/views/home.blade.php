@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Welcome, {{ Auth::user()->name }}</h1>

                <br>

                <div class="row">
                    @forelse($test_attempts as $test_attempt)
                        <div class="col-md-6">
                            <div class="jumbotron">
                                <h2>Unfinished attempt</h2>

                                <p>You started test {{ $test_attempt->test->name }} and still didn't finish</p>

                                <p><a class="btn btn-primary btn-lg" href="{{ $test_attempt->getViewURL() }}"
                                      role="button">Continue</a></p>
                            </div>
                        </div>
                    @empty
                        <div class="col-md-12">
                            <div class="jumbotron">
                                <h2>Start a test</h2>

                                <p>Attempt to finish a test </p>

                                <p><a class="btn btn-primary btn-lg" href="{{ route('testIndex') }}" role="button">Go to
                                        test list</a></p>
                            </div>
                        </div>
                    @endforelse

                    <div class="col-md-12">
                        <div class="jumbotron">
                            <h2>Statistics</h2>

                            <div class="row">
                                <div class="col-md-6">
                                    <p>There are <strong>{{ $testCount }}</strong> tests in our database.</p>

                                    <p>There are <strong>{{ $questionCount }}</strong> questions to solve.</p>
                                </div>
                                <div class="col-md-6">
                                    <p>There are <strong>{{ $userCount }}</strong> users registered.</p>

                                    <p>Already <strong>{{ $testAttemptCount }}</strong> tests solved.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
