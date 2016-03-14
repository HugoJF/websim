@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if($categories[$categories->keys()[0]]->getParentId() != null)
                    <p>
                        @foreach($categories[$categories->keys()[0]]->getAncestors() as $ancestor)
                            <a href="{{ $ancestor->getViewLink() }}">{{ $ancestor->name }}</a><strong> / </strong>
                        @endforeach
                    </p>
                @endif
                <h2>{{ $categories[$categories->keys()[0]]->name }}</h2>
                <p><a href="/categories/add/{{ $categories[$categories->keys()[0]]->id }}">Add a new category to {{ $categories[$categories->keys()[0]]->name }}</a></p>
                <hr>
                @include('partials.category_tree', array(
                    'category_tree' => $categories[$categories->keys()[0]]->children
                ))
            </div>
        </div>
    </div>
@endsection
