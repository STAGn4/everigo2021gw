@extends('layouts.main')

@section('title','レビュー')

@section('content')
<article>
    <x-headline title="レビュー受付完了" />
    <div class="reviewsend" id='app'>
        <h2>レビューありがとうございます</h2>
        <img src="{{ asset('image/common/thankyou.png') }}" alt="" />
    </div>
    <a href="{{ route('book.detail',$book->book_no) }}" class="returnpage">元のページへ<img src="{{ asset('image/common/return.png') }}" alt="" /></a>
</article>
@endsection
