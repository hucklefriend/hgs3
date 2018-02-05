@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('ゲーム会社一覧') }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')
    <h4>{{ $company->name }}</h4>

    <div>
        @if ($company->url != null)
        <a href="{{ $company->url }}" target="_blank">公式サイト</a>
        @endif
        @if ($company->wikipedia != null)
        <a href="{{ $company->wikipedia }}" target="_blank">Wikipedia</a>
        @endif
    </div>


    @if (is_data_editor())
    <div class="text-right">
        <a href="{{ route('ゲーム会社編集', ['company' => $company->id]) }}" class="btn btn-sm btn-outline-info">データ編集</a>
    </div>
    @endif

    <hr>

    <p>
        {{ $company->name }}から発売されているパッケージ
    </p>

    <div class="d-flex flex-wrap">

    @foreach ($packages as $package)
            <div class="card" style="width: 250px;margin: 10px;padding-top: 10px;">
                @include('game.common.packageImage', ['imageUrl' => $package->medium_image_url])
                <div class="card-body text-center">
                    <h4 class="card-title">
                        @isset($softs[$package->id])
                            <a href="{{ route('ゲーム詳細', ['soft' => $softs[$package->id]]) }}">{{ $package->name }}</a>
                        @else
                            {{ $package->name }}
                        @endif
                    </h4>
                    <p class="card-text">
                        @isset($shops[$package->id])
                            @foreach ($shops[$package->id] as $shop)
                                @include('game.common.shop', ['shopId' => $shop->shop_id, 'shopUrl' => $shop->shop_url])
                            @endforeach
                        @endisset
                    </p>
                </div>
            </div>
    @endforeach
    </div>

@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('ゲーム会社一覧') }}">ゲーム会社一覧</a></li>
            <li class="breadcrumb-item active" aria-current="page">詳細</li>
        </ol>
    </nav>
@endsection