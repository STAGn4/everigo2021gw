@extends('layouts.main')

@section('title','雑誌')

@section('content')
<article>
    <x-headline title="新刊情報" link="{{ route('label.new-release') }}" />
    <div class="books-single">
        @each('components.book.sales-info-card', $new_label_sales_info_list, 'book')
    </div>

    <x-headline title="刊行予定"  />
    <div class="books-single">
        @each('components.book.sales-info-card', $upcoming_label_sales_info_list, 'book')
    </div>

    <x-headline title="おすすめ" link="{{ route('label.recommend') }}"  />
    <div class="books-single">
        @each('components.book.sales-info-card', $recommend_label_sales_info_list, 'book')
    </div>

    @foreach ($genres as $genre )
        <x-headline title="{{ $genre->name }}" link="{{ route('label.genre',[ 'genre_no' => $genre->genre_no ]) }}" />
        <div class="books-single">
            @each('components.book.sales-info-card', $book_label_genre_info_list[$genre->genre_no], 'book')
        </div>
    @endforeach

    <x-headline title="お知らせ" link="{{ route('news.index') }}" />
    @include('components.news.list')
</article>
@endsection
