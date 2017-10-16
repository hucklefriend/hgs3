@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card card-hgn">
                <div class="card-header">
                    新着(5件)
                </div>
                <div class="card-body">
                @if (empty($newArrival))
                    <div class="card-text">
                        <p>新着レビューはありません。</p>
                    </div>
                @else
                    @foreach ($newArrival as $r)
                        @include('review.common.normal', ['r' => $r, 'showLastMonthGood' => false])
                        @if (!$loop->last)
                        <hr>
                        @endif
                    @endforeach
                @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-hgn">
                <div class="card-header">評価の高いゲーム</div>
                <div class="card-body">
                    @if (empty($highScore))
                        <p>評価の高いゲーム。</p>
                    @else
                        <div>
                            @foreach ($highScore as $r)
                                @include('review.common.game', ['r' => $r])
                                @if (!$loop->last)
                                    <hr>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card card-hgn">
                <div class="card-header">
                    直近1ヶ月のいいねの多いレビュー
                </div>
                <div class="card-body">
                    @if (empty($manyGood))
                        <div class="card-text">
                            <p>直近1ヶ月のいいねの多いレビューはありません。</p>
                        </div>
                    @else
                        @foreach ($manyGood as $r)
                            @include('review.common.normal', ['r' => $r, 'showLastMonthGood' => true])
                            @if (!$loop->last)
                                <hr>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection