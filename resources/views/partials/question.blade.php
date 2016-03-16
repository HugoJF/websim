<div class="panel panel-default panel-primary">

    <div class="panel-heading">
        <a class="panel-title">{{ $question->question_title }}</a>
    </div>

    {{ Form::open(['url' => 'answers/submit']) }}

    <div class="panel-body">
        <u><p>Question alternatives:</p></u>

        <div class="radio">

            @foreach($question->getInformationAsJson()->possibleAnswers as $index => $possibleAnswer)
                <label>
                    {{ Form::radio('answer', $index) }}

                    <p>{{ $possibleAnswer }}</p>
                </label>
                <br>

            @endforeach

        </div>

        {{ Form::hidden('question_id', $question->id) }}

        {{ Form::hidden('attempt_id', isset($attempt) ? $attempt->id : '') }}

        {{ Form::hidden('test_id', isset($attempt) ? $attempt->test->id : '') }}

        {{ Form::hidden('user_id', Auth::user()->id) }}

        @if(isset($skipQuestionPath))

            <a class="pull-right" href="{{ url($skipQuestionPath) }}">Skip this question</a>

        @endif


    </div>
    <div class="panel-footer">
        <a href="{{ url('questions/' . $question->id) }}">
            <p style="margin-bottom: 0px" class="text-center">Question made by {{ $question->user->name }}, scoring {{ $question->getScore() }} points</p>
        </a>

    </div>

    <div class="panel-footer clearfix">
        {{ Form::submit('Submit answer', array('class' => 'btn btn-block btn-primary')) }}
    </div>
    {{ Form::close()  }}

</div>