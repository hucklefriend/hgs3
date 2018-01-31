@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('ユーザー登録') }}">&lt;</a>
@endsection

@section('content')

    <h1>メール送信に失敗しました。</h1>
    <p>
        仮登録メールの送信に失敗しました。<br>
        メールアドレスの入力間違いがないかご確認ください。<br>
        何回やってもこの画面が表示される場合は、管理人までご連絡ください。
    </p>

@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('ユーザー登録') }}">ユーザー登録</a></li>
            <li class="breadcrumb-item active" aria-current="page">メール送信エラー</li>
        </ol>
    </nav>
@endsection