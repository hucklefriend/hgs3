@extends('layouts.app')

@section('title'){{ $soft->name }}のレビュー@endsection
@section('global_back_link'){{ route('ゲーム詳細', ['soft' => $soft->id]) }}@endsection

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
                        <div class="d-flex">

                        @if ($total !== null)
                            <div class="d-flex">
                                <div class="review-point">
                                    {{ round($total->point, 1) }}
                                </div>

                                <table class="review-point-table">
                                    <tr>
                                        <th>😱 怖さ</th>
                                        <td class="text-right">{{ round($total->fear * \Hgs3\Constants\Review\Fear::POINT_RATE, 1) }}pt</td>
                                    </tr>
                                    <tr>
                                        <th><i class="far fa-thumbs-up"></i> 良い点</th>
                                        <td class="text-right">{{ round(($total->good_tag_num + $total->very_good_tag_num) * \Hgs3\Constants\Review\Tag::POINT_RATE, 1)}}pt</td>
                                    </tr>
                                    <tr>
                                        <th><i class="far fa-thumbs-down"></i> 悪い所</th>
                                        <td class="text-right">-{{ round(($total->bad_tag_num + $total->very_bad_tag_num) * \Hgs3\Constants\Review\Tag::POINT_RATE, 1) }}pt</td>
                                    </tr>
                                </table>
                            </div>
                        @else
                            <p class="mb-0">集計されていません。</p>
                        @endif
                        </div>

                        <p class="text-muted">
                            <small>
                                怖さを基準点に、良い所を足し、悪い所を引いて計算しています。<br>
                                詳しくは<a href="{{ route('レビューについて') }}">レビューについて</a>をご確認ください。
                            </small>
                        </p>

                        @auth
                            <div class="mt-3">
                            @if ($writtenReview)
                                {{ Auth::user()->name }}さんレビュー投稿ありがとうございました。<br>
                                <a href="{{ route('レビュー', ['review' => $writtenReview->id]) }}">ご自身の投稿はこちら</a>です。
                            @elseif ($isWriteDraft)
                                こちらのゲームの下書きがあるようです。<br>
                                <a href="{{ route('レビュー入力', ['soft' => $soft->id]) }}" class="badge badge-pill and-more">
                                    <i class="fas fa-edit"></i> 下書きの続きを書く
                                </a>
                            @else
                                {{ Auth::user()->name }}さんもレビューを書いてみませんか？<br>
                                <a href="{{ route('レビュー入力', ['soft' => $soft->id]) }}" class="badge badge-pill and-more">
                                    <i class="fas fa-edit"></i> レビューを書く
                                </a>
                            @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-7">
                <div class="card card-hgn">
                    <div class="card-body">
                        @auth
                        <p>

                        </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-hgn">
            <div class="card-body">
                <h4 class="card-title">みんなのレビュー</h4>

                @foreach ($reviews as $review)
                    <div class="mb-5 d-flex justify-content-between">
                        <div class="d-flex">
                            <span class="review-point-list">{{ $review->point }}</span>
                            <div class="ml-3">
                                <div>
                                    {{ \Hgs3\Constants\Review\Fear::$face[$review->fear] }}{{ $review->fear * \Hgs3\Constants\Review\Fear::POINT_RATE }} +
                                    <i class="far fa-thumbs-up"></i>{{ ($review->good_tag_num + $review->very_good_tag_num) * \Hgs3\Constants\Review\Tag::POINT_RATE }} -
                                    <i class="far fa-thumbs-down"></i>{{ ($review->bad_tag_num + $review->very_bad_tag_num) * \Hgs3\Constants\Review\Tag::POINT_RATE }}
                                </div>
                                <div class="d-flex flex-wrap">
                                    <span class="mr-3"><i class="far fa-user"></i> {{ $users[$review->user_id]->name }}</span>
                                    <span class="mr-3"><i class="far fa-calendar-alt"></i> {{ format_date(strtotime($review->post_at)) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="align-self-center ml-5">
                            <a href="{{ route('レビュー', ['review' => $review->id]) }}" class="btn btn-light btn--icon"><i class="fas fa-angle-right"></i></a>
                        </div>
                    </div>
                @endforeach

                @include('common.pager', ['pager' => $reviews])
            </div>
        </div>
    </div>
@endsection
