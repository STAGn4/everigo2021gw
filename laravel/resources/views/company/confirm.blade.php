@extends('layouts.main')

@section('title','確認画面')

@section('content')
<article>
    <div class="headline">
        <h2>お問い合わせ内容確認</h2>
    </div>
    <div class="contact">
        <form method="POST" action="{{ route('company.send') }}" >
            <table class="contct-form">
            @csrf
            <input type="hidden" id="email" name="email" value="{{$contact_data->email}}">
            <input type="hidden" id="title" name="title" value="{{$contact_data->title}}">
            <input type="hidden" id="value" name="value" value="{{$contact_data->value}}">
           <tr>
                <th>メールアドレス</th>
                <td>{{$contact_data->email}}</td>
           </tr>
           <tr>
                <th>件名</th>
                <td>{{$contact_data->title}}</td>
           </tr>
            <tr>
                <th>お問い合わせ内容</th>
                <td>{!!nl2br(e($contact_data->value))!!}</td>
            </tr>
            </table>
            <input class="button" type="submit" value="入力内容確認">
        </form>
    </div>


</article>
@endsection
