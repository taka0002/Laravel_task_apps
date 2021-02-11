@extends('layouts.default')

@section('title', $title)

@section('content')
<div class="container">
    <h1 class="text-primary"><a href="http://takahiro-kym.sakura.ne.jp/task_app/public/task_apps" rel=”noopener”>{{ $title }}</a></h1>
    <p class="username text-center"><span>{{ Auth::user()->name }}</span></p>
    <p class="text-center help">操作の仕方がわからない方は<a href="https://github.com/taka0002/task_app" target="_blank" rel=”noopener”>こちら</a>を参照してください</p>
    <form action="{{ url('/logout') }}" method="post" class="post text-right">
        {{ csrf_field() }}
        <button type="submit" class="btn btn-primary">ログアウト</button>
    </form>
    @if (session('status'))
    <div class="status_popup">
        <div class="popup-inner">
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        </div>
    </div>
    @endif
    {{-- エラーメッセージを出力 --}}
    @foreach($errors->all() as $error)
    <p class="error">{{ $error }}</p>
    @endforeach
    {{-- 以下にフォームを追記します。 --}}

    <!--やること登録フォーム-->
    <button class="scroll text-center btn btn-info" type="button" data-toggle="collapse" data-target="#demo">ここをクリックしてやること登録</button>
    <form method="post" action="{{ url('/task_apps') }}" enctype="multipart/form-data" class="form-horizontal collapse" id="demo">
        {{-- LaravelではCSRF対策のため以下の一行が必須です。 --}}
        {{ csrf_field() }}

        <div class="form-group">
            <input type="text" name="body" class="comment_field form-control" placeholder="To Doを入力（20文字まで入力可能）">
        </div>

        <div class="form-group">
            <span>締め切り日時：</span>
            <input type="date" name="date" class="date_field">
            <span class="empty_msg">（空欄の場合は固定表示になります）</span>
        </div>

        <div class="form-group hidden">
            <textarea type="text" name="description" class="remark_field form-control" placeholder="備考欄（300文字まで入力可能）"></textarea>
        </div>

        <div class="form-group">
            <div>
                <span>ステータス：</span>
                <label>
                    <select name="status" class="status form-control">
                            <option value="0">未着手</option>
                            <option value="1">着手中</option>   
                    </select>
                </label>
            </div>
            <div>
                <span>カテゴリー：</span>
                <label>
                    <select name="category_id" class="status form-control">
                        <option value="0" selected>未設定</option>
                        @forelse($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                        @empty
                        @endforelse
                    </select>
                </label>
            </div>
            <input type="submit" value="登録" class="btn btn-primary submit">
        </div>

    </form>

    <!--カテゴリ登録フォーム-->
    <button class="scroll text-center btn btn-info" type="button" data-toggle="collapse" data-target="#demo_2">ここをクリックしてカテゴリ登録</button>
    <form method="post" action="{{ url('/task_apps') }}" enctype="multipart/form-data" class="form-horizontal collapse" id="demo_2">
        <a href="{{ url('/task_apps_category') }}" target="_blank" rel=”noopener”>カテゴリーの編集はこちら</a>
        {{ csrf_field() }}
        <div class="form-group">
            <input type="text" name="category_name" class="comment_field form-control" placeholder="カテゴリを入力（20文字まで入力可能）">
            <input type="submit" value="登録" class="btn btn-primary submit">
        </div>
    </form>
    
    <!--タブ-->
    <ul class="tab clearfix">
        <li class="active">未完了リスト</li>
        <li class="page">完了済みリスト</li>
    </ul>

    <!--カテゴリを絞って表示-->
    <form method="get" action="{{ url('/task_apps')}}" class="select_category">
        <label>
            <select name="category_view">
                @if($category_name !== null)
                    @if($category_name !== "all")
                        @forelse($task_apps as $task_app)
                            @if ($loop->first)
                                <option value="{{$task_app->category}}">{{$task_app->category}}</option>
                            @endif
                        @empty
                        @endforelse
                    @endif
                @endif
                <option value="all">全表示</option>
                @forelse($categories as $category)
                    @forelse($task_apps as $task_app)
                        @if($loop->first)
                            <option value="{{ $category->category_name }}">{{ $category->category_name }}</option>
                        @endif
                    @empty
                        <option value="{{ $category->category_name }}">{{ $category->category_name }}</option>
                    @endforelse
                @empty
                @endforelse
            </select>
        </label>
        {{ method_field('PATCH') }}
        <input type="submit" value="でカテゴリを絞って表示" class="select_category_submit">
        <input type="hidden" name="sql_kind" value="category_name">
    </form>

    <!--やること未完了リスト-->
    <ul class="list">
        <li class="table-responsive show_tab">
            <table class="table table-bordered table-hover table-sm">
                
                    <!--やること見出し-->
                    <tr class="thead-light">
                        <th class="text-nowrap">やること</th>
                        <th class="text-nowrap hidden">詳細</th>
                        <form method="get" action="{{ url('/task_apps')}}" id="submit_form">
                            <th class="text-nowrap">
                                <select name="category" class="text">
                                    <option value="">カテゴリー</option>
                                    <option value="up">並び替え</option>
                                </select>
                            </th>
                            <th class="text-nowrap">
                                <select name="status" class="text">
                                    <option value="">現在のステータス</option>
                                    <option value="in">着手中を上へ</option>
                                    <option value="out">未着手を上へ</option>
                                </select>
                            </th>
                            <th class="text-nowrap">
                                <select name="sort" class="text">
                                    <option value="">締め切り期限</option>
                                    <option value="asc">昇順</option>
                                    <option value="desc">降順</option>
                                </select>
                            </th>
                        </form>
                        <th class="text-nowrap">取り消し</th>
                        <th class="text-nowrap">終わったら</th>
                    </tr>
                    <!--やること一覧-->
                @forelse($task_apps as $task_app)
                    <tr class="pop">

                        <!--やること名称-->
                        <td class="text-nowrap">
                            <form method="post" action="{{ url('/task_apps')}}" id="submit_form">
                                {{ csrf_field() }}
                                {{ method_field('PATCH') }}
                                <input type="hidden" name="id" value="{{ $task_app->id }}">
                                <input type="hidden" name="sql_kind" value="update_text">
                                <div class="text">{{ $task_app->body }}</div>
                            </form>
                        </td>

                        <!--やること詳細-->
                        <td class="hidden">
                            <div class="description">
                                <button class="btn btn-primary">詳細</button>
                            </div>
                            <!--ポップアップ時の処理-->
                            @if($task_app->description === null)
                            <div class="popup">
                                <div class="popup_content">
                                    <form method="post" action="{{ url('/task_apps')}}" id="submit_form">
                                        {{ csrf_field() }}
                                        {{ method_field('PATCH') }}
                                        <input type="hidden" name="id" value="{{ $task_app->id }}">
                                        <input type="hidden" name="sql_kind" value="update_text_description">
                                        <div class="text_description">なし</div>
                                    </form>
                                    <button class="back btn btn-primary">閉じる</button>
                                </div>
                            </div>
                            @else
                            <div class="popup">
                                <div class="popup_content">
                                    <form method="post" action="{{ url('/task_apps')}}" id="submit_form">
                                        {{ csrf_field() }}
                                        {{ method_field('PATCH') }}
                                        <input type="hidden" name="id" value="{{ $task_app->id }}">
                                        <input type="hidden" name="sql_kind" value="update_text_description">
                                        <div class="text_description"><textarea class="auto-resize">{{ $task_app->description }}</textarea></div>
                                    </form>
                                    <button class="back btn btn-primary">閉じる</button>
                                </div>
                            </div>
                            @endif
                        </td>

                        <!--カテゴリー-->
                        <td class="text-nowrap">
                            <form method="post" action="{{ url('/task_apps')}}">
                                {{ csrf_field() }}
                                {{ method_field('PATCH') }}
                                @if($task_app->category_id === 0)
                                <span class="category">未設定</span>
                                @else
                                <span class="category">{{ $task_app->category }}</span>
                                @endif
                            </form>
                            <div class="category_choice">
                                <form method="post" action="{{ url('/task_apps')}}">
                                    <label>
                                        <select name="category_id">
                                            <option value="0">未設定</option>
                                            @forelse($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                            @empty
                                            <option selected>未設定</option>
                                            @endforelse
                                        </select>
                                    </label>
                                    {{ csrf_field() }}
                                    {{ method_field('PATCH') }}
                                    <input type="submit" class="change_date" value="変更">
                                    <input type="hidden" name="id" value="{{ $task_app->id }}">
                                    <input type="hidden" name="sql_kind" value="update_category">
                                </form>
                            </div>
                        </td>

                        <!--ステータス-->
                        <td>
                        @if($task_app->date !== null)
                        @if($task_app->status === 0)
                        <form method="post" action="{{ url('/task_apps')}}">
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}
                            <input type="submit" value="未着手" class="update">
                            <input type="hidden" name="id" value="{{ $task_app->id }}">
                            <input type="hidden" name="sql_kind" value="update">
                        </form>
                        @elseif($task_app->status === 1)
                        <form method="post" action="{{ url('/task_apps')}}">
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}
                            <input type="submit" value="着手中" class="update false">
                            <input type="hidden" name="id" value="{{ $task_app->id }}">
                            <input type="hidden" name="sql_kind" value="update">
                        </form>
                        @endif
                        @endif
                        </td>

                        <!--締め切り期限-->
                        <td class="text-nowrap">
                            @if($task_app->date === null)
                            <form method="post" action="{{ url('/task_apps')}}" id="submit_form" class="moge">
                                {{ csrf_field() }}
                                {{ method_field('PATCH') }}
                                <input type="hidden" name="id" value="{{ $task_app->id }}">
                                <input type="hidden" name="status" value="{{ $task_app->status }}">
                                <input type="hidden" name="sql_kind" value="update_date">
                                <span class="date">固定</span>
                            </form>
                            @else
                            <form method="post" action="{{ url('/task_apps')}}" id="submit_form">
                                {{ csrf_field() }}
                                {{ method_field('PATCH') }}
                                <input type="hidden" name="id" value="{{ $task_app->id }}">
                                <input type="hidden" name="sql_kind" value="update_date">
                                <span class="date">{{ $task_app->date }}</span>
                            </form>
                            @endif
                        </td>

                        <!--取り消し-->
                        <td>
                            <form method="post" action="{{ url('/task_apps')}}">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <input type="submit" value="取り消し" class="btn btn-primary cancel">
                                <input type="hidden" name="id" value="{{ $task_app->id }}">
                            </form>
                        </td>

                        <!--削除-->
                        <td>
                            <form method="post" action="{{ url('/task_apps')}}">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <input type="submit" value="完了" class="btn btn-primary delete">
                                <input type="hidden" name="id" value="{{ $task_app->id }}">
                                <input type="hidden" name="body" value="{{ $task_app->body }}">
                                <input type="hidden" name="description" value="{{ $task_app->description }}">
                                <input type="hidden" name="category" value="{{ $task_app->category }}">
                            </form>
                        </td>
                    </tr>
                @empty
                    <p class="no_list">リストがありません。</p>
                @endforelse
            </table>

        </li>

        <!--やること完了済みリスト-->
        <li>
            <table class="table table_archive table-bordered table-hover table-sm table-responsive">
                <tr class="thead-light">
                    <th class="text-nowrap col-6">やったこと</th>
                    <th class="text-nowrap hidden">詳細</th>
                    <th class="text-nowrap hidden">カテゴリー</th>
                    <th class="text-nowrap">完了日</th>
                </tr>
            @forelse($task_apps_archive as $task_app_archive)
                <tr class="pop">
                    <td class="text-nowrap col-6">
                        <div>{{ $task_app_archive->body }}</div>
                    </td>
                    <td class="hidden">
                        @if($task_app_archive->description === null)
                            なし
                        @else
                        <div class="description">
                            <button class="btn btn-primary">詳細</button>
                        </div>
                        @endif
                        <!--ポップアップ時の処理-->
                        <div class="popup">
                            <div class="popup_content">
                                <p>{{ $task_app_archive->description }}</p>
                                <button class="back btn btn-primary">閉じる</button>
                            </div>
                        </div>
                    </td>
                    <td class="text-nowrap">
                        @if($task_app_archive->category !== null)
                            <div>{{$task_app_archive->category}}</div>
                        @else
                            <div>未設定</div>
                        @endif
                    </td>
                    <td class="text-nowrap">
                        <div>{{ $task_app_archive->created_at }}</div>
                    </td>
                </tr>
            @empty
                <p class="no_list">リストがありません。</p>
            @endforelse
            </table>

            <div class="d-flex justify-content-center">
                    {{ $task_apps_archive->links() }}
            </div>

        </li>
    </ul>
</div>
@endsection
