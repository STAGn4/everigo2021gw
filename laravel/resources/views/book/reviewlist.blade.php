{{-- <?php dd($book) ?> --}}

@extends('layouts.main')

@section('title',$book->name)

@section('content')
<article id="app">
    <div class="detail-container">
        <div class="detail-property">
            <div class="detail-property__image">
                <div class="detail-property__image--cover"><img src="{{ $book->image }}" alt="{{ $book->name }}" />
                </div>
                <div class="detail-property__image--button">
                    <ul>
                        <li><a href="#">立ち読み</a></li>
                    </ul>
                </div>
                <div class="detail-property__image--sns">
                    <x-sns-share title="{{ $book->name }}" link="{{ url()->current() }}" />
                </div>
            </div>
            <div class="detail-property__document">
                <div class="detail-property__document--title">
                    <h2>{{ $book->name }}</h2>
                </div>
                {{-- 課題その③ --}}
                <div class = 'stars1'>
                    <star-rating :increment="0.1" :read-only="true" :show-rating="false" :rating={{$book->floatStar}}></star-rating>
                    <a>{{$book->count}}件</a>
                </div>
                @if (Route::has('login'))
                    <div class= 'evaluations'>
                        @auth
                            <a href="{{ route('book.review', $book->book_no) }}">レビューを書く<img src="{{ asset('image/common/speechbubble.png') }}" alt="" /></a>
                        @else
                            <a href="{{ route('login') }}">＊レビューを書くにはログイン</a>
                @endif
            </div>
@endif
                {{--  --}}
                <div class="detail-property__document--attribute">
                    <table>
                        <tbody>
                            <tr>
                                <th scope="row">ジャンル</th>
                                    <td>
                                        @foreach ($book->genres as $genre)
                                        {{ $genre->name }}/
                                        @endforeach
                                     </td>

                            </tr>
                            @foreach ($book->authors as $author)
                            <?php if ($author->type == '著'):?>
                            <tr>
                                <th scope="row">{{ $author->type }}</th>
                                <td>{{ $author->name }}</td>
                            </tr>
                            <?php endif ?>
                            @endforeach
                            <tr>
                                <th scope="row">発売日</th>
                                <td>{{ date("y年n月d日",strtotime($book->release_date))}}</td>
                            </tr>
                            <tr>
                                <th scope="row">価格</th>
                                <td>&yen;{{ number_format( $book->price * ( 1 + $sales_tax_late )) }} （本体&yen;{{ number_format( $book->price )}}＋税{{ $sales_tax_late * 100 }}%）</td>
                            </tr>
                            <tr>
                                <th scope="row">サイズ</th>
                                <td>{{ $book->size }}</td>
                            </tr>
                            <tr>
                                <th scope="row">ISBN</th>
                                <td>{{ $book->isbn }}</td>
                            </tr>
                            <tr>
                                <th scope="row">ページ数</th>
                                <td>{{ $book->page }}</td>
                            </tr>
                            <tr>
                                <th scope="row">在庫状況</th>
                                <td>{{ $book->stock_status }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="detail-property__document--text">
                    <p>{{ $book->content }}</p>
                </div>
            </div>
        </div>
        <x-headline title="レビュー一覧" />
        @foreach($book->reviews as $review)
        <div class="reviewlist">
            <div class="reviewlist_datas">
                <div class="review_poster">
                    <div class="review_title">{{$review->title}}</div>
                    <div class="review_name">{{$review->name}}</div>
                    <div class="review_time"><time>{{ date('Y年m月d日',$book->updated_at) }}</time></div>
                    <div class="review_value">{{$review->value}}</div>
                </div>
                <div class ='stars2' id="app">
                    <star-rating :increment="0.1" :read-only="true" :show-rating="false" :rating={{$review->stars}}></star-rating>
                </div>
                {{-- 未評価の場合 --}}
                <div class="review_goood.bad">
                    @if($review->review_id == "0" || $review->review_id == null)
                    {{-- <div> --}}
                    <div>
                        <a href="/book/{{$book->book_no}}/review/{{$review->review_no}}/good">
                        <img src="{{ asset('image/common/Good.png') }}" alt="" /></a>
                        <a>{{$book->good}}</a>
                    </div>
                    <div>
                        <a href="/book/{{$book->book_no}}/review/{{$review->review_no}}/bad">
                        <img src="{{ asset('image/common/Bad.png') }}" alt="" /></a>
                        <a>{{$book->bad}}</a>
                    </div>
                    {{-- Good評価の場合 --}}
                    @elseif($review->review_id == "1")
                    <div class="review_good">
                        <a href="/book/{{$book->book_no}}/review/{{$review->review_no}}/reset">
                        <img src="{{ asset('image/common/Good.png') }}" alt="" /></a>
                        <a>{{$book->good}}</a>
                    </div>
                    <div class="review_bad">
                        <a href="/book/{{$book->book_no}}/review/{{$review->review_no}}/bad">
                        <img src="{{ asset('image/common/Bad.png') }}" alt="" /></a>
                        <a>{{$book->bad}}</a>
                    </div>
                    {{-- Bad評価の場合 --}}
                    @elseif($review->review_id == "2")
                    <div class="review_good">
                        <a href="/book/{{$book->book_no}}/review/{{$review->review_no}}/good">
                        <img src="{{ asset('image/common/Good.png') }}" alt="" /></a>
                        <a>{{$book->good}}</a>
                    </div>
                    <div class="review_bad">
                        <a href="/book/{{$book->book_no}}/review/{{$review->review_no}}/reset">
                        <img src="{{ asset('image/common/Bad.png') }}" alt="" /></a>
                        <a>{{$book->bad}}</a>
                    </div>
                    @endif
                </div>
            </div>
        @endforeach
        <canvas id="myChart" width="400" height="400"></canvas>
    </div>
</article>
@endsection
