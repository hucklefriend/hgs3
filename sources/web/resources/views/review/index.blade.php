@extends('layouts.app')

@section('title')レビュー@endsection
@section('global_back_link'){{ route('トップ') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>レビュー</h1>
        </header>

        <div class="row">
            <div class="col-12 col-md-5">
                <div class="card card-hgn">
                    <div class="card-body">
                        <h4 class="card-title">新着レビュー</h4>
                    </div>
                    <div class="listview listview--hover">
                    @foreach ($newArrivals as $review)
                        <a class="listview__item" href="{{ route('レビュー', ['review' => $review->id]) }}">
                            <div>
                            @if($review->is_spoiler == 1)
                                <div class="mb-1">
                                    <span class="badge badge-pill badge-danger">ネタバレあり！</span><br>
                                </div>
                            @endif
                            <div>{{ \Hgs3\Constants\Review\Fear::$face[$review->fear] }} {{ $review->soft->name }}</div>
                            <div class="d-flex">
                                <div class="package-image-review-list mr-1">@include ('game.common.packageImage', ['imageUrl' => small_image_url($review->soft->getImagePackage())])</div>
                                <div class="review-point-list mr-2">{{ $review->calcPoint() }}</div>
                                <div>
                                    <p class="mb-1">{{ $review->user->name }}さん</p>
                                    <p class="mb-1">{{ format_date(strtotime($review->post_at)) }}</p>
                                </div>
                            </div>
                            </div>
                        </a>
                    @endforeach
                    </div>
                    <div class="card-body">
                        <div class="text-right">
                            <a href="{{ route('お知らせ') }}" class="badge badge-pill and-more">すべて見る <i class="fas fa-angle-right"></i></a>
                        </div>
                    </div>
                </div>
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
