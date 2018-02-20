@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('プロフィール', ['showId' => $user->show_id]) }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')
    <h1>アイコン変更</h1>

    <div class="p-3">
        <a href="{{ route('アイコン丸み変更') }}">アイコン画像は変えずに丸みだけ変える場合はこちら</a>
    </div>

    <div class="p-3">
        <a href="{{ route('アイコン画像変更') }}">アイコン画像を変える場合はこちら</a>
    </div>

    <form method="POST" action="{{ route('アイコン削除') }}" onsubmit="return confirm('デフォルトのアイコンに戻します。いいですか？');" class="p-3">
        {{ method_field('DELETE') }}
        {{ csrf_field() }}
        <button class="btn btn-outline-danger">アイコンを削除して、初期状態に戻す</button>
    </form>

@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('プロフィール', ['showId' => $user->show_id]) }}">ユーザー</a></li>
            <li class="breadcrumb-item active" aria-current="page">アイコン変更</li>
        </ol>
    </nav>
@endsection