@extends('layouts.app')

@section('content')
    <section>
        <div class="d-flex align-items-stretch">
            <div class="p-2 text-center">
                @include('game.common.package_image', ['imageUrl' => $pkg->small_image_url])
            </div>
            <div class="p-12">
                <h4>{{ $pkg->name }}</h4>
                <a href="{{ url2('game/soft') }}/{{ $game->id }}">ゲームの詳細</a> |
                <a href="{{ url('review/game') }}/{{ $game->id }}">レビュー一覧</a>
            </div>
        </div>
    </section>

    <section>
        <div class="d-flex align-items-stretch">
            <div class="p-2 align-self-center">
                <div class="review_point_outline">
                    <p class="review_point">{{ $review->point }}</p>
                </div>
            </div>
            <div class="p-12 align-self-center">
                @if($review->is_spoiler == 1) <span class="badge badge-pill badge-danger">ネタバレあり！</span> @endif
                <div class="break_word" style="width: 100%;"><h5>{{ $review->title }}</h5></div>
                <div>
                    <i class="fa fa-user" aria-hidden="true"></i>&nbsp;<a href="{{ url2('user/profile') }}/{{ $user->id }}">{{ $user->name }}</a>
                    {{ $review->post_date }}
                </div>
            </div>
        </div>
        @include('review.common.chart', ['r' => $review])

        <div style="margin-top: 10px;">
            <h5>プレイ状況</h5>
            <p class="break_word">{{ $review->progress }}</p>
            <h5>レビュー @if($review->is_spoiler == 1) <span class="badge badge-pill badge-danger">ネタバレあり！</span> @endif </h5>
            <p class="break_word">{{ $review->text }}</p>
        </div>

        <div>
            @if (!$isWriter && Auth::check())
                @if ($hasGood)
                    <form action="{{ url('review/good') }}/{{ $review->id }}" method="POST">
                        {{ method_field('DELETE') }}
                        <input type="hidden" name="_token" value="{{ $csrfToken }}">
                        {{ $review->post_date }}
                        <i class="fa fa-thumbs-o-up" aria-hidden="true"></i> {{ $review->good_num }}&nbsp;<button class="btn btn-sm btn-warning">いいね取り消し</button>
                    </form>
                @else
                    <form action="{{ url('review/good') }}/{{ $review->id }}" method="POST">
                        <input type="hidden" name="_token" value="{{ $csrfToken }}">
                        {{ $review->post_date }}
                        <i class="fa fa-thumbs-o-up" aria-hidden="true"></i> {{ $review->good_num }} &nbsp;<button class="btn btn-sm btn-info">いいね</button>
                    </form>
                @endif
            @else
                <i class="fa fa-thumbs-o-up" aria-hidden="true"></i> {{ $review->good_num }}
            @endif
            @if ($isWriter)
                <a href="{{ url2('review/good/history') }}/{{ $review->id }}">いいねしてくれたユーザー一覧</a>
            @endif
        </div>
    </section>
    @auth
    <hr>

    <section>
        @if (!$isWriter)
        <a href="{{ url('review/fraud_report/report') }}/{{ $review->id }}">このレビューを不正報告</a> |
        @endif
        <a href="{{ url('review/fraud_report/list') }}/{{ $review->id }}">このレビューへの不正報告一覧</a>
    </section>

        @if ($isWriter)
            <section>
                <a href="{{ url2('review/edit') }}/{{ $review->id }}">レビューを修正・削除</a>
            </section>
        @endif
    @endauth
@endsection