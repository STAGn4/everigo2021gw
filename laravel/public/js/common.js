$(function () {
    $('#order_rule').on("change", function () {
        const val = $(this).val();
        const url = new URL(location);
        url.searchParams.set("order_rule",val);
        window.location.href = url.toString();
    });
    $('[id^=limit]').on("change", function () {
        const val = $(this).val();
        const url = new URL(location);
        url.searchParams.set("limit",val);
        window.location.href = url.toString();
    });
});
// ハンバーガーメニュー
$(function() {
    $('.hamburger').click(function() {
        $(this).toggleClass('active');

        if ($(this).hasClass('active')) {
            $('.globalMenuSp').addClass('active');
        } else {
            $('.globalMenuSp').removeClass('active');
        }
    });
});


// ページトップボタン追加
jQuery(function() {
    var pagetop = $('#page_top');
    pagetop.hide();
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {  //100pxスクロールしたら表示
            pagetop.fadeIn();
        } else {
            pagetop.fadeOut();
        }
    });
    pagetop.click(function () {
        $('body,html').animate({
            scrollTop: 0
        }, 500); //0.5秒かけてトップへ移動
        return false;
    });
});
// ここまで

// 文字サイズ変更ボタン
$(function(){
    function initFontSize() {
      var size = (sessionStorage.getItem('fontSize'))? sessionStorage.getItem('fontSize') : '18';
      changeFontSize(size);
    }

    function changeFontSize(size){
      $('p').css('font-size', size + 'px');
      $('[data-font!=' + size + ']').removeClass('active');
      $('[data-font=' + size + ']').addClass('active');
      sessionStorage.setItem('fontSize', size);
    }

    function addListeners() {
      $('[data-font]').on('click', function(){
        changeFontSize($(this).data('font'));
      });
    }

    function init() {
      initFontSize();
      addListeners();
    }

    init();
});

//Loading時のlogo表示
$(window).on('load',function(){
    $("#splash").delay(1500).fadeOut('slow');//ローディング画面を1.5秒（1500ms）待機してからフェードアウト
    $("#splash_logo").delay(1200).fadeOut('slow');//ロゴを1.2秒（1200ms）待機してからフェードアウト
});
