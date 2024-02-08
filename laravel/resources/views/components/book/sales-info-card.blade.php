<?php
 use App\Models\Book;
?>
<div class="books__bibl">
    <div class="books__bibl--image">
        <p><a href="{{ route('book.detail',$book->book_no) }}"><img src="{{ $book->image }}"
                    alt="{{ $book->name }}"></a></p>
    </div>
    <div class ="books__bibl--stars">
        <star-rating :star-size="20" :increment="0.1" :read-only="true" :show-rating="false" :rating="{{  $book->rate }}"></star-rating>
        <span>{{ $book->post_cnt }}</span>
        {{-- <star-rating :star-size="20" :increment="0.1" :read-only="true" :show-rating="false" :rating="{{ Book::find($book->book_no)->getAvgStar() }}"></star-rating>
        <span>{{ Book::find($book->book_no)->reviews()->count() }}</span> --}}
    </div>

    <div class="books__bibl--attribute">
        <ul>
            <li><span>発売日</span><span>{{ date('y年n月j日',strtotime($book->release_date)) }}</span></li>
            <li><span>価格</span><span>&yen;{{ number_format( $book->price * ( 1 + $sales_tax_late )) }}</span></li>
            <li><span>ページ</span><span>{{ $book->page  }}</span></li>
            <li><span>在庫状況</span><span>{{ $book->stock_status  }}</span></li>
        </ul>
    </div>
</div>
