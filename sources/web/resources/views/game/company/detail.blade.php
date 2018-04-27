@extends('layouts.app')

@section('title')ゲーム会社@endsection
@section('global_back_link'){{ route('ゲーム会社一覧') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>{{ $company->name }}</h1>
        </header>

        @if (!empty($company->url) && !empty($company->wikipedia))
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    @if (!empty($company->url))
                        <a href="{{ $company->url }}" target="_blank" class="mr-3">公式サイト</a>
                    @endif
                    @if (!empty($company->wikipedia))
                        <a href="{{ $company->wikipedia }}" target="_blank">Wikipedia</a>
                    @endif
                </div>
            </div>
        </div>
        @endif

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">販売ゲーム</h4>
                <div class="package-list mt-5">
                    @foreach ($soft as $s)
                        <div class="col-xl-2 col-lg-3 col-sm-4 col-12">
                            <div class="contacts__item">
                                <a href="{{ route('ゲーム詳細', ['soft' => $s->id]) }}" class="contacts__img">
                                    @empty($packages[$s->id]->package_image_url)
                                        <img data-normal="{{ url('img/pkg_no_img_m.png') }}" class="rounded big-package-card">
                                    @else
                                        <img data-normal="{{ $packages[$s->id]->package_image_url }}" class="rounded-0 big-package-card">
                                    @endif
                                </a>

                                <div>
                                    <a href="{{ route('ゲーム詳細', ['soft' => $s->id]) }}">{{ $s->name }}</a>
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
            <li class="breadcrumb-item"><a href="{{ route('ゲーム会社一覧') }}">ゲーム会社一覧</a></li>
            <li class="breadcrumb-item active" aria-current="page">詳細</li>
        </ol>
    </nav>
@endsection