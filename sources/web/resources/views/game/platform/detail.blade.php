@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('プラットフォーム一覧') }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')
    <h1>{{ $platform->name }}</h1>

    <div>
        @if ($platform->url != null)
        <a href="{{ $platform->url }}" target="_blank">公式サイト</a>
        @endif
        @if ($platform->wikipedia != null)
        <a href="{{ $platform->wikipedia }}" target="_blank">Wikipedia</a>
        @endif
    </div>

    @if (is_data_editor())
    <div class="text-right">
        <a href="{{ route('プラットフォーム編集', ['platform' => $platform->id]) }}" class="btn btn-sm btn-outline-info">編集</a>
    </div>
    @endif

    <hr>

    <p>{{ $platform->name }}で発売されているパッケージ</p>

    <div class="package-list">
        @foreach ($packages as $package)
            @include('game.common.packageCard', ['soft' => $package])
        @endforeach
    </div>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('プラットフォーム一覧') }}">プラットフォーム一覧</a></li>
            <li class="breadcrumb-item active" aria-current="page">詳細</li>
        </ol>
    </nav>
@endsection
