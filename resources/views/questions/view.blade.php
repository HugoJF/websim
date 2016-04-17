@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @include('partials.question')
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
            <h1>Comments</h1>

            @foreach($question->comments as $comment)
                @include('partials.comment', [
                    'comment' => $comment
                ])
            @endforeach
            </div>
        </div>
    </div>
@endsection
