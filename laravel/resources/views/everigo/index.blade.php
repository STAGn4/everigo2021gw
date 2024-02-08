@extends('layouts.main')

@section('title','everiGo')

@section('content')
<article>
   <p><a href="{{route('everigo/webbasic')}}">webbasic</a></p>
   <p><a href="{{ route('everigo/programbasic')}}">programbasic</a></p>
   <p><a href="{{route('everigo/feedback')}}">今日の振り返り</a></p>
   <p><a href="https://docs.google.com/forms/d/e/1FAIpQLSfmb8N_pFWl2_HLVydl2ffclWVaOy_WVKmN1fjLKQwq9CiDEQ/viewform">QA票</a></p>
</article>
@endsection
