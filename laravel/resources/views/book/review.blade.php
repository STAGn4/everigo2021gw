@extends('layouts.main')

@section('title','レビュー')

@section('content')
<article>
    <div class="detail-property__image">
        <div class="detail-property__image--cover"><img src="{{ $book->image }}" alt="{{ $book->name }}" />
        </div>

        <div class="detail-property__image--sns">
            <x-sns-share title="{{ $book->name }}" link="{{ url()->current() }}" />
        </div>
    </div>
    <div class="review" id='app'>
    <h1>レビュー</h1>
        {{-- レビューがある場合 --}}
        @if($book->user_id ==  auth()->id())
        <form method="POST" name="review" action="{{ route('review.send', $book->book_no) }}" >
            @csrf
            <star-rating id="stars":star-size="30" @rating-selected="setRating" rating={{$book->stars}}></star-rating>
            <table class="review-form">

            <tr>
                <th>
                    タイトル
                </th>
                <td><input class="reviewtitle" type="text"name="title" value="{{$book->title}}" placeholder="タイトル" required></td>
            </tr>
            <tr>
                <th>
                    レビュー内容
                </th>
                <td>

                    <textarea class="textarea-large" name="value" rows="10" cols="40" value="{{$book->value}}"  placeholder="レビュー内容" required>{{$book->value}}</textarea>

                </td>
            </tr>
            </table>
            <input type="hidden" name="stars" value="{{ $book->stars }}">
            <input type="hidden" name="book_no" value="{{$book->book_no}}">
            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
            <div class="review_button">
            <input class="review_button1" type="submit" value="投稿する">
            </div>
            <div class="review_button2">
                <a href="{{ route('book.delete',$book->book_no) }}">削除</a>
            <!-- {{-- <input class="button" type="submit" value="削除"> --}} -->
            </div>
        </form>

        {{-- レビューがない場合 --}}
        @else
        <form method="POST" name="review" action="{{ route('review.send', $book->book_no) }}" >
            @csrf

            <star-rating id="stars" :star-size="30" @rating-selected="setRating" ></star-rating>
            <table class="review-form">

            <tr>
                <th>
                    タイトル
                </th>
                <td><input class="reviewtitle" type="text" name="title" value="{{ old('title') }}" placeholder="タイトル" required></td>
            </tr>
            <tr>
                <th>
                    レビュー内容
                </th>
                <td>
                    <textarea class="textarea-large" name="value" value="{{ old('value') }}"  placeholder="レビュー内容" required></textarea>
                </td>
            </tr>
            </table>
            <input type="hidden" name="stars" value="{{ $book->stars }}">
            <input type="hidden" name="book_no" value="{{$book->book_no}}">
            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
            <div class="review_button">
            <input class="review_button1" type="submit" value="投稿する">
            </div>
            <div class="review_button2">
            <a href="{{ route('book.delete',$book->book_no) }}">削除</a>
            <!-- <input class="button" type="submit" value="削除"> -->
            </div>
        </form>
        @endif
        </div>
</article>
@endsection
