@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><img src="http://localhost/image/common/Register_btn_green2.png" alt=""></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('ログインが完了しました!') }}
                </div>
                <div class="toppage_button_login">
                    <a href="{{ route('index') }}"><img class="toppage_button" src="{{ asset('image/common/topbtn-1.png') }}"></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
