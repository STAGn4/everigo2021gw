@extends('layouts.main')

@section('title','受付完了')

@section('content')
<article>
    <div class="send_headline">
        <h2>お問い合わせ内容を受け付けました</h2>
    </div>
    <div class="contact">
        <form>
            <table class="contct-form">
            @csrf
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
        </form>
    </div>



</article>
@endsection
