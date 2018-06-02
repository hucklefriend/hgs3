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
                <h4 class="card-title">新着レビュー</h4>


                <div class="row">
                    @foreach ($newArrivals as $review)
                        <div class="col-12 col-md-6 col-lg-4">
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
