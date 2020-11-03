@extends('layouts.app')

@section('title')サイト@endsection
@section('global_back_link'){{ \Hgs3\Http\GlobalBack::clearAndRoute('サイトトップ') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>アクセスできません。</h1>
        </header>

        <p>こちらのサイトは承認されていないか、非公開にされているため表示できません。</p>
    </div>
@endsection
