@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Create test</h1>

                {{ Form::model($question, ['url' => route('questionsEdit', ['question_id' => $question->id])]) }}

                <div class="form-group">
                    {{ Form::label('Question title:') }}
                    {{ Form::text('question_title', null,  ['class' => 'form-control']) }}
                </div>

                <h2>Possible alternatives</h2>

                <div class="form-group">
                    {{ Form::label('Alternative 1') }}
                    {{ Form::text('question_alternatives[0]', $question->getPossibleAnswers()[0], ['class' => 'form-control']) }}
                    {{ Form::label('Alternative 2') }}
                    {{ Form::text('question_alternatives[1]', $question->getPossibleAnswers()[1], ['class' => 'form-control']) }}
                    {{ Form::label('Alternative 3') }}
                    {{ Form::text('question_alternatives[2]', $question->getPossibleAnswers()[2], ['class' => 'form-control']) }}
                    {{ Form::label('Alternative 4') }}
                    {{ Form::text('question_alternatives[3]', $question->getPossibleAnswers()[3], ['class' => 'form-control']) }}
                    {{ Form::label('Alternative 5') }}
                    {{ Form::text('question_alternatives[4]', $question->getPossibleAnswers()[4], ['class' => 'form-control']) }}
                </div>

                <h2>Correct Alternative</h2>

                <div class="form-group">
                    {{ Form::select('correct_alternative', [
                        0 => 'Alternative 1',
                        1 => 'Alternative 2',
                        2 => 'Alternative 3',
                        3 => 'Alternative 4',
                        4 => 'Alternative 5',
                    ], $question->getInformationAsJson()->correctAnswer, ['class' => 'form-control']) }}
                </div>

                <h2>Category</h2>

                <div class="form-group">
                    {{ Form::select('category_id', $categories, null, ['class' => 'form-control']) }}
                </div>

                {{ Form::submit('Submit question', array('class' => 'btn btn-block btn-primary')) }}


                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection
