$(function(){
    $('div.text').click(function(){
            if(!$(this).hasClass('on')){
                $(this).addClass('on');
                var txt = $(this).text();
                $(this).html('<input type="text" name="body" value="'+txt+'" />');
                $('div.text > input').focus().blur(function(){
                var inputVal = $(this).val();
                //編集が終わったらtextで置き換える
                $(this).parent().removeClass('on').text(inputVal);
                });
            };
    });
    $('div.text_description').click(function(){
        if(!$(this).hasClass('on')){
            $(this).addClass('on');
            var txt = $(this).text();
            $(this).html('<textarea name="description" class="remark_field form-control">'+txt+'</textarea><input type="submit" class="btn btn-primary change_description" value="変更">');
            $('div.text_description > textarea').focus().blur(function(){});
        };
    });
    $('.date').click(function(){
        if(!$(this).hasClass('on')){
            $(this).addClass('on');
            var txt = $(this).text();
            $(this).html('<input type="date" name="date" class="show_date" value="'+txt+'" /><input type="submit" class="change_date" value="変更">');
        };
    });
    
    $('div.text_category').click(function(){
        if(!$(this).hasClass('on')){
            $(this).addClass('on');
            var txt = $(this).text();
            $(this).html('<input type="text" name="category_name" value="'+txt+'" />');
            $('div.text > input').focus().blur(function(){
            var inputVal = $(this).val();
            //編集が終わったらtextで置き換える
            $(this).parent().removeClass('on').text(inputVal);
            });
        };
    });

    /*完了ボタン*/
    $('.delete').click(function(){
        if(confirm('本当に完了にしますか？')){
            /* キャンセルの時の処理 */
            location.href = './index_task_app.blade.php';
        }else{
            /*　OKの時の処理 */
            return false;
        }
    });

    /*取り消しボタン*/
    $('.cancel').click(function(){
        if(confirm('取り消しますか？')){
            /* キャンセルの時の処理 */
            location.href = './index_task_app.blade.php';
        }else{
            /*　OKの時の処理 */
            return false;
        }
    });

    $('span.category').click(function(){
            $(this).css("display", "none");
            $(this).parent().nextAll('.category_choice').css("display", "inline");
    });

    $(".text").change(function(){
        $("#submit_form").submit();
    });

    //ポップアップ関連
    $('.description .btn').on('click',function(){
        $(this).parent().nextAll('.popup').addClass('show');
        $(".table-responsive").css("overflow-x", "visible");
        $(".table-responsive").css("positon", "relative");
    });
    $('.back').on('click',function(){
        $('.popup').removeClass('show');
        $(".table-responsive").css("overflow-x", "auto");
        $(".table-responsive").css("positon", "static");
    });

    //テーブルの色
    $("tr td:has(.moge)").parent().addClass("parent");
    
    $("tr td:has(.false)").parent().addClass("underway");

    $(".status_popup").on("click", function(){
        $(this).hide("status_popup");
    });
    if($(window).width() < 768) {
        $('.empty_msg').wrap('<div />').parent().addClass("empty");
    };

    // ①タブをクリックしたら発動
    $('.tab li').click(function() {

    // ②クリックされたタブの順番を変数に格納
    var index = $('.tab li').index(this);
    // ③クリック済みタブのデザインを設定したcssのクラスを一旦削除
    $('.tab li').removeClass('active');
    // ④クリックされたタブにクリック済みデザインを適用する
    $(this).addClass('active');
    // ⑤コンテンツを一旦非表示にし、クリックされた順番のコンテンツのみを表示
    $('.list li').removeClass('show_tab').eq(index).addClass('show_tab');

    });

    $("textarea").attr("rows", 1).on("input", e => {
        $(e.target).height(0).innerHeight(e.target.scrollHeight);
    });
});