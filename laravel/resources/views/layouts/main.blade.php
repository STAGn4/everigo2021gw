<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="keywords" content="">
<meta name="description" content="">
<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=1">
<meta name="format-detection" content="telephone=no">
<link rel="icon" href="{{ asset('favicon.ico') }}">

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.4/css/all.css">
<link href="https://unpkg.com/ress/dist/ress.min.css" rel="stylesheet"/>
<link rel="stylesheet" type="text/css" media="screen and (min-width:961px),print" href="{{ asset('css/style_pc.css') }}">
<link rel="stylesheet" type="text/css" media="screen and (max-width:960px)" href="{{ asset('css/style_sp.css') }}">
<link rel="stylesheet" type="text/css" media="screen,print" href="{{ asset('css/style.css') }}">
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="{{ asset('js/common.js') }}"></script>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
@hasSection ('title')
<title>@yield('title') | SHIBAKAWA BOOK STORE</title>
@else
<title>SHIBAKAWA BOOK STORE</title>
@endif
<link rel="stylesheet" href="{{ asset('css/inc_index.css') }}">
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/modal-video@2.4.2/js/jquery-modal-video.min.js"></script>

<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/modal-video@2.4.2/css/modal-video.min.css" />
<script src="{{ asset('/js/youtube.js') }}"></script>
<script src="{{ asset('/js/app.js') }}" defer></script>

<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1/slick/slick.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1/slick/slick.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1/slick/slick-theme.min.css">
<script>
$(function(){
    $('.slider').slick({
        variableWidth :true,
        centerMode: true,
        dots:true,
        focusOnSelect:true,
        autoplay: true,
    });
});
</script>
</head>

<body>
    @if(Route::is('index'))
    <div id="splash">
        <div id="splash_logo">
            <img src="{{ asset('image/common/logo_white.png') }}" alt="" class="fadeUp">
        </div>
    </div>
    @endif
</body>

<body>
    <x-header />
    @yield('content')
    <x-footer />
</body>
</html>
