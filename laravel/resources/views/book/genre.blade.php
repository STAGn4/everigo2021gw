
@extends('layouts.main')

@section('title', $book_genrename)

@section('content')
<article>
    <div class="newbook-container">
        <x-headline title="{{ $book_genrename }}" />
        @each('components.book.item', $books, 'book')
    </div>
    {{ $books->links('components.pagenation') }}
</article>
@endsection
