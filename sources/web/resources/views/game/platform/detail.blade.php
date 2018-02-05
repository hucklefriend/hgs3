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

    <ul class="list-group">
    @foreach ($packages as $package)
        <li class="list-group-item">
            <div class="d-flex align-items-stretch">
                <div class="align-self-top p-2">
                    @include('game.common.packageImage', ['imageUrl' => $package->small_image_url])
                </div>
                <div class="align-self-top">
                    <div><h4>{{ $package->name }}</h4></div>
                    @isset($companies[$package->company_id])
                        <div>
                            <i class="far fa-building"></i>&nbsp;<a href="{{ route('ゲーム会社詳細', ['company' => $package->company_id]) }}">{{ hv($companies, $package->company_id) }}</a>
                        </div>
                    @endisset
                    <div>{{ $package->release_at }}</div>
                    <div>
                        @isset($package->item_url)
                            <a href="{{ $package->item_url }}" target="_blank"><img src="{{ url('img/assocbutt_or_detail._V371070159_.png') }}"></a>
                        @endisset
                    </div>
                </div>
            </div>
        </li>
    @endforeach
    </ul>

    @include('common.pager', ['pager' => $packages])
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
