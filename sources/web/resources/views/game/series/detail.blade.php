@extends('layouts.app')

@section('title')シリーズ@endsection
@section('global_back_link'){{ route('シリーズ一覧') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>{{ $series->name }}シリーズ</h1>
        </header>

        <div class="card">
            <div class="card-body">
                <div class="contacts row">
                    @foreach ($softs as $game)
                        @php
                            $package = hv($packages, $game->original_package_id, null);
                            $imageUrl = $package ? medium_image_url($package) : '';
                        @endphp
                    <div class="col-xl-2 col-lg-3 col-sm-4 col-12">
                        <div class="contacts__item">
                            <a href="{{ route('ゲーム詳細', ['soft' => $game->id]) }}" class="contacts__img">
                                @empty($imageUrl)
                                    <img data-normal="{{ url('img/pkg_no_img_m.png') }}" class="rounded">
                                @else
                                    <img data-normal="{{ $imageUrl }}" class="rounded-0" style="max-height: initial !important;">
                                @endif
                            </a>

                            <div>
                                <a href="{{ route('ゲーム詳細', ['soft' => $game->id]) }}">{{ $game->name }}</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
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
