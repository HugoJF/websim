@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1></h1>
                @foreach($questions as $question)
                    @include('partials.question', array(
                        'question' => $question
                    ))
                @endforeach
            </div>

            <div class="text-center">
                {!! $questions->render() !!}
            </div>
        </div>
    </div>
@endsection
