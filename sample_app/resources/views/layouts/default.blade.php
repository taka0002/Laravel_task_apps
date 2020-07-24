<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="//stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="//code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="//stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <title>@yield('title')</title>
    <style>
        h1 {
            text-align: center;
            margin:20px 0;
        }
        .username {
            font-size:24px;
        }
        table {
            text-align:center;
        }
        tr.false {
            background-color: #A9A9A9;
        }
        .post {
            margin:16px 0;
        }
        span {
            color:#ff0000;
            font-weight: bold;
        }
        .status {
            border-radius: 5px;
            padding: 0 5px 3px;
            margin-right: 3px;
        }
        .table-bordered td {
            vertical-align: middle;
        }
        .sort {
            text-align:right;
            margin:0 10px 10px 0;
        }
        .sort select {
            margin:0 10px;
            border-radius: 5px;
            padding:0 5px 5px;
        }
        input.update {
            background:transparent;
            border:none;
        }
        input.update:focus {
            outline: none;
        }
        th select {
            background:transparent;
            border:none;
            appearance: none; 
            -webkit-appearance: none;
            -moz-appearance: none;
            font-weight: bold;
        }
        th select:focus {
            outline: none;
        }
    </style>
    <script>
        jQuery(function($){
            $('div.text').click(function(){
                if(!$(this).hasClass('on')){
                    $(this).addClass('on');
                    var txt = $(this).text();
                    $(this).html('<input type="text" name="body" value="'+txt+'" />');
                    $('div > input').focus().blur(function(){
                    var inputVal = $(this).val();
                    //もし空欄だったら空欄にする前の内容に戻す
                    if(inputVal===''){
                        inputVal = this.defaultValue;
                    };
                    //編集が終わったらtextで置き換える
                    $(this).parent().removeClass('on').text(inputVal);
            });
                };
            });
        });
    </script>
    <script type="text/javascript">
        $(function(){
        $(".text").change(function(){
            $("#submit_form").submit();
        });
        });
    </script>
</head>
<body>
    @yield('content')
</body>
</html>