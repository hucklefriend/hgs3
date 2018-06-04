@extends('layouts.app')

@section('title')レビュー@endsection
@section('global_back_link'){{ route('トップ') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>レビュー</h1>
        </header>

        <div class="card card-hgn">
            <div class="card-body">
                <div class="d-flex justify-content-between card-title-flex">
                    <h5 class="card-title">新着レビュー</h5>

                    <div class="card-title-link">
                        <a href="{{ route('お知らせ') }}" class="badge badge-pill show-all"><small>すべて見る</small> <i class="fas fa-angle-right"></i></a>
                    </div>
                </div>
                <div class="row">
                    @foreach ($newArrivals as $review)
                        <div class="col-12 col-sm-6 col-lg-4 mb-5 pr-5">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <div class="review-list-title"><a href="{{ route('レビュー', ['review' => $review->id]) }}">{{ $review->soft->name }}</a></div>
                                    <div class="d-flex">
                                        <div class="review-list-package-image mr-2">@include ('game.common.packageImage', ['imageUrl' => small_image_url($review->soft->getImagePackage())])</div>
                                        <div>
                                            <div class="d-flex">
                                                <div class="review-list-point mr-1">{{ \Hgs3\Constants\Review\Fear::$face[$review->fear] }}</div>
                                                <div class="review-list-point mr-2">-{{ $review->calcPoint() }}</div>
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
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-7 col-lg-6 col-xl-5">
            </div>
        </div>
        <div class="card card-hgn">
            <div class="card-body">
                <p>レビュー書いてみませんか？</p>
            </div>
        </div>

        <div class="card card-hgn">
            <div class="card-body">
                <h4 class="card-title">総合評価の高いゲーム</h4>
                <p>工事中</p>
            </div>
        </div>

        <div class="card card-hgn">
            <div class="card-body">
                <h4 class="card-title">怖いと評判のゲーム</h4>
                <p>工事中</p>
            </div>
        </div>

        <div class="card card-hgn">
            <div class="card-body">
                <h4 class="card-title">総合評価の低いゲーム</h4>
                <p>工事中</p>
            </div>
        </div>

        <div class="card card-hgn">
            <div class="card-body">
                <h4 class="card-title">ゲーム</h4>
                <p>工事中</p>
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
