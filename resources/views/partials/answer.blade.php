@if($answer->isCorrect())
    <div class="panel panel-default panel-success">
@else
    <div class="panel panel-default panel-danger">
@endif

    <div class="panel-heading">
        <a class="panel-title">{{ $answer->question->question_title }}</a>
    </div>

    <div class="panel-body">
        <ins><p>Question alternatives:</p></ins>

        <ul>
            @foreach($answer->question->getInformationAsJson()->possibleAnswers as $index => $possibleAnswer)
                @if($index == $answer->answer AND $index != $answer->question->getInformationAsJson()->correctAnswer)
                    <li><del>{{ $possibleAnswer }}</del></li>
                @elseif($index == $answer->answer AND $index == $answer->question->getInformationAsJson()->correctAnswer)
                    <li><del class="text-success">{{ $possibleAnswer }}</del></li>
                @elseif($index != $answer->answer AND $index == $answer->question->getInformationAsJson()->correctAnswer)
                    <li class="text-success">{{ $possibleAnswer }}</li>
                @else
                    <li>{{ $possibleAnswer }}</li>
                @endif
                <br>
            @endforeach
        </ul>
    </div>
    <div class="panel-footer">
        <a href="{{ url('questions/' . $answer->question->id) }}">
            <p style="margin-bottom: 0px" class="text-center">Test made by: {{ $answer->question->user->name }}</p>
        </a>

    </div>
</div>