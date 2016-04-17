@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Adding new sub-category to: {{ $category->name }}</h1>

                {{ Form::open(['url' => route('categoriesSubmit')]) }}

                <div class="form-group">
                    {{ Form::label('Category name:') }}
                    {{ Form::text('category_name', null,  ['class' => 'form-control']) }}
                </div>

                {{ Form::hidden('parent_category', $parent_category_id) }}

                {{ Form::submit('Submit category', array('class' => 'btn btn-block btn-primary')) }}


                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection
