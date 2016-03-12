<ul>
    @if(isset($category_tree))
        @foreach($category_tree as $child)
            <li>
                <a href="{{ $child->getViewLink() }}"><p>{{ $child->name }}</p></a>
                @include('partials.category_tree', array(
                    'category_tree' => $child->children
                ))
            </li>
        @endforeach
    @endif
</ul>