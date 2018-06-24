@extends('layouts.app')

@section('title'){{ $soft->name }}@endsection
@section('global_back_link'){{ \Hgs3\Http\GlobalBack::softDetail($soft) }}@endsection

@section('content')
<div class="content__inner">
    <header class="content__title">
        <h1>{{ $soft->name }}</h1>
    </header>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-hgn">
                <div class="card-body">
                    <div class="d-flex flex-column flex-sm-row">
                        @if ($hasOriginalPackageImage)
                            <div class="text-center mb-3">
                                @include('game.common.packageImage', ['imageUrl' => medium_image_url($originalPackage)])
                            </div>
                        @endif
                        <div class="ml-2">
                            @if (!empty($soft->introduction))
                                <div>
                                    <blockquote class="blockquote soft-blockquote d-inline-block">
                                        <p class="mb-0">{!! nl2br(e($soft->introduction)) !!}</p>
                                        @if (!empty($soft->introduction_from))
                                        <div class="text-right mt-2">
                                            <footer class="blockquote-footer">{!! $soft->introduction_from !!}</footer>
                                        </div>
                                        @endif
                                    </blockquote>
                                </div>
                            @endif

                            @if ($officialSites->isNotEmpty())
                            <div class="d-flex">
                                <div style="width: 30px;" class="text-center">
                                    <i class="fas fa-info-circle"></i>
                                </div>
                                <div class="d-flex flex-wrap" style="min-width: 0;">
                                @foreach ($officialSites as $officialSite)
                                    <a href="{{ $officialSite->url }}" target="_blank" class="badge-official-site"><small>{!! $officialSite->title !!}</small> <i class="fas fa-sign-out-alt"></i></a>
                                @endforeach
                                    @if ($officialSites->count() > 3)
                                        <button class="btn btn-sm btn-light" id="official-open"><small><i class="fas fa-chevron-right"></i></small></button>
                                        <button class="btn btn-sm btn-light" style="display:none;" id="official-close"><small><i class="fas fa-chevron-left"></i></small></button>

                                        <script>
                                            $(function () {
                                                $('.badge-official-site:nth-child(n + 4)').hide();
                                                $('#official-open').click(function (){
                                                    $(this).hide();
                                                    $('#official-close').show();
                                                    $('.badge-official-site:nth-child(n + 4)').show();
                                                });
                                                $('#official-close').click(function (){
                                                    $(this).hide();
                                                    $('#official-open').show();
                                                    $('.badge-official-site:nth-child(n + 4)').hide();
                                                });
                                            });
                                        </script>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @if (Auth::check())
                        <div class="mt-2">
                            @if ($isFavorite)
                                <form action="{{ route('お気に入りゲーム削除処理') }}" method="POST" onsubmit="return confirm('お気に入り解除していいですか？');">
                                    {{ csrf_field() }}
                                    <input type="hidden" value="{{ $soft->id }}" name="soft_id">
                                    {{ method_field('DELETE') }}
                                    <button class="btn btn-favorite2"><i class="fas fa-star"></i>取り消し</button>
                                </form>
                            @else
                                <form action="{{ route('お気に入りゲーム登録処理') }}" method="POST">
                                    {{ csrf_field() }}
                                    <input type="hidden" value="{{ $soft->id }}" name="soft_id">
                                    <button class="btn btn-favorite"><i class="far fa-star"></i>登録</button>
                                </form>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
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
                            <div class="swiper-slide soft-detail-package">
                                @php $pkg = $packages[$i]; @endphp
                                <div class="d-table-row">
                                    <div class="package-image">
                                        {!! small_image($pkg) !!}
                                    </div>
                                    <div class="package-data">
                                        <div class="package-title">@if(env('APP_ENV') == 'local') ({{ $pkg->id }}) @endif{{ $pkg->name }}</div>
                                        <div class="package-info mt-1">
                                            <div><span class="package-info-icon"><i class="far fa-building"></i></span>&nbsp;<a href="{{ route('ゲーム会社詳細', ['company' => $pkg->company_id]) }}">{{ $pkg->company_name }}</a></div>
                                            <div><span class="package-info-icon"><i class="fas fa-gamepad"></i></span>&nbsp;<a href="{{ route('プラットフォーム詳細', ['platform' => $pkg->platform_id]) }}">{{ $pkg->platform_name }}</a></div>
                                            <div><span class="package-info-icon"><i class="far fa-calendar-alt"></i></span> {{ $pkg->release_at }}</div>
                                        </div>
                                    </div>
                                </div>
                                @if (!empty($pkg->shops) && ($pkg->is_adult == 0 || ($pkg->is_adult != 0 && Auth::check() && Auth::user()->isAdult())))
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
                                    <div class="d-table-row">
                                        <div class="package-image">
                                            {!! small_image($pkg) !!}
                                        </div>
                                        <div class="package-data">
                                            <div class="package-title">@if(env('APP_ENV') == 'local') ({{ $pkg->id }}) @endif{{ $pkg->name }}</div>
                                            <div class="package-info mt-1">
                                                <div><span class="package-info-icon"><i class="far fa-building"></i></span>&nbsp;<a href="{{ route('ゲーム会社詳細', ['company' => $pkg->company_id]) }}">{{ $pkg->company_name }}</a></div>
                                                <div><span class="package-info-icon"><i class="fas fa-gamepad"></i></span>&nbsp;<a href="{{ route('プラットフォーム詳細', ['platform' => $pkg->platform_id]) }}">{{ $pkg->platform_name }}</a></div>
                                                <div><span class="package-info-icon"><i class="far fa-calendar-alt"></i></span> {{ $pkg->release_at }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    @if (!empty($pkg->shops) && ($pkg->is_adult == 0 || ($pkg->is_adult != 0 && Auth::check() && Auth::user()->isAdult())))
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
                            <button class="btn btn-light" id="packages_prev"><i class="fas fa-caret-left"></i></button>
                            <span id="packages_pagination" class="mx-4"></span>
                            <button class="btn btn-light" id="packages_next"><i class="fas fa-caret-right"></i></button>
                        </div>
                    @endif
                </div>
            </div>
            <div class="card card-hgn">
                <div class="card-body">
                    <h4 class="card-title">お気に入り <small>{{ number_format($favoriteNum) }}人</small></h4>
                    <div class="card-text">
                        @if ($favoriteNum == 0 || empty($favorites))
                            @if ($favoriteNum == 0)
                            <p>お気に入りに登録しているユーザーはいません。</p>
                            @else
                            <p>プロフィールを公開しているユーザーはいません。</p>
                            @endif
                        @else
                            <div class="widget-signups__list text-left">
                                @foreach ($favorites as $favorite)
                                    @php $user = $users[$favorite->user_id]; @endphp
                                    @if ($user->icon_upload_flag == 1)
                                        <a data-toggle="tooltip" title="{{ $user->name }}" href="{{ route('プロフィール', ['showId' => $user->show_id]) }}">
                                            <img class="avatar-img" data-normal="{{ url('img/user_icon/' . $user->icon_file_name) }}" alt="">
                                        </a>
                                    @else
                                        <a data-toggle="tooltip" title="{{ $user->name }}" href="{{ route('プロフィール', ['showId' => $user->show_id]) }}">
                                            <div class="avatar-char">{{ mb_substr($user->name, 0, 1) }}</div>
                                        </a>
                                    @endif
                                @endforeach
                            </div>

                        <div class="d-flex justify-content-between flex-wrap mt-4">
                            <div class="text-right">
                                <a href="{{ route('お気に入りゲーム登録ユーザー一覧', ['soft' => $soft->id]) }}" class="and-more">すべて見る <i class="fas fa-angle-right"></i></a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="card card-hgn soft-detail-review">
                <div class="card-body">
                    <h4 class="card-title">レビュー <small>{{ number_format($reviewTotal ? $reviewTotal->review_num : 0) }}件</small></h4>
                    @if (!$released)
                        <p class="card-text">
                            発売されてないゲームなので、レビューは投稿できません。<br>
                            発売日までお待ちください。
                        </p>
                    @else
                    @empty($reviewTotal)
                        @auth
                            <p class="card-text">
                                レビューはないか、集計待ち状態です。<br>
                                このゲームのレビューを書いてみませんか？<br>
                                @if ($isWriteReviewDraft)
                                    <a href="{{ route('レビュー入力', ['soft' => $soft->id]) }}" class="and-more mt-2">
                                        <i class="fas fa-edit"></i> 下書きの続きを書く
                                    </a>
                                @else
                                    <a href="{{ route('レビュー入力', ['soft' => $soft->id]) }}" class="and-more mt-2">
                                        <i class="fas fa-edit"></i> レビューを書く
                                    </a>
                                @endif
                            </p>
                        @else
                            <p class="card-text">レビューはありません。</p>
                        @endauth
                    @else

                        <table class="review-total-table">
                            <tr class="title">
                                <td rowspan="5">
                                    <small>み<br>ん<br>な<br>の<br>評<br>価</small>
                                </td>
                            </tr>
                            <tr>
                                <th>{{ \Hgs3\Constants\Review\Fear::$face[intval(round($reviewTotal->fear, 0))] }}</th>
                                <td>{{ mb_substr(\Hgs3\Constants\Review\Fear::$data[intval(round($reviewTotal->fear, 0))], 1) }}</td>
                            </tr>
                            <tr>
                                <th>{{ round($reviewTotal->point, 0) }}pt</th>
                                <td>評価点の平均</td>
                            </tr>
                            <tr>
                                <th>{{ $reviewFearRank }}位</th>
                                <td>怖さの評判</td>
                            </tr>
                            <tr>
                                <th>{{ $reviewPointRank }}位</th>
                                <td>ゲームの評判</td>
                            </tr>
                        </table>

                        @auth
                            @if ($isWriteReview)
                                <div class="text-right mt-4">
                                    <a href="{{ route('ソフト別レビュー一覧', ['soft' => $soft->id]) }}" class="and-more">レビューを見る <i class="fas fa-angle-right"></i></a>
                                </div>
                            @else
                                <div class="d-flex justify-content-between mt-4 flex-wrap">
                                    @if ($isWriteReviewDraft)
                                    <a href="{{ route('レビュー入力', ['soft' => $soft->id]) }}" class="and-more">
                                        <i class="fas fa-edit"></i> 下書きの続きを書く
                                    </a>
                                    @else
                                    <a href="{{ route('レビュー入力', ['soft' => $soft->id]) }}" class="and-more">
                                        <i class="fas fa-edit"></i> レビューを書く
                                    </a>
                                    @endif
                                    <a href="{{ route('ソフト別レビュー一覧', ['soft' => $soft->id]) }}" class="and-more">レビューを見る <i class="fas fa-angle-right"></i></a>
                                </div>
                            @endif
                        @else
                        <div class="text-right mt-4">
                            <a href="{{ route('ソフト別レビュー一覧', ['soft' => $soft->id]) }}" class="and-more">レビューを見る <i class="fas fa-angle-right"></i></a>
                        </div>
                        @endauth
                    @endempty
                    @endif
                </div>
            </div>
            <div class="card card-hgn">
                <div class="card-body">
                    <h4 class="card-title">サイト <small>{{ number_format($siteNum) }}サイト</small></h4>

                    <div class="card-text">
                        @if (empty($site))
                            <p>サイトは登録されていません。</p>
                        @else
                            <div class="site-random-pickup">ランダムピックアップ！</div>
                            <div class="random-pickup">
                                @include('site.common.normal', ['s' => $site, 'noUser' => true])
                            </div>

                            <div class="text-right mt-3">
                                <a href="{{ route('ソフト別サイト一覧', ['soft' => $soft->id]) }}" class="and-more">すべて見る <i class="fas fa-angle-right"></i></a>
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
                <div class="row game-list">
                    @foreach ($seriesSofts as $seriesSoft)
                        @include('game.common.packageCard', ['soft' => $seriesSoft, 'favorites' => $favoriteHash])
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <div class="d-flex justify-content-between">
        <a href="{{ route('ゲーム詳細', ['soft' => $prevGame->id]) }}" class="and-more">
            <i class="fas fa-angle-left"></i>
            前のゲーム
        </a>
        <a href="{{ route('ゲーム詳細', ['soft' => $nextGame->id]) }}" class="and-more">
            次のゲーム
            <i class="fas fa-angle-right"></i>
        </a>
    </div>
</div>
@endsection
