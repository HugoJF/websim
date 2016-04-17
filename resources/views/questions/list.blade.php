@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Questions</h1>
                <br>
                @forelse($questions as $question)
                    @include('partials.question', array(
                        'questions.view' => $question
                    ))
                @empty
                    @if(isset($query))
                        <h2>No questions found for "{{ $query }}"</h2>
                    @else
                        <h2>You haven't created any questions yet</h2>
                    @endif
                @endforelse
            </div>

            <div class="text-center">
                {!! $questions->render() !!}
            </div>
        </div>
    </div>
@endsection
