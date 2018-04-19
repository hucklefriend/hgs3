@extends('layouts.app')

@section('title')パスワード再設定@endsection
@section('global_back_link'){{ route('パスワード再設定') }}@endsection

@section('content')
    <h1>期限切れ</h1>

    <p>
        有効期限が切れています。<br>
        もう一度最初からやり直してください。
    </p>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('パスワード再設定') }}">パスワード再設定</a></li>
            <li class="breadcrumb-item active" aria-current="page">有効期限エラー</li>
        </ol>
    </nav>
@endsection