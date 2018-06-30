@extends('layouts.app')

@section('title')サイトが見つかりませんでした@endsection
@section('global_back_link'){{ \Hgs3\Http\GlobalBack::clearAndRoute('サイトトップ') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>サイトが見つかりませんでした。</h1>
        </header>

        <p>こちらのサイトは削除された可能性があります。</p>
    </div>
@endsection
