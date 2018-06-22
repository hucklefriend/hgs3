@extends('layouts.app')

@section('title'){{ $soft->name }}のレビュー@endsection
@section('global_back_link'){{ \Hgs3\Http\GlobalBack::reviewBySoft($soft) }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>{{ $soft->name }}</h1>
            <p class="mb-0">レビュー</p>
        </header>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-5">
                <div class="card card-hgn">
                    <div class="card-body">
                        @if ($total !== null)
                            <div class="review-list-fear">
                                {{ \Hgs3\Constants\Review\Fear::$data[intval(round($total->fear))] }}
                            </div>
                            <div class="d-flex">
                                <div class="review-point review-point-acronym">
                                    {{ \Hgs3\Constants\Review\Fear::$face[$total->fear] }}<br>
                                    {{ \Hgs3\Constants\Review\Fear::$acronym[$total->fear] }}<br>
                                </div>
                                <div class="review-point review-point-point">
                                    {{ round($total->point) }}pt
                                </div>

                                <table class="review-point-table">
                                    <tr>
                                        <th>😱 怖さ</th>
                                        <td class="text-right">{{ round($total->fear * \Hgs3\Constants\Review\Fear::POINT_RATE) }}pt</td>
                                    </tr>
                                    <tr>
                                        <th><i class="far fa-thumbs-up"></i> 良い点</th>
                                        <td class="text-right">{{ round(($total->good_tag_num + $total->very_good_tag_num) * \Hgs3\Constants\Review\Tag::POINT_RATE)}}pt</td>
                                    </tr>
                                    <tr>
                                        <th><i class="far fa-thumbs-down"></i> 悪い所</th>
                                        <td class="text-right">-{{ round(($total->bad_tag_num + $total->very_bad_tag_num) * \Hgs3\Constants\Review\Tag::POINT_RATE) }}pt</td>
                                    </tr>
                                </table>
                            </div>

                            <p class="text-muted">
                                <small>
                                    怖さを基準点に、良い点を足し、悪い点を引いて計算しています。<br>
                                    詳しくは<a href="{{ route('レビューについて') }}">レビューについて</a>をご確認ください。
                                </small>
                            </p>
                        @else
                            <p class="mb-0">
                                集計されていないか、レビューが投稿されていません。<br>
                                一定時間毎に集計しておりますので、しばらくお待ちください。
                            </p>
                        @endif

                        @auth
                            <div class="mt-4">
                            @if ($writtenReview)
                                {{ Auth::user()->name }}さんレビュー投稿ありがとうございました。<br>
                                <a href="{{ route('レビュー', ['review' => $writtenReview->id]) }}">ご自身の投稿はこちら</a>です。
                            @elseif ($isWriteDraft)
                                こちらのゲームの下書きがあるようです。<br>
                                <a href="{{ route('レビュー入力', ['soft' => $soft->id]) }}" class="and-more">
                                    <i class="fas fa-edit"></i> 下書きの続きを書く
                                </a>
                            @else
                                {{ Auth::user()->name }}さんもレビューを書いてみませんか？<br>
                                <a href="{{ route('レビュー入力', ['soft' => $soft->id]) }}" class="and-more">
                                    <i class="fas fa-edit"></i> レビューを書く
                                </a>
                            @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-7">
                <div class="row quick-stats">
                    <div class="col-6">
                        <div class="quick-stats__item">
                            <div class="quick-stats__info">
                                @if($fearRanking)
                                    <h2>{{ $fearRanking->rank }}位</h2>
                                @else
                                    <h2>-位</h2>
                                @endif
                                <small>怖さの評判</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="quick-stats__item">
                            <div class="quick-stats__info">
                                @if($pointRanking)
                                    <h2>{{ $pointRanking->rank }}位</h2>
                                @else
                                    <h2>-位</h2>
                                @endif
                                <small>ゲームの評判</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-hgn">
            <div class="card-body">
                <h4 class="card-title">みんなのレビュー</h4>
                <div class="row">
                    @foreach ($reviews as $review)
                        @include('review.common.noSoftCard', ['review' => $review])
                    @endforeach
                </div>
                @include('common.pager', ['pager' => $reviews])
            </div>
        </div>
    </div>
@endsection
