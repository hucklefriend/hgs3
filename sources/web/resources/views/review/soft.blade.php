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
            <div class="col-12 col-sm-7 col-md-6 col-lg-5">
                <div class="card card-hgn">
            <div class="card-body">
                <h4 class="card-title">平均点</h4>
                @if ($total !== null)
                    <div class="d-flex">
                        <div class="review-point">
                            {{ round($total->point, 1) }}
                        </div>

                        <table class="review-point-table">
                            <tr>
                                <th>😱 怖さ</th>
                                <td class="text-right">{{ round($total->fear * 5, 1) }}点</td>
                            </tr>
                            <tr>
                                <th><i class="far fa-thumbs-up"></i> 良い所</th>
                                <td class="text-right">{{ round($total->good_tag_num, 1)}}点</td>
                            </tr>
                            <tr>
                                <th><i class="far fa-thumbs-up"></i><i class="far fa-thumbs-up"></i> すごく良い所</th>
                                <td class="text-right">{{ round($total->very_good_tag_num, 1) }}点</td>
                            </tr>
                            <tr>
                                <th><i class="far fa-thumbs-down"></i> 悪い所</th>
                                <td class="text-right">-{{ round($total->bad_tag_num, 1) }}点</td>
                            </tr>
                            <tr>
                                <th><i class="far fa-thumbs-down"></i><i class="far fa-thumbs-down"></i> すごく悪い所</th>
                                <td class="text-right">-{{ round($total->very_bad_tag_num, 1) }}点</td>
                            </tr>
                        </table>
                    </div>
                @else
                    <p class="mb-0">集計されていません。</p>
                @endif
            </div>
        </div>
            </div>

            <div class="col-12 col-sm-12 col-md-6 col-lg-7">
                <div class="card card-hgn">
                    <div class="card-body">広告</div>
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
                                <div class="d-flex flex-wrap">
                                    <span class="mr-2 badge and-more">😱 {{ $review->fear * 5 }}</span>
                                    <span class="mr-2 badge and-more">良 {{ $review->good_tag_num }}</span>
                                    <span class="mr-2 badge and-more">特良 {{ $review->very_good_tag_num }}</span>
                                    <span class="mr-2 badge and-more">悪 {{ $review->bad_tag_num }}</span>
                                    <span class="mr-2 badge and-more">特悪 {{ $review->very_bad_tag_num }}</span>
                                </div>
                                <div>
                                    <span><i class="far fa-user"></i> {{ $users[$review->user_id]->name }}</span><br>
                                    <span><i class="far fa-calendar-alt"></i> {{ format_date(strtotime($review->post_at)) }}</span><br>
                                    <span>🤔 {{ $review->good_num }}</span>
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