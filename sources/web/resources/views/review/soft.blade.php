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
                            <div class="d-flex">
                                <div class="review-point mr-2">
                                    {{ \Hgs3\Constants\Review\Fear::$face[intval(round($total->fear))] }}
                                </div>
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
                        ここにはランキング関係の情報を出す
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-sm-9 col-md-9 col-lg-8 col-xl-7">
                <div class="card card-hgn">
                    <div class="card-body">
                        <h4 class="card-title">みんなのレビュー</h4>

                        @foreach ($reviews as $review)
                            <div class="mb-5">
                                @if($review->is_spoiler == 1)
                                    <span class="badge badge-sm badge-danger">ネタバレあり！</span>
                                @endif
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <div class="my-1" style="font-size: 1.3rem;">{{ \Hgs3\Constants\Review\Fear::$data[$review->fear] }}</div>
                                        <div class="d-flex">
                                            <div class="review-list-point mr-2">{{ $review->calcPoint() }}</div>
                                            <div>
                                                <p class="mb-0"><small><i class="far fa-user"></i> {{ $users[$review->user_id]->name }}</small></p>
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

                        @include('common.pager', ['pager' => $reviews])

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
