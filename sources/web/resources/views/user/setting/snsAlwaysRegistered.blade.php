@extends('layouts.app')

@section('title')外部サイト連携@endsection
@section('global_back_link'){{ route('ユーザー設定') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>外部サイトログイン連携エラー</h1>
        </header>

        <p>この{{ $sns }}アカウントは当サイトですでに登録済みです。</p>
    </div>
@endsection
