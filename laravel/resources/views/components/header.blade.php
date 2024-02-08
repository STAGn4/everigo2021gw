<header>
    <div id="Hd">
        <div class="hd-logo">
            @if(Route::is('label.*'))
            <h1><a href="{{ route('label.magazine') }}"><img src="{{ asset('image/common/logomaga.png') }}" alt="" /></a></h1>
            @elseif(Route::is('*'))
            <h1><a href="{{ route('index') }}"><img src="{{ asset('image/common/logogreen.png') }}" alt="" /></a></h1>
            <p><a href="{{route('everigo.index')}}">everiGO</a>専用のシステム教材です</p>
            <p>知識よりも実践に重きを置いた講座です</p>
            <p>本システムの修正を繰り返すことで開発技術を身に着けます</p>
            @endif
        </div>
        {{-- 文字サイズ変更ボタン --}}
        <div class="button">
            <button class="size-button" data-font="14">小</button>
            <button class="size-button active" data-font="18">中</button>
            <button class="size-button" data-font="20">大</button>
        </div>

        <div class='login-menu'>
        @auth
            <a class='login-name'>{{ Auth::user()->name.'様'}}</a>
            <a class="btn-gradient-radius" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        @else
            <a href="{{ route('home') }}" class="btn-gradient-radius">Login</a>
        @endauth
        </div>

        <div class="hd-global">
            <nav>
                <ul>
                    <li class="hd-global-list"><a href="{{ route('index') }}">TOP</a></li>
                    <li class="hd-global-list"><a href="{{ route('book.new-release') }}">新刊情報</a></li>
                    <li class="hd-global-list"><a href="{{ route('book.index') }}">書籍情報</a></li>
                    <li class="hd-global-list"><a href="{{ route('news.index') }}">お知らせ</a></li>
                    <li class="hd-global-list"><a href="{{ route('blog.index') }}">ブログ</a></li>
                    {{-- GW課題 その① --}}
                    <li class="hd-global-list"><a href="#">レーベル</a>
                        <ul>
                            <li><a href="{{ route('labels.index') }}">レーベルTOP</a>
                            <li><a href="{{ config('url.url_tech') }}">技術書</a>
                            <li><a href="{{ route('label.magazine') }}">雑誌</a>
                            <li><a href="{{ config('url.url_novel') }}">小説全般</a>
                            <li><a href="{{ config('url.url_photo') }}">写真集</a>
                            <li><a href="{{ config('url.url_other') }}">その他</a>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="hd-search">
            <form action="{{ route('book.index') }}" method="get">
                <input type="hidden" name="search_menu" value="keyword">
                <input type="hidden" name="tab" value="3">
                <div class="hd-search__box">
                    <input class="hd-search__box--keyword" type="text" name="keyword" value="" id=""
                        placeholder="書籍タイトル・著者名など入力">
                    <input class="hd-search__box--button" type="submit" id="" value="　">
                </div>
            </form>
        </div>
        {{-- ハンバーガーメニュー --}}
        <div class="hamburger">
            <span></span>
            <span></span>
            <span></span>
          </div>
          <nav class="globalMenuSp">
              <ul>
                  <li><a href="{{ route('index') }}">TOP</a></li>
                  <li><a href="{{ route('book.new-release') }}">新刊情報</a></li>
                  <li><a href="{{ route('book.index') }}">書籍情報</a></li>
                  <li><a href="{{ route('news.index') }}">お知らせ</a></li>
                  <li><a href="{{ route('blog.index') }}">ブログ</a></li>
                  <li><a href="{{ route('labels.index') }}">レーベル</a></li>
              </ul>
          </nav>
</header>
