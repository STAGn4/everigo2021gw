@extends('layouts.main')

@section('title',$company->name)

@section('content')
<article>
    <div class="information-detail">
        <x-headline title="{{ $company->name }}" />
        <div class="information-detail__text">
            {!! $company->value !!}
        </div>
        <div class="information-detail__button">
            <ul>
                <li><a href="{{ route('index') }}">TOPページへ戻る</a></li>
            </ul>
        </div>
    </div>
</article>
@endsection
