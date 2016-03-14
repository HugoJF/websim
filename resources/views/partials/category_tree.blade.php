<ul>
    @if(isset($category_tree))
        @foreach($category_tree as $child)
            <li>
                <p><a href="{{ $child->getViewLink() }}">{{ $child->name }}</a></p>
                @include('partials.category_tree', array(
                    'category_tree' => $child->children
                ))
            </li>
        @endforeach
    @endif
</ul>