@extends('layouts.app')

@section('title')ユーザー登録@endsection
@section('global_back_link'){{ route('トップ') }}@endsection

@section('content')

    <div class="content__inner">
        <header class="content__title">
            <h1>ユーザー登録</h1>
        </header>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">仮登録メールを送信しました。</h4>

                <p>
                    24時間以内にお送りしたメールに記載したURLからアクセスしてください。<br>
                    アクセスした時点でユーザー情報を登録し、H.G.N.にログインできるようになります！
                </p>
                <p>
                    2～3回やってもメールが届かない場合は、管理人までお問い合わせください。<br>
                    その前に、メールがスパム扱いされていないか、「webmaster@horrorgame.net」からのメールアドレスが受信拒否対象になっていないか、一度ご確認ください。
                </p>
            </div>
        </div>

    </div>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item active" aria-current="page">ユーザー登録</li>
        </ol>
    </nav>
@endsection