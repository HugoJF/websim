@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Summary:</h2>
                <ul>
                    <li>Total Questions: {{ $attempt->test->getQuestionAmount() }}</li>
                    <li>Correct answers: {{ $attempt->getCorrectAnswersAmount() }}</li>
                    <li>Incorrect answers: {{ $attempt->getIncorrectAnswersAmount() }}</li>
                    <li>Correct answer percentage: {{ ($attempt->getCorrectAnswersAmount() / $attempt->test->getQuestionAmount()) * 100 }}%</li>
                </ul>
            </div>
            <div class="col-md-12">
                <h2>Questions:</h2>
                @foreach($attempt->answers as $answer)
                    @include('partials.answer', [
                        'answer' => $answer,
                    ])
                @endforeach
            </div>
        </div>
    </div>
@endsection
