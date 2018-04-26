@extends('layouts.app')

@section('title')プラットフォーム@endsection
@section('global_back_link'){{ route('プラットフォーム一覧') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>{{ $platform->name }}</h1>
        </header>

        <div>
            @if ($platform->url != null)
                <a href="{{ $platform->url }}" target="_blank">公式サイト</a>
            @endif
            @if ($platform->wikipedia != null)
                <a href="{{ $platform->wikipedia }}" target="_blank">Wikipedia</a>
            @endif
        </div>
        <hr>

        <p>{{ $platform->name }}で発売されているパッケージ</p>

        <div class="package-list">
            @foreach ($packages as $package)
                @include('game.common.packageCard', ['soft' => $package, 'toPackage' => true])
            @endforeach
        </div>
        <div class="row">
            @foreach ($packages as $package)
                @include('game.common.packageCard', ['soft' => $package, 'toPackage' => true])
            @endforeach
        </div>




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
