@extends('layouts.app')

@section('title')プラットフォーム@endsection
@section('global_back_link'){{ \Hgs3\Http\GlobalBack::platformDetail($platform) }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>{{ $platform->name }}</h1>
        </header>

        @if (!empty($platform->url) && !empty($platform->wikipedia))
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-wrap">
                        @if (!empty($platform->url))
                            <a href="{{ $platform->url }}" class="badge badge-pill badge-secondary mr-3" target="_blank">公式サイト <i class="fas fa-sign-out-alt"></i></a>
                        @endif
                        @if (!empty($platform->wikipedia))
                            <a href="{{ $platform->wikipedia }}" class="badge badge-pill badge-secondary mr-3" target="_blank">Wikipedia <i class="fas fa-sign-out-alt"></i></a>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">販売ゲーム</h4>
                <div class="contacts row mt-5">
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

