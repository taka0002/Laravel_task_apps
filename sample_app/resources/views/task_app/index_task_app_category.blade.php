@extends('layouts.default')

@section('title', $title)

@section('content')
<div class="container">
    <h1 class="text-primary"><a href="{{ url('/task_apps') }}" rel=”noopener”>{{ $title }}</a></h1>
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

    <!--カテゴリー一覧-->
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-sm">
            <tr class="thead-light">
                <th class="text-nowrap category_name">カテゴリー名</th>
                <th class="text-nowrap">削除</th>
            </tr>
            @forelse($categories as $category)
            <tr class="thead-light">
                <td class="text-nowrap">
                    <form method="post" action="{{ url('/task_apps_category')}}" id="submit_form">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <div class="text_category">{{ $category->category_name }}</div>
                        <input type="hidden" name="sql_kind" value="change_category">
                        <input type="hidden" name="id" value="{{ $category->id }}">
                    </form>
                </td>
                <td>
                    <form method="post" action="{{ url('/task_apps_category')}}">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <input type="submit" value="削除" class="btn btn-primary">
                        <input type="hidden" name="id" value="{{ $category->id }}">
                        <input type="hidden" name="category_name" value="{{ $category->category_name }}">
                    </form>
                </td>
            </tr>
            @empty
            @endforelse
        </table>
    </div>

</div>
@endsection
