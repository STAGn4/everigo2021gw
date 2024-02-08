@extends('layouts.main')

@section('title','レーベル一覧')

@section('content')
<article>
    <div class="label">
        <div class="label_icon">

            <a href="{{ config('url.url_tech') }}"><img src="{{ asset('image/common/logotype1.png') }}"></a>
        </div>
        <div class="label_icon">

            <a href="{{route('label.magazine')}}"><img src="{{ asset('image/common/logotype2.png') }}"></a>
        </div>
        <div class="label_icon">

            <a href="{{ config('url.url_novel') }}"><img src="{{ asset('image/common/logotype3.png') }}"></a>
        </div>
        <div class="label_icon">

            <a href="{{ config('url.url_photo') }}"><img src="{{ asset('image/common/logotype4.png') }}"></a>
        </div>
        <div class="label_icon">

            <a href="{{ config('url.url_other') }}"><img src="{{ asset('image/common/logotype5.png') }}"></a>
        </div>
    </div>
</article>
@endsection
