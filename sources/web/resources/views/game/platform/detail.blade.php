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

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">対応ゲーム</h4>
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

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('プラットフォーム一覧') }}">プラットフォーム一覧</a></li>
            <li class="breadcrumb-item active" aria-current="page">詳細</li>
        </ol>
    </nav>
@endsection
