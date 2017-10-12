@extends('layouts.app')

@section('content')
    @if ($total !== null)

        <div class="d-flex align-items-stretch">
            <div class="p-2 align-self-center" style="min-width: 3em;">
                <div class="review_point_outline">
                    <p class="review_point">{{ $total->point }}</p>
                </div>
            </div>
            <div class="p-10 align-self-center">
                <div class="break_word" style="width: 100%;"><h5>{{ $game->name }}</h5></div>
                <a href="{{ url('game/soft') }}/{{ $game->id }}">ゲームの詳細</a> |
                <a href="{{ url('review/package_select') }}/{{ $game->id }}">レビューを投稿する</a>
            </div>
        </div>

        @include('review.common.chart', ['r' => $total])

    <hr>
    <h5>レビュー一覧</h5>

    {{ $pager }}

        @foreach ($reviews as $r)
            @include('review.common.normal', ['r' => $r, 'showLastMonthGood' => false])
            @if (!$loop->last)
                <hr>
            @endif
        @endforeach

    {{ $pager }}
    @else
        <p>レビューが投稿されていません。</p>
    @endif
@endsection