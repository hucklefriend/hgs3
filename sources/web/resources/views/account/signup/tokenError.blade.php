@extends('layouts.app')

@section('title')ユーザー登録@endsection
@section('global_back_link'){{ route('ユーザー登録') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>ユーザー登録</h1>
        </header>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">トークンエラー</h4>

                <p>
                    有効期限が切れているか、URLが間違っています。<br>
                    もう一度最初からやり直すか、メールに記載のURLとあっているかご確認ください。
                </p>
            </div>
        </div>
    </div>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('ユーザー登録') }}">ユーザー登録</a></li>
            <li class="breadcrumb-item active" aria-current="page">有効期限エラー</li>
        </ol>
    </nav>
@endsection