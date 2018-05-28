@extends('layouts.app')

@section('title')サイト検索@endsection
@section('global_back_link'){{ route('サイトトップ') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>サイト検索</h1>
            <p>このゲームを扱っているサイト</p>
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
            <li class="breadcrumb-item"><a href="{{ route('サイトトップ') }}">サイト</a></li>
            <li class="breadcrumb-item active" aria-current="page">サイト検索</li>
        </ol>
    </nav>
@endsection