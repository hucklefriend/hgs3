@extends('layouts.app')

@section('title')GitHubでユーザー登録@endsection
@section('global_back_link'){{ route('ユーザー登録') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>GitHubでユーザー登録</h1>
        </header>
        <p>このアカウントは既に登録されています。</p>
        <p><a href="{{ route('ログイン') }}">ログイン</a></p>
    </div>
@endsection