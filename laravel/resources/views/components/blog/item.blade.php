<li @if($blog_item->category=='ブログ') class="information__title--category1"@endif
    >
    <a href="{{ route('blog.detail',['news_no' => $blog_item->news_no ])}}">
        <span>{{ $blog_item->category }}</span>
        <time>{{ date('Y.m.d',strtotime($blog_item->public_date)) }}</time>
        <p>{{ $blog_item->name}}</p>
    </a>
</li>
