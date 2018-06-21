@extends('layouts.app')

@section('title')レビュー@endsection
@section('global_back_link'){{ \Hgs3\Http\GlobalBack::clearAndRoute('トップ') }}@endsection

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
                        @if ($newArrivals->isNotEmpty())
                            @foreach ($newArrivals as $review)
                                <div class="mb-5 review-list">
                                    <p class="mb-1 lead">{{ \Hgs3\Constants\Review\Fear::$data[$review->fear] }}</p>
                                    <table>
                                        <tr>
                                            <td>{{ small_image($review->soft->getImagePackage()) }}</td>
                                            <td>
                                                <p class="mb-2">{{ $review->soft->name }}</p>
                                                <p class="mb-0 one-line"><small><i class="fas fa-user"></i>&nbsp;{{ $review->user->name }}さん</small></p>
                                                <p class="mb-0"><small><i class="fas fa-calendar-alt"></i>&nbsp;{{ format_date(strtotime($review->post_at)) }}</small></p>
                                            </td>
                                            <td><a class="btn btn-light btn--icon" href="{{ route('レビュー', ['review' => $review->id]) }}"><i class="fas fa-angle-right"></i></a></td>
                                        </tr>
                                    </table>
                                </div>
                            @endforeach

                            <div class="mt-2 text-right">
                                <a href="{{ route('新着レビュー一覧') }}" class="and-more">もっと見る <i class="fas fa-angle-right"></i></a>
                            </div>
                        @else
                            <p class="mb-0">3ヶ月以内に投稿されたレビューはありません。</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-xl-5">
                <div class="card card-hgn">
                    <div class="card-body">
                        <h5 class="card-title">レビュー書いてみませんか？</h5>
                        <p class="card-subtitle mb-3">レビューの少ないゲーム達です。点数だけでも付けてみませんか？</p>

                        @foreach ($wantToWrite as $soft)
                        <div class="package-card mb-4">
                            <div>
                                <div>{{ small_image($soft->package) }}</div>
                                <div><small>{{ $soft->name }}</small></div>
                                <div><a href="{{ route('レビュー入力', ['soft' => $soft->id]) }}" class="btn btn-light btn--icon"><i class="fas fa-pencil-alt"></i></a></div>
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

                        @if (empty($fearRanking))
                            <p class="mb-0">レビューが投稿されていません。</p>
                        @else
                        @foreach ($fearRanking as $fear)
                            <div class="d-flex justify-content-between mb-4">
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
                                    <a href="{{ route('ソフト別レビュー一覧', ['soft' => $fear->soft_id]) }}" class="btn btn-light btn--icon"><i class="fas fa-angle-right"></i></a>
                                </div>
                            </div>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-xl-5">
                <div class="card card-hgn">
                    <div class="card-body">
                        <h5 class="card-title">総合ポイントの高いゲーム</h5>
                        @if (empty($fearRanking))
                            <p class="mb-0">レビューが投稿されていません。</p>
                        @else
                        @foreach ($pointRanking as $point)
                            <div class="d-flex justify-content-between mb-4">
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
                                    <a href="{{ route('ソフト別レビュー一覧', ['soft' => $point->soft_id]) }}" class="btn btn-light btn--icon"><i class="fas fa-angle-right"></i></a>
                                </div>
                            </div>
                        @endforeach
                        @endif
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
