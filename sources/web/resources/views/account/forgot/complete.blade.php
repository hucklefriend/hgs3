@extends('layouts.app')

@section('title')パスワード再設定@endsection
@section('global_back_link'){{ \Hgs3\Http\GlobalBack::clearAndRoute('トップ') }}@endsection

@section('content')

    <div class="content__inner">
        <header class="content__title">
            <h1>パスワード再設定</h1>
        </header>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">パスワード再設定完了</h4>

                <p>
                    パスワードの再設定が完了しました。<br>
                    <a href="{{ route('ログイン') }}">ログイン</a>
                </p>
            </div>
        </div>
    </div>
@endsection
