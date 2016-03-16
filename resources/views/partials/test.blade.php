<div class="panel panel-default panel-primary">
    <div class="panel-heading">
        <a class="panel-title" href="{{ url('test/' . $test->id) }}">{{ $test->name  }}</a>
    </div>

    <div class="panel-body">
        <u><p>Questions:</p></u>
        
        @foreach($test->questions as $question_index => $question)
            <div class="question">
                <p><strong>{{ $question_index + 1 }})</strong> {{ $question->question_title }}</p>
                @if(isset($showAlternatives) && $showAlternatives === true)
                    <ul>
                        @foreach($question->getPossibleAnswers() as $possibleAnswer)
                            <li>{{ $possibleAnswer }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        @endforeach
    </div>
    <div class="panel-footer">
        <a href="{{ url('test/' . $test->id) }}">
            <p style="margin-bottom: 0px" class="text-center">Test created by {{ $test->user->name }}</p>
        </a>

    </div>
    <div class="panel-footer clearfix">
        <a href="{{ url('attempts/create/' . $test->id) }}">
            <button type="button" class="btn btn-block btn-primary">Begin test</button>
        </a>
    </div>

</div>