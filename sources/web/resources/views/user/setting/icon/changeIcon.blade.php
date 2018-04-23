@extends('layouts.app')

@section('title')アイコン変更@endsection
@section('global_back_link'){{ route('ユーザー設定') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>アイコン変更</h1>
        </header>

        <div class="mb-3">
            <a href="{{ route('アイコン丸み変更') }}">アイコン画像は変えずに丸みだけ変える場合はこちら</a>
        </div>
        <div class="mb-5">
            <a href="{{ route('アイコン画像変更') }}">アイコン画像を変える場合はこちら</a>
        </div>

        <div>
            <form method="POST" action="{{ route('アイコン削除') }}" onsubmit="return confirm('デフォルトのアイコンに戻します。いいですか？');">
                {{ method_field('DELETE') }}
                {{ csrf_field() }}
                <button class="btn btn-warning">アイコンを削除して、初期状態に戻す</button>
            </form>
        </div>
    </div>

@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('マイページ') }}">ユーザー</a></li>
            <li class="breadcrumb-item"><a href="{{ route('ユーザー設定') }}">設定</a></li>
            <li class="breadcrumb-item active" aria-current="page">アイコン変更</li>
        </ol>
    </nav>
@endsection