@extends('layouts.main')

@section('title','お問い合わせ')

@section('content')
<article>
        <div class="headline">
            <h2>お問い合わせ</h2>
        </div>
        @if ($errors->any())
        <div class="error-info" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="contact">
            <form method="POST" action="{{ route('company.confirm') }}" >
                @csrf
                <table class="contct-form">
                    <tr>
                    <th>メールアドレス（半角）<span>必須</span></th>
                        <td><input size="30" type="text" name="email" value="{{ old('email') }}" required /></td>
                    </tr>
                    <tr>
                        <th>件名<span>必須</span></th>
                        <td><input size="30" type="text" name="title" value="{{ old('email') }}" required/></td>
                    </tr>
                        <th>お問い合わせ内容(500字まで)<br /></th>
                        <td><textarea name="value" cols="50" rows="5" required>{{ old('value') }}</textarea></td>
                    </tr>
                </table>
                <div class="attention">
                    <p>※必須項目は必ずご入力ください</p>
                </div>
                    <input class="button" type="submit" value="入力内容確認">
            </form>
            {{-- ddみたいな役割で、下記を書くとデータ内容が見れる。 --}}
            {{-- <pre><code>{{ var_dump(session()->get('_old_input')) }}</code></pre> --}}
        </div>

</article>
@endsection
