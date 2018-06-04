@extends('layouts.app')

@section('title')レビュー@endsection
@section('global_back_link'){{ route('トップ') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>レビュー</h1>
        </header>

        <div class="row">
            <div class="col-12 col-md-6 col-xl-5">
                <div class="card card-hgn">
                    <div class="card-body">
                        <h5 class="card-title">新着レビュー</h5>

                        @foreach ($newArrivals as $review)
                        <div class="mb-5">
                            <div class="review-list-title"><a href="{{ route('レビュー', ['review' => $review->id]) }}">{{ $review->soft->name }}</a></div>
                            <div class="d-flex justify-content-between">
                                <div class="d-flex">
                                    <div class="review-list-package-image mr-2">@include ('game.common.packageImage', ['imageUrl' => small_image_url($review->soft->getImagePackage())])</div>
                                    <div>
                                        <div class="d-flex">
                                            <div class="review-list-point mr-1">{{ \Hgs3\Constants\Review\Fear::$face[$review->fear] }}</div>
                                            <div class="review-list-point mr-2">{{ $review->calcPoint() }}</div>
                                            @if($review->is_spoiler == 1)
                                                <div>
                                                    <span class="badge badge-pill badge-danger">ネタバレ</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="mb-0 force-break one-line"><small>{{ $review->user->name }}さん</small></p>
                                            <p class="mb-0"><small>{{ format_date(strtotime($review->post_at)) }} 投稿</small></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="align-self-center">
                                    <a href="{{ route('レビュー', ['review' => $review->id]) }}" class="btn btn-outline-dark border-0 d-block">
                                        <button class="btn btn-light btn--icon"><i class="fas fa-angle-right"></i></button>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-xl-5">
                <div class="card card-hgn">
                    <div class="card-body">
                        <h5 class="card-title">レビュー書いてみませんか？</h5>
                        <p class="card-subtitle">レビューの少ないゲーム達です。点数だけでも付けてみませんか？</p>

                        @foreach ($wantToWrite as $soft)
                            <div class="d-flex justify-content-between mb-4">
                                <div class="package-card">
                                    <a href="{{ route('レビュー入力', ['soft' => $soft->id]) }}" class="align-self-center">
                                        <div style="display: table-row;">
                                            <div class="package-card-image">
                                                @include ('game.common.packageImage', ['imageUrl' => small_image_url($soft->package)])
                                            </div>
                                            <div class="package-card-name">
                                                <small>{{ $soft->name }}</small>
                                                @isset($favoriteSofts[$soft->id])
                                                    <span class="favorite-icon"><i class="fas fa-star"></i></span>
                                                @endisset
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="align-self-center">
                                    <a href="{{ route('レビュー入力', ['soft' => $soft->id]) }}" class="btn btn-outline-dark border-0 d-block">
                                        <button class="btn btn-light btn--icon"><i class="fas fa-pencil-alt"></i></button>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>



        <div class="row">
            <div class="col-12 col-md-6 col-xl-5">
                <div class="card card-hgn">
                    <div class="card-body">
                        <h5 class="card-title">怖いと評判のゲーム</h5>

                        @foreach ($fearRanking as $fear)
                            <div class="d-flex justify-content-between">
                                <div class="d-flex">
                                    <div class="align-self-center mr-2 nowrap">
                                        <p class="mb-2 text-center">{{ $loop->index + 1 }}位</p>
                                        <p class="mb-0" style="font-size: 1.2rem;">
                                            {{ \Hgs3\Constants\Review\Fear::$face[intval(round($fear->fear))] }}
                                            {{ round($fear->fear * \Hgs3\Constants\Review\Fear::POINT_RATE) }}
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-between align-self-center">
                                        <div class="package-card">
                                            <a href="{{ route('ソフト別レビュー一覧', ['soft' => $fear->soft_id]) }}" class="align-self-center">
                                                <div style="display: table-row;">
                                                    <div class="package-card-image">
                                                        @include ('game.common.packageImage', ['imageUrl' => small_image_url($fear)])
                                                    </div>
                                                    <div class="package-card-name"><small>{{ $fear->name }}</small></div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="align-self-center">
                                    <a href="{{ route('ソフト別レビュー一覧', ['soft' => $fear->soft_id]) }}" class="btn btn-outline-dark border-0 d-block">
                                        <button class="btn btn-light btn--icon"><i class="fas fa-angle-right"></i></button>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-xl-5">
                <div class="card card-hgn">
                    <div class="card-body">
                        <h5 class="card-title">総合ポイントの高いゲーム</h5>
                        @foreach ($pointRanking as $point)
                            <div class="d-flex justify-content-between">
                                <div class="d-flex">
                                    <div class="align-self-center mr-2 nowrap">
                                        <p class="mb-2 text-center">{{ $loop->index + 1 }}位</p>
                                        <p class="mb-0" style="font-size: 1.2rem;">
                                            {{ sprintf('%.1f', $point->point) }}pt
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-between align-self-center">
                                        <div class="package-card">
                                            <a href="{{ route('ソフト別レビュー一覧', ['soft' => $point->soft_id]) }}" class="align-self-center">
                                                <div style="display: table-row;">
                                                    <div class="package-card-image">
                                                        @include ('game.common.packageImage', ['imageUrl' => small_image_url($point)])
                                                    </div>
                                                    <div class="package-card-name"><small>{{ $point->name }}</small></div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="align-self-center">
                                    <a href="{{ route('ソフト別レビュー一覧', ['soft' => $point->soft_id]) }}" class="btn btn-outline-dark border-0 d-block">
                                        <button class="btn btn-light btn--icon"><i class="fas fa-angle-right"></i></button>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item active" aria-current="page">レビュー</li>
        </ol>
    </nav>
@endsection
