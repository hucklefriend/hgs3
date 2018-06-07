@extends('layouts.app')

@section('title'){{ $soft->name }}を扱っているサイト@endsection
@section('global_back_link'){{ \Hgs3\Http\GlobalBack::siteBySoft($soft) }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>{{ $soft->name }}</h1>
            <p>取扱いサイト</p>
        </header>

        @foreach ($pager as $p)
            <?php $s = $sites[$p->site_id]; ?>
            <div style="margin-top: 10px;margin-bottom: 30px;">
                @include('site.common.normal', ['s' => $s, 'u' => $users[$s->user_id]])
            </div>
        @endforeach
        @include('common.pager', ['pager' => $pager])
    </div>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('ゲーム一覧') }}">ゲーム一覧</a></li>
            <li class="breadcrumb-item"><a href="{{ route('ゲーム詳細', ['game' => $soft->id]) }}">詳細</a></li>
            <li class="breadcrumb-item active" aria-current="page">取扱いサイト</li>
        </ol>
    </nav>
@endsection