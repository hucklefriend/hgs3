@extends('layouts.app')

@section('title')Google+でログイン@endsection
@section('global_back_link'){{ \Hgs3\Http\GlobalBack::clearAndRoute('ログイン') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>Google+でログイン</h1>
        </header>

        <p>このアカウントは登録されていません。</p>
    </div>
@endsection