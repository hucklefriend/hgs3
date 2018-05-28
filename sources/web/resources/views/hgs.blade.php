@extends('layouts.app')

@section('title')H.G.S.からの引き継ぎについて@endsection
@section('global_back_link'){{ route('トップ') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>H.G.S.からの引き継ぎについて</h1>
        </header>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">完全には引き継げませんでした</h4>
                <p>
                    H.G.S.のユーザー情報および、サイト情報はほぼ全て引き継ぐことができたのですが、<strong>パスワードだけは引き継げませんでした</strong>。<br>
                    なのでランダムな文字列をパスワードに設定し、ログインできない状態にしております。<br>
                    Twitterとの連携で登録していた方は、そのままTwitterのアカウントでログインできます。
                </p>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">どうすればいい？</h4>
                <p class="mb-0">
                    <a href="{{ route('パスワード再設定') }}">パスワード再設定画面</a>で、パスワードの再設定を行ってください。<br>
                    新しいパスワードでログインできるようになります。
                </p>
            </div>
        </div>


        <div class="card">
            <div class="card-body">
                <h4 class="card-title">なぜパスワードだけ引き継げなかったのか</h4>
                <p class="mb-0">
                    データベース上にパスワードは暗号化して保存しており、元のパスワードを知ることができません。<br>
                    今回、システムの入れ替えにあたって、より安全な暗号に変更したため、元のパスワードを再度暗号化する必要がありました。<br>
                    でも、元のパスワードを知ることができないので、再暗号化することが不可能でした。
                </p>
            </div>
        </div>
    </div>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item active" aria-current="page">H.G.S.からの引き継ぎについて</li>
        </ol>
    </nav>
@endsection