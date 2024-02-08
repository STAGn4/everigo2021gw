@extends('layouts.main')

@section('title','ブログ詳細')

@section('content')
<article>
    <div class="information-detail">
        <x-headline title="{{ $blog->name }}" />
        <div class="information-detail__header">
            <time>更新日：{{ date('Y.m.d',strtotime($blog->update_date)) }}</time>
            <x-sns-share title="{{ $blog->name }}" link="{{ url()->current() }}"/>
        </div>
        <div class="information-detail__text">
            {{ $blog->value }}
        </div>
        <div class="information-detail__button">
            <ul>
                <li><a href="{{ route('blog.index') }}">一覧へ戻る</a></li>
                <li><a href="{{ route('index') }}">TOPページへ戻る</a></li>
            </ul>
        </div>
    </div>
</article>
@endsection
