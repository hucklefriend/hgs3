@extends('layouts.app')

@section('title')ゲーム@endsection
@section('global_back_link'){{ route('ゲーム一覧') }}@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card card-hgn">
                <div class="card-body">
                    <h1 class="card-title">{{ $soft->name }}</h1>
                    <div class="d-flex flex-column flex-sm-row">
                        @if ($hasOriginalPackageImage)
                            <div class="text-center mb-3">
                                @include('game.common.packageImage', ['imageUrl' => medium_image_url($originalPackage)])
                            </div>
                        @endif
                        <div class="ml-2">
                            @if (!empty($soft->introduction))
                            <div>
                                <blockquote class="blockquote soft-blockquote">
                                    <p class="mb-0">{!! nl2br(e($soft->introduction)) !!}</p>
                                    @if (!empty($soft->introduction_from))
                                    <div class="text-right mt-2">
                                        <footer class="blockquote-footer">{!! $soft->introduction_from !!}</footer>
                                    </div>
                                    @endif
                                </blockquote>
                            </div>
                            @endif
                            @if (!empty($platforms))
                            <div class="d-flex mb-2">
                                <div style="width: 30px;" class="text-center">
                                    <i class="fas fa-gamepad"></i>
                                </div>
                                <div class="d-flex flex-wrap">
                                @foreach ($platforms as $plt)
                                    <a href="#" class="mr-2 badge badge-light">{{ $pltHash[$plt] ?? '？' }}</a>
                                @endforeach
                                </div>
                            </div>
                            @endif
                            @if ($officialSites->isNotEmpty())
                            <div class="d-flex">
                                <div style="width: 30px;" class="text-center">
                                    <i class="fas fa-info-circle"></i>
                                </div>
                                <div class="d-flex flex-wrap">
                                @foreach ($officialSites as $officialSite)
                                    <a href="{{ $officialSite->url }}" target="_blank" class="ml-2"><small>{{ $officialSite->title }}</small></a>
                                @endforeach
                                </div>
                            </div>
                            @endif

                            @if (Auth::check())
                            <div class="mt-4">
                                @if ($isFavorite)
                                    <form action="{{ route('お気に入りゲーム削除処理') }}" method="POST" onsubmit="return confirm('お気に入り解除していいですか？');">
                                        {{ csrf_field() }}
                                        <input type="hidden" value="{{ $soft->id }}" name="soft_id">
                                        {{ method_field('DELETE') }}
                                        <button class="btn btn-favorite2 btn--icon"><i class="fas fa-star"></i></button>
                                    </form>
                                @else
                                    <form action="{{ route('お気に入りゲーム登録処理') }}" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" value="{{ $soft->id }}" name="soft_id">
                                        <button class="btn btn-favorite btn--icon"><i class="far fa-star"></i></button>
                                    </form>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card card-hgn">
                <div class="card-body">
                    <h4 class="card-title">パッケージ情報</h4>

                    @if ($packageNum > 2)
                        <script>
                            let swiper = null;
                            $(function(){
                                swiper = new Swiper('#packages_list', {
                                    pagination: {
                                        el: '#packages_pagination',
                                        type: 'fraction',
                                    },
                                    navigation: {
                                        nextEl: '#packages_next',
                                        prevEl: '#packages_prev',
                                    },
                                    loop: true,
                                });
                            });
                        </script>
                    @endif

                    <div class="package_slide swiper-container" id="packages_list">
                        <div class="swiper-wrapper">
                        @for ($i = 0; $i < $packageNum; $i += 2)
                            <div class="swiper-slide">
                                @php $pkg = $packages[$i]; @endphp
                                <div class="d-flex">
                                    <div class="package-image-small text-center">
                                        @include('game.common.packageImage', ['imageUrl' => small_image_url($pkg)])
                                    </div>
                                    <div class="ml-3">
                                        <div class="package-title">{{ $pkg->name }}</div>
                                        <div class="package-info mt-1">
                                            <div><span class="package-info-icon"><i class="far fa-building"></i></span>&nbsp;<a href="{{ route('ゲーム会社詳細', ['company' => $pkg->company_id]) }}">{{ $pkg->company_name }}</a></div>
                                            <div><span class="package-info-icon"><i class="fas fa-gamepad"></i></span>&nbsp;<a href="{{ route('プラットフォーム詳細', ['platform' => $pkg->platform_id]) }}">{{ $pkg->platform_name }}</a></div>
                                            <div><span class="package-info-icon"><i class="far fa-calendar-alt"></i></span> {{ $pkg->release_at }}</div>
                                        </div>
                                    </div>
                                </div>
                                @if (!empty($pkg->shops))
                                <div class="mt-3">
                                    <div class="shopping d-flex">
                                        <i class="fas fa-shopping-cart mr-2 align-self-center"></i>
                                        <div class="d-flex flex-wrap">
                                        @foreach ($pkg->shops as $shop)
                                            @include('game.common.shop', ['shopId' => $shop->shop_id, 'shopUrl' => $shop->shop_url])
                                        @endforeach
                                        </div>
                                    </div>
                                </div>
                                @endif


                                @if (isset($packages[$i + 1]))
                                    @php $pkg = $packages[$i + 1]; @endphp
                                    <hr>
                                    <div class="d-flex mt-4">
                                        <div class="package-image-small">
                                            @include('game.common.packageImage', ['imageUrl' => small_image_url($pkg)])
                                        </div>
                                        <div class="ml-3">
                                            <div class="package-title">{{ $pkg->name }}</div>
                                            <div class="package-info mt-1">
                                                <div><span class="package-info-icon"><i class="far fa-building"></i></span>&nbsp;<a href="{{ route('ゲーム会社詳細', ['company' => $pkg->company_id]) }}">{{ $pkg->company_name }}</a></div>
                                                <div><span class="package-info-icon"><i class="fas fa-gamepad"></i></span>&nbsp;<a href="{{ route('プラットフォーム詳細', ['platform' => $pkg->platform_id]) }}">{{ $pkg->platform_name }}</a></div>
                                                <div><span class="package-info-icon"><i class="far fa-calendar-alt"></i></span> {{ $pkg->release_at }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    @if (!empty($pkg->shops))
                                    <div class="mt-3">
                                        <div class="shopping d-flex">
                                            <i class="fas fa-shopping-cart mr-2 align-self-center"></i>
                                            <div class="d-flex flex-wrap">
                                                @foreach ($pkg->shops as $shop)
                                                    @include('game.common.shop', ['shopId' => $shop->shop_id, 'shopUrl' => $shop->shop_url])
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                @endif
                            </div>
                        @endfor
                        </div>
                    </div>
                    @if ($packageNum > 2)
                        <div class="text-center mt-3">
                            <button class="btn btn-light btn--icon" id="packages_prev"><i class="fas fa-caret-left"></i></button>
                            <span id="packages_pagination" class="mx-5"></span>
                            <button class="btn btn-light btn--icon" id="packages_next"><i class="fas fa-caret-right"></i></button>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card card-hgn">
                <div class="card-body">
                    <h4 class="card-title">レビュー <small>{{ number_format($reviewTotal ? $reviewTotal->review_num : 0) }}件</small></h4>
                    @empty($reviewTotal)
                        @auth
                            <p class="card-text">
                                レビューはないか、集計待ち状態です。<br>
                                このゲームのレビューを書いてみませんか？<br>
                                <a href="{{ route('レビュー入力', ['soft' => $soft->id]) }}" class="badge badge-pill and-more">
                                    <i class="fas fa-edit"></i> レビューを書く
                                </a>
                            </p>
                        @else
                            <p class="card-text">レビューはありません。</p>
                        @endauth
                    @else
                        <div class="d-flex mb-3">
                            <div class="review-point">
                                {{ round($reviewTotal->point, 1) }}
                            </div>

                            <table class="review-point-table">
                                <tr>
                                    <th>😱 怖さ</th>
                                    <td class="text-right">{{ round($reviewTotal->fear * 5, 1) }}点</td>
                                </tr>
                                <tr>
                                    <th><i class="far fa-thumbs-up"></i> 良い所</th>
                                    <td class="text-right">{{ round($reviewTotal->good_tag_num, 1)}}点</td>
                                </tr>
                                <tr>
                                    <th><i class="far fa-thumbs-up"></i><i class="far fa-thumbs-up"></i> すごく良い所</th>
                                    <td class="text-right">{{ round($reviewTotal->very_good_tag_num, 1) }}点</td>
                                </tr>
                                <tr>
                                    <th><i class="far fa-thumbs-down"></i> 悪い所</th>
                                    <td class="text-right">-{{ round($reviewTotal->bad_tag_num, 1) }}点</td>
                                </tr>
                                <tr>
                                    <th><i class="far fa-thumbs-down"></i><i class="far fa-thumbs-down"></i> すごく悪い所</th>
                                    <td class="text-right">-{{ round($reviewTotal->very_bad_tag_num, 1) }}点</td>
                                </tr>
                            </table>
                        </div>
                        <div class="text-right">
                            <a href="{{ route('ソフト別レビュー一覧', ['soft' => $soft->id]) }}" class="badge badge-pill and-more">すべて見る <i class="fas fa-angle-right"></i></a>
                        </div>

                    @endempty
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card card-hgn">
                <div class="card-body">
                    <h4 class="card-title">サイト <small>{{ number_format($siteNum) }}サイト</small></h4>

                    <div class="card-text">
                        @if (empty($site))
                            <p>サイトは登録されていません。</p>
                        @else
                            @foreach ($site as $s)
                                <div style="margin-bottom: 20px;">
                                @include('site.common.minimal', ['s' => $s])
                                </div>
                            @endforeach
                            <div class="text-right">
                                <a href="{{ route('ソフト別サイト一覧', ['soft' => $soft->id]) }}" class="badge badge-pill and-more">すべて見る <i class="fas fa-angle-right"></i></a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-hgn">
                <div class="card-body">
                    <h4 class="card-title">お気に入り <small>{{ number_format($favoriteNum) }}人</small></h4>
                    <div class="card-text">
                        @if ($favoriteNum == 0)
                            お気に入りに登録しているユーザーはいません。
                        @else
                            @foreach ($favorites as $favorite)
                                <div class="mb-3">
                                    @include('user.common.icon', ['u' => $users[$favorite->user_id]])
                                    @include('user.common.user_name', ['u' => $users[$favorite->user_id], 'followStatus' => $followStatus[$favorite->user_id] ?? \Hgs3\Constants\FollowStatus::NONE])
                                </div>
                            @endforeach
                            <div class="text-right">
                                <a href="{{ route('お気に入りゲーム登録ユーザー一覧', ['soft' => $soft->id]) }}" class="badge badge-pill and-more">すべて見る <i class="fas fa-angle-right"></i></a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($series)
    <div class="card card-hgn">
        <div class="card-body">
            <h5 class="card-title">同じシリーズのゲーム</h5>
            <div class="package-list">
                @foreach ($seriesSofts as $seriesSoft)
                    @include('game.common.packageCard', ['soft' => $seriesSoft, 'favorites' => $favoriteHash])
                @endforeach
            </div>
        </div>
    </div>
    @endif


    <div class="d-flex justify-content-between">
        <a href="{{ route('ゲーム詳細', ['soft' => $prevGame->id]) }}" class="badge badge-pill and-more">
            <i class="fas fa-angle-left"></i>
            前のゲーム
        </a>
        <a href="{{ route('ゲーム詳細', ['soft' => $nextGame->id]) }}" class="badge badge-pill and-more">
            次のゲーム
            <i class="fas fa-angle-right"></i>
        </a>
    </div>

@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('ゲーム一覧') }}">ゲーム一覧</a></li>
            <li class="breadcrumb-item active" aria-current="page">詳細</li>
        </ol>
    </nav>
@endsection