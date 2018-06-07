@extends('layouts.app')

@section('title')facebookでログイン@endsection
@section('global_back_link'){{ \Hgs3\Http\GlobalBack::clearAndRoute('ログイン') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>facebookでログイン</h1>
        </header>

        <p>このアカウントは登録されていません。</p>
    </div>
@endsection