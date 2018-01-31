@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('サイト管理') }}">&lt;</a>
@endsection

@section('content')
    <h1>H.G.S.から引き継ぎ</h1>

    <p>
        引き継ぐサイトを選択してください。<br>
        何回でも引き継いで登録できますが、同じサイトを複数登録しないようお願いします。
    </p>

    <ul class="list-group">
    @foreach ($hgs2Sites as $hgs2Site)
        <li class="list-group-item">
            <a href="{{ route('サイト引継登録', ['hgs2SiteId' => $hgs2Site->id]) }}">{{ $hgs2Site->site_name }}</a>
        </li>
    @endforeach
    </ul>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('マイページ') }}">ユーザー</a></li>
            <li class="breadcrumb-item"><a href="{{ route('サイト管理') }}">サイト</a></li>
            <li class="breadcrumb-item active" aria-current="page">H.G.S.から引き継ぎ</li>
        </ol>
    </nav>
@endsection