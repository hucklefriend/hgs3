@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('ゲーム詳細', ['soft' => $soft->id]) }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')
    <h1>{{ $soft->name }}のパッケージ登録</h1>

    <div>
        既存のパッケージから紐づけ
    </div>

    <form method="POST" action="{{ route('パッケージ登録処理', ['soft' => $soft->id]) }}" autocomplete="off">
        {{ csrf_field() }}

        @include('game.package.form', ['soft' => $soft, 'package' => new \Hgs3\Models\Orm\GamePackage])

        <div class="form-group">
            <button class="btn btn-primary">登録</button>
        </div>
    </form>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('ゲーム一覧') }}">ゲーム一覧</a></li>
            <li class="breadcrumb-item"><a href="{{ route('ゲーム詳細', ['soft' => $soft->id]) }}">詳細</a></li>
            <li class="breadcrumb-item active" aria-current="page">パッケージ登録</li>
        </ol>
    </nav>
@endsection
