@extends('layouts.main')

@section('title','reset')

@section('content')
<article>
    <div class="reviewreset">
        <h2>評価を削除しました</h2>
        <a href="{{ route('book.detail',$book->book_no) }}" class="returnpage">元のページへ<img src="{{ asset('image/common/return.png') }}" alt="" /></a>
</article>
@endsection
