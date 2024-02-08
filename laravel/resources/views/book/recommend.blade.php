@extends('layouts.main')

@section('title','おすすめ')

@section('content')
<article>
    <div class="newbook-container">
        <x-headline title="おすすめ" />
        @each('components.book.item', $books, 'book')
    </div>
    {{ $books->links('components.pagenation') }}
</article>
@endsection
