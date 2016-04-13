<div class="panel panel-default panel-primary">

    <div class="clearfix panel-heading">
        <a href="{{ route('questionsView', ['question_id' => $question->id]) }}" class="panel-title">{{ $question->question_title }}</a>
        <div class="pull-right" id="rating">

            {{ Form::open(['url' => route('questionsVote', ['question_id' => $question->id]), 'style' => 'display: inline']) }}
                {{ Form::hidden('direction', 'true') }}

                <button type="submit" class="btn btn-link">
                    <i style="color:{{ $question->getCurrentUserVote() != null && (bool) $question->getCurrentUserVote()->direction === true ? 'lime' : 'white' }}" class="fa fa-2x fa-thumbs-up"></i>
                </button>
            {{ Form::close() }}


            {{ Form::open(['url' => route('questionsVote', ['question_id' => $question->id]), 'style' => 'display: inline']) }}
                {{ Form::hidden('direction', 'false') }}

                <button type="submit" class="btn btn-link">
                    <i style="color:{{ $question->getCurrentUserVote() != null && (bool) $question->getCurrentUserVote()->direction === false ? 'red' : 'white' }}" class="fa fa-2x fa-thumbs-down"></i>
                </button>
            {{ Form::close() }}
            @if($question->isUserOwner(Auth::user()))
                <a href="{{ route('questionsEditForm', ['question_id' => $question->id]) }}" type="submit" class="btn btn-link">
                    <i style="color:white;" class="fa fa-2x fa-pencil"></i>
                </a>
            @endif

            <a href="{{ route('testsAddQuestionForm', ['question_id' => $question->id]) }}" type="submit" class="btn btn-link">
                <i style="color:white;" class="fa fa-2x fa-plus"></i>
            </a>

            <a href="{{ route('questionsFlagForm', ['question_id' => $question->id]) }}" type="submit" class="btn btn-link">
                <i style="color:white;" class="fa fa-2x fa-flag"></i>
            </a>

        </div>
    </div>

    {{ Form::open(['url' => route('answersSubmit')]) }}

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

        {{ Form::hidden('attempt_id', isset($attempt) ? $attempt->id : 'null') }}

        {{ Form::hidden('test_id', isset($attempt) ? $attempt->test->id : 'null') }}

        {{ Form::hidden('user_id', Auth::user()->id) }}

        @if(isset($skipQuestionPath))

            <a class="pull-right" href="{{ url($skipQuestionPath) }}">Skip this question</a>

        @endif


    </div>
    <div class="panel-footer">
        <a href="{{ route('questionsView', ['question_id' => $question->id]) }}">
            <p style="margin-bottom: 0px" class="text-center">Question made by {{ $question->user->name }}, scoring {{ $question->getScore() }} points</p>

            <p style="margin-bottom: 0px" class="text-center">{{ $question->getCorrectAnswersPercentage() }}% correct answers out of {{ $question->getTotalAnswers() }} answers</p>
        </a>

    </div>

    <div class="panel-footer clearfix">
        {{ Form::submit('Submit answer', array('class' => 'btn btn-block btn-primary')) }}
    </div>
    {{ Form::close()  }}

</div>