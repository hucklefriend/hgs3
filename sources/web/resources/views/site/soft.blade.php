@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('ゲーム詳細', ['game' => $soft->id]) }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')

    <h1><a href="{{ route('ゲーム詳細', ['game' => $soft->id]) }}">{{ $soft->name }}</a>を扱っているサイト</h1>

    @foreach ($pager as $p)
        <?php $s = $sites[$p->site_id]; ?>
        <div>
            @include('site.common.normal', ['s' => $s, 'u' => $users[$s->user_id]])
        </div>
        <hr>
    @endforeach
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('ゲーム一覧') }}">ゲーム一覧</a></li>
            <li class="breadcrumb-item"><a href="{{ route('ゲーム詳細', ['game' => $soft->id]) }}">ゲーム詳細</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $soft->name }}を扱っているサイト</li>
        </ol>
    </nav>
@endsection