@extends('layouts.app')

@section('title')パスワード再設定@endsection
@section('global_back_link'){{ \Hgs3\Http\GlobalBack::clearAndRoute('パスワード再設定') }}@endsection

@section('content')

    <div class="content__inner">
        <header class="content__title">
            <h1>パスワード再設定</h1>
        </header>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">メール送信に失敗しました。</h4>
                <p>
                    パスワード再設定メールの送信に失敗しました。<br>
                    メールアドレスの入力間違いがないかご確認ください。<br>
                    何回やってもこの画面が表示される場合は、管理人までご連絡ください。
                </p>
            </div>
        </div>
    </div>
@endsection
