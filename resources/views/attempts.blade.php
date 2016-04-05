@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Welcome</div>

                    <div class="panel-body">
                        <ul>
                            @foreach($testAttempts as $attempt)
                                @if($attempt->finished == true)
                                    <li><a href="{{ $attempt->getResultURL() }}">Finished: {{$attempt->id}}</a></li>
                                @else
                                    <li>In-progress: {{$attempt->id}} - {{$attempt->getAnsweredQuestionsAmount()}} | {{$attempt->test->getQuestionAmount()}} | {{ HTML::link(route('attemptsContinue', ['attempt_id' => $attempt->id]), 'Continue') }}</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
