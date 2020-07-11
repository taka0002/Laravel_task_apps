{{-- レイアウトファイルを指定 --}}
@extends('layouts.default')


{{-- @yield('title') の部分を穴埋め --}}
@section('title', $title)

{{-- @yield('content') の部分を穴埋め --}}
@section('content')

    <h1>M{{ $title }}</h1>
    <p>
        {{ $message->name }}:
        {{ $message->body }}
    </p>
@endsection