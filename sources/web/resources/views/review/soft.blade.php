@extends('layouts.app')

@section('title'){{ $soft->name }}のレビュー@endsection
@section('global_back_link'){{ route('ゲーム詳細', ['soft' => $soft->id]) }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>{{ $soft->name }}</h1>
            <p class="mb-0">レビュー</p>
        </header>

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

        <div class="card card-hgn">
            <div class="card-body">
                <h4 class="card-title">みんなのレビュー</h4>




            </div>
        </div>


    </div>


    @if ($total !== null)

        <div class="d-flex align-items-stretch">
            <div class="p-2 align-self-center" style="min-width: 3em;">
                <div class="review-point-outline">
                    <p class="review-point">{{ $total->point }}</p>
                </div>
            </div>
            <div class="p-10 align-self-center">
                <div class="break-word" style="width: 100%;"><h5>{{ $soft->name }}</h5></div>
                <a href="{{ url('game/soft') }}/{{ $soft->id }}">ゲームの詳細</a> |
                <a href="{{ url('review/package_select') }}/{{ $soft->id }}">レビューを投稿する</a>
            </div>
        </div>

        @include('review.common.chart', ['r' => $total])

    <hr>
    <h5>レビュー一覧</h5>

    {{ $pager->links() }}

        @foreach ($reviews as $r)
            @include('review.common.normal', ['r' => $r, 'showLastMonthGood' => false])
            @if (!$loop->last)
                <hr>
            @endif
        @endforeach

    {{ $pager->links() }}
    @else
        <p>レビューが投稿されていません。</p>
    @endif
@endsection