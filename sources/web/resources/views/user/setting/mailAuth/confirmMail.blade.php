@extends('layouts.app')

@section('title')メールアドレス変更@endsection
@section('global_back_link'){{ route('ユーザー設定') }}@endsection

@section('content')
    <h1>メールアドレス変更完了</h1>
    <p>メールアドレスの変更が完了しました。</p>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('マイページ') }}">ユーザー</a></li>
            <li class="breadcrumb-item"><a href="{{ route('ユーザー設定') }}">設定</a></li>
            <li class="breadcrumb-item active" aria-current="page">メアド変更完了</li>
        </ol>
    </nav>
@endsection