@extends('layouts.main')

@section('title','bad')

@section('content')
<article>
    <div class="reviewbad">
        <h2>評価しました</h2>
        <img src="{{ asset('image/common/thankyou.png') }}" alt="" />
    </div>
        <a href="{{ route('book.detail',$book->book_no) }}" class="returnpage">元のページへ<img src="{{ asset('image/common/return.png') }}" alt="" /></a>
</article>
@endsection
