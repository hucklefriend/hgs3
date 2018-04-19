@extends('layouts.app')

@section('title')メール認証削除@endsection
@section('global_back_link'){{ route('ユーザー設定') }}@endsection

@section('content')
    <h1>メール認証削除エラー</h1>
    <p>
        ログイン手段がなくなるため、メール認証設定を削除できません。<br>
        メール認証設定を削除するには、SNSサイトとの連携を行ってください。
    </p>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('マイページ') }}">ユーザー</a></li>
            <li class="breadcrumb-item"><a href="{{ route('ユーザー設定') }}">設定</a></li>
            <li class="breadcrumb-item active" aria-current="page">メール認証</li>
        </ol>
    </nav>
@endsection