
@extends('layouts.main')

@section('title','文芸一般')

@section('content')
<article>
    <div class="newbook-container">
        <x-headline title="文芸一般" />
        @each('components.book.item', $books, 'book')
    </div>
    {{ $books->links('components.pagenation') }}
</article>
@endsection
