@extends('layouts.app')

@section('content')

    <div>
        <a href="{{ url('/user/site/myself') }}">サイト一覧へ戻る</a> |
        <a href="{{ url('/user/site/detail') }}/{{ $siteId }}">登録したサイトの詳細へ</a>
    </div>

    <p>登録が完了しました。</p>

@endsection