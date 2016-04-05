@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @foreach($answers as $answer)
                @include('partials.answer', [
                    'answer' => $answer,
                ])
            @endforeach
        </div>
    </div>
</div>
@endsection
