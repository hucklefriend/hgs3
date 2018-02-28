@extends('layouts.app')

@section('title')シリーズ詳細 @endsection

@section('global_back_link')
    <a href="{{ route('シリーズ一覧') }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')
    <h1>{{ $series->name }}シリーズのゲーム</h1>

    <div class="d-flex flex-wrap">
        @foreach ($softs as $game)
            @php
            $package = hv($packages, $game->original_package_id, null);
            $imageUrl = large_image_url($package);
            @endphp
            <div class="card" style="width: 250px;margin: 10px;padding-top: 10px;">
                @include('game.common.packageImage', ['imageUrl' => $imageUrl])
                <div class="card-body text-center">
                    <h4 class="card-title">
                        <a href="{{ route('ゲーム詳細', ['soft' => $game->id]) }}">{{ $game->name }}</a>
                    </h4>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('シリーズ一覧') }}">シリーズ一覧</a></li>
            <li class="breadcrumb-item active" aria-current="page">詳細</li>
        </ol>
    </nav>
@endsection
