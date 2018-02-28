@extends('layouts.app')

@section('title')退会 @endsection

@section('global_back_link')
    <a href="{{ route('トップ') }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')
    <h1>退会</h1>

    <div class="pl-3">
        <p>退会処理を行っても、下記のデータは削除されず、「匿名のユーザーが行ったもの」として残ります。</p>
        <ul>
            <li>サイトの足跡</li>
        </ul>
    </div>

    <p class="pl-3">
        [退会する]ボタンを押すと、最終確認ダイアログが表示されます。<br>
        そこで[OK]ボタンを押すと、退会処理が実行されます。
    </p>

    <form method="POST" action="{{ route('退会処理') }}" autocomplete="off" onsubmit="return confirm('退会します。これまでのご利用、ありがとうございました。');">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
        <div class="text-center">
            <button type="submit" class="btn btn-danger">退会する</button>
        </div>
    </form>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item active" aria-current="page">退会</li>
        </ol>
    </nav>
@endsection
