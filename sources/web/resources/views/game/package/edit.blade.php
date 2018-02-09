@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('ゲーム詳細', ['soft' => $soft->id]) }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')
    <h1>{{ $soft->name }}のパッケージ編集</h1>

    <form method="POST" method="{{ route('パッケージ編集処理', ['soft' => $soft->id, 'package' => $package->id]) }}" autocomplete="off">
        {{ method_field('PATCH') }}
        {{ csrf_field() }}

        @include('game.package.form', ['soft' => $soft, 'package' => $package])

        <div class="form-group">
            <button class="btn btn-primary">更新</button>
        </div>
    </form>
@endsection


@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('ゲーム一覧') }}">ゲーム一覧</a></li>
            <li class="breadcrumb-item"><a href="{{ route('ゲーム詳細', ['soft' => $soft->id]) }}">詳細</a></li>
            <li class="breadcrumb-item active" aria-current="page">パッケージ編集</li>
        </ol>
    </nav>
@endsection
