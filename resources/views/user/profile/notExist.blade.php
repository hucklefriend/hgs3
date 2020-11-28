@extends('layouts.app')

@section('title')ユーザー@endsection
@section('global_back_link'){{ \Hgs3\Http\GlobalBack::clearAndRoute('トップ') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>ユーザーが見つかりませんでした。</h1>
        </header>

        <p>
            指定されたユーザーが見つかりませんでした。<br>
            退会されたのかもしれません。
        </p>
    </div>

@endsection
