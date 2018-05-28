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
                    H.G.S.のユーザー情報および、サイト情報はだいたい引き継ぐことができたのですが、下記の3項目については引き継げませんでした。<br>
                    H.G.N.ご利用予定の方で該当されそう場合は、大変申し訳ありませんが、それぞれの項目について各自でご対応をお願いします。<br>
                    対応手順は、本画面内に記載しております。
                </p>
                <ul class="mb-4">
                    <li>ログインパスワード</li>
                    <li>サイトのバナー(一部のサイトのみ)</li>
                    <li>ユーザーアイコン</li>
                </ul>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">ログインパスワード</h4>
                <h6>□対象ユーザー</h6>
                <p>
                    H.G.S.でメール・パスワード認証を利用していた方<br>
                    ※Twitter認証は影響ありません。
                </p>

                <h6>□対応方法</h6>
                <p>
                    <a href="{{ route('パスワード再設定') }}">パスワード再設定画面</a>で、パスワードの再設定を行ってください。<br>
                    新しいパスワードでログインできるようになります。
                </p>

                <h6>□引き継げなかった理由</h6>
                <p class="mb-0">
                    データベース上にパスワードは暗号化して保存しており、元のパスワードを知ることができません。<br>
                    今回、システムの入れ替えにあたって、より安全な暗号に変更したため、元のパスワードを再度暗号化する必要がありました。<br>
                    でも、元のパスワードを知ることができないので、再暗号化することが不可能でした。
                </p>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">サイトのバナー(一部のサイトのみ)</h4>
                <h6>●対象ユーザー</h6>
                <p>yomi-search時代にサイトを登録していた方</p>

                <h6>●対応方法</h6>
                <p>サイト情報の編集画面で、新たにバナー画像を設定してください。</p>

                <h6>●引き継げなかった理由</h6>
                <p class="mb-0">間違えてバナー画像消しちゃいました…</p>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">ユーザーアイコン</h4>
                <h6>●対象ユーザー</h6>
                <p>H.G.S.でユーザーアイコンを登録していた方</p>

                <h6>●対応方法</h6>
                <p>プロフィール設定画面でアイコンを再設定してください。</p>

                <h6>●引き継げなかった理由</h6>
                <p class="mb-0">システムの変更で、外部のURLからアイコンを利用できなくしました。</p>
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