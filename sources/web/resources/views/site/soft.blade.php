@extends('layouts.app')

@section('title')サイト@endsection
@section('global_back_link'){{ route('ゲーム詳細', ['game' => $soft->id]) }}@endsection

@section('content')
    <h1><a href="{{ route('ゲーム詳細', ['game' => $soft->id]) }}">{{ $soft->name }}</a>を扱っているサイト</h1>

    @foreach ($pager as $p)
        <?php $s = $sites[$p->site_id]; ?>
        <div style="margin-top: 10px;margin-bottom: 30px;">
            @include('site.common.normal', ['s' => $s, 'u' => $users[$s->user_id]])
        </div>
    @endforeach

    @include('common.pager', ['pager' => $pager])

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