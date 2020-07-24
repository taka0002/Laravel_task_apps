@extends('layouts.default')

@section('title', $title)

@section('content')
<div class="container">
    <h1>{{ $title }}</h1>
    <p class="username">現在のユーザー名: <span>{{ Auth::user()->name }}</span></p>
    <form action="{{ url('/logout') }}" method="post" class="post">
        {{ csrf_field() }}
        <button type="submit" class="btn btn-primary">ログアウト</button>
    </form>

    @if (session('status'))
    <div class="alert alert-success" role="alert" onclick="this.classList.add('hidden')">
        {{ session('status') }}
    </div>
    @endif

    {{-- エラーメッセージを出力 --}}
    @foreach($errors->all() as $error)
    <p class="error">{{ $error }}</p>
    @endforeach
    {{-- 以下にフォームを追記します。 --}}
    <form method="post" action="{{ url('/task_apps') }}" enctype="multipart/form-data">
        {{-- LaravelではCSRF対策のため以下の一行が必須です。 --}}
        {{ csrf_field() }}

        <div>
            <label>
                <input type="text" name="body" class="comment_field" placeholder="To Doを入力">
            </label>
        </div>

        <div>
            <label>
                <span>締め切り日時：</span>
                <input type="date" name="date" class="date_field" placeholder="締め切り日時を入力">
            </label>
        </div>

        <div>
            <label>
                <select name="status" class="status">
                        <option value="0">未着手</option>
                        <option value="1">着手中</option>   
                </select>
            </label>
        </div>

        <div class="post">
            <input type="submit" value="登録" class="btn btn-primary">
        </div>
    </form>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
                <tr class="thead-light">
                    <th class="text-nowrap">やること</th>
                    <th class="text-nowrap">現在のステータス</th>
                    <th class="text-nowrap">
                    <form method="get" action="{{ url('/task_apps')}}" id="submit_form">
                        <select name="sort" class="text">
                            <option value="">締め切り期限</option>
                            <option value="asc">昇順</option>
                            <option value="desc">降順</option>
                        </select>
                    </form>
                    </th>
                    <th class="text-nowrap">終わったら</th>
                </tr>
                @forelse($task_apps as $task_app)
                <tr class="<?php echo $task_app->status === 1 ? "false" : "" ?>">
                    <td class="text-nowrap">
                        <form method="post" action="{{ url('/task_apps')}}" id="submit_form">
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}
                            <input type="hidden" name="id" value="{{ $task_app->id }}">
                            <input type="hidden" name="sql_kind" value="update_text">
                            <div class="text">{{ $task_app->body }}</div>
                        </form>
                    </td>
                    <td>
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
                        <input type="submit" value="着手中" class="update">
                        <input type="hidden" name="id" value="{{ $task_app->id }}">
                        <input type="hidden" name="sql_kind" value="update">
                    </form>
                    @endif
                    </td>
                    <td>{{ $task_app->date }}</td>
                    <td>
                    <form method="post" action="{{ url('/task_apps')}}">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <input type="submit" value="削除" class="btn btn-primary">
                    <input type="hidden" name="id" value="{{ $task_app->id }}">
                    </form>
                    </td>
                </tr>
            @empty
                <li>リストがありません。</li>
            @endforelse
        </table>
    </div>
</div>
@endsection