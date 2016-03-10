@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @foreach($tests as $test_index => $test)
                    @include('partials.test', array(
                        'test' => $test,
                        'showAlternatives' => false
                    ))
                    <br><br>
                @endforeach
            </div>
            <div class="text-center">
                {!! $tests->render() !!}
            </div>
        </div>

    </div>
@endsection
