@extends('layouts.main')

@section('title','delete')

@section('content')
<article>
    <div class="reviewdelete">
    <h2>レビューを削除しました</h2>
    <a href="{{ route('book.detail',$book->book_no) }}" class="returnpage">元のページへ<img src="{{ asset('image/common/return.png') }}" alt="" /></a>
    </div>
</article>
@endsection
