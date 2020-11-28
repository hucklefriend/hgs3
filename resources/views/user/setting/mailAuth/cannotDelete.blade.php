@extends('layouts.app')

@section('title')メール認証削除@endsection
@section('global_back_link'){{ route('ユーザー設定') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>メール認証削除エラー</h1>
        </header>

        <p>
            ログイン手段がなくなるため、メール認証設定を削除できません。<br>
            メール認証設定を削除するには、SNSサイトとの連携を行ってください。
        </p>
    </div>
@endsection
