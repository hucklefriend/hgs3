@extends('layouts.app')


@section('title')アクセスログ@endsection
@section('global_back_link')
    @isset($ym)
    {{ route('サイトアクセスログ', ['site' => $site->id]) }}?ym={{ $ym }}
    @else
    {{ route('サイトアクセスログ', ['site' => $site->id]) }}
    @endif
@endsection

@section('content')
    <h1>{{ $date->format('Y年n月j日') }}の足跡</h1>

    @foreach ($footprints as $footprint)
        <div style="margin-top: 15px;">
            {{ date('Y-m-d H:i:s', $footprint->time) }}<br>
            @include('user.common.icon', ['u' => $users[$footprint->user_id] ?? null])
            @if (isset($users[$footprint->user_id]))
                @include('user.common.user_name', ['u' => $users[$footprint->user_id]])
            @else
                ゲストさん
            @endif
        </div>
    @endforeach

    @include('common.pager', ['pager' => $pager])

@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('サイトトップ') }}">サイト</a></li>
            <li class="breadcrumb-item"><a href="{{ route('サイト詳細', ['site' => $site->id]) }}">詳細</a></li>
            @isset($ym)
            <li class="breadcrumb-item"><a href="{{ route('サイトアクセスログ', ['site' => $site->id]) }}?ym={{ $ym }}">アクセスログ</a></li>
            @else
            <li class="breadcrumb-item"><a href="{{ route('サイトアクセスログ', ['site' => $site->id]) }}">アクセスログ</a></li>
            @endif
            <li class="breadcrumb-item active" aria-current="page">足跡</li>
        </ol>
    </nav>
@endsection
