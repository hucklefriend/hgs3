@extends('layouts.app')

@section('content')
    <h4>{{ $game->name }}</h4>

    <nav>
        <a href="{{ url('game/soft') }}">一覧へ</a> |
        <a href="{{ url('game/soft/edit') }}/{{ $game->id }}">データ編集</a>
    </nav>

    <style>
        .card {
            margin-bottom: 30px;
        }
    </style>

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    ベースデータ
                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-5">メーカー</div>
                        <div class="col-7"><a href="{{ url('game/company') }}/{{ $company->id }}">{{ $company->name }}</a></div>
                    </div>
                    <div class="row">
                        <div class="col-5">レビュー数</div>
                        <div class="col-7">{{ $base['review_num'] }}</div>
                    </div>
                    <div class="row">
                        <div class="col-5">お気に入り登録者数</div>
                        <div class="col-7">{{ $base['favorite_num'] }}</div>
                    </div>
                    @if ($isUser)
                    <div class="row">
                        <div class="col-5">お気に入り</div>
                        <div class="col-7">
                            @if ($isFavorite)
                                <form action="{{ url('user/favorite_game') }}" method="POST" class="form-inline">
                                    <input type="hidden" name="_token" value="{{ $csrfToken }}">
                                    <input type="hidden" value="{{ $game->id }}" name="game_id">
                                    {{ method_field('DELETE') }}
                                    <span style="padding-right: 20px;">登録済み</span>
                                    <button class="btn btn-sm btn-warning">取り消す</button>
                                </form>
                            @else
                                <form action="{{ url('user/favorite_game') }}" method="POST" class="form-inline">
                                    <input type="hidden" name="_token" value="{{ $csrfToken }}">
                                    <input type="hidden" value="{{ $game->id }}" name="game_id">
                                    <button class="btn btn-sm btn-info">登録する</button>
                                </form>
                            @endif
                        </div>
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-5">サイト数</div>
                        <div class="col-7">{{ $base['site_num'] }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    パッケージ情報
                </div>
                <div class="card-block">
                @foreach ($packages as $pkg)
                    <div class="row">
                        <div class="col-4">
                            <img src="{{ $pkg->medium_image_url }}" class="img-responsive" style="max-width: 100%;">
                        </div>
                        <div class="col-8">
                            <div><h4>{{ $pkg->name }}</h4></div>
                            <div>{{ $pkg->platform_name }}</div>
                            <div>{{ $pkg->release_date }}</div>
                            <div>
                                <a href="{{ $pkg->item_url }}" target="_blank"><img src="{{ url('img/assocbutt_or_detail._V371070159_.png') }}"></a>
                            </div>
                        </div>
                    </div>

                    @if ($isAdmin)
                    <div class="row">
                        <div class="col-1">
                            <a href="{{ url('game/package/edit') }}/{{ $game->id }}/{{ $pkg->id }}"><button type="button" class="btn btn-info btn-sm">編集</button></a>
                        </div>
                        <div class="col-1">
                            <form method="POST" action="{{ url('game/package/delete') }}/{{ $pkg->id }}" onsubmit="return confirm('削除します');">
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-danger btn-sm">削除</button>
                            </form>
                        </div>
                        <div class="col-8">

                        </div>
                    </div>
                    @endif
                    <hr>
                @endforeach
                    @if ($isAdmin)
                    <p><a href="{{ url('game/package/add') }}/{{ $game->id }}">パッケージを追加</a></p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <a name="review">レビュー</a>
                </div>
                <div class="card-block">
                    @if ($review != null)
                        <div class="row">
                            <div class="col-5">平均ポイント</div>
                            <div class="col-7">{{ $review->point }}</div>
                        </div>
                        <div class="row">
                            <div class="col-5">平均プレイ時間</div>
                            <div class="col-7">{{ $review->play_time }}</div>
                        </div>
                        <div class="row">
                            <div class="col-5">レビュー数</div>
                            <div class="col-7">{{ $review->review_num }}</div>
                        </div>
                        <div class="row">
                            <div class="col-5">怖さ</div>
                            <div class="col-7">{{ $review->fear }}</div>
                        </div>
                        <div class="row">
                            <div class="col-5">シナリオ</div>
                            <div class="col-7">{{ $review->story }}</div>
                        </div>
                        <div class="row">
                            <div class="col-5">ボリューム</div>
                            <div class="col-7">{{ $review->volume }}</div>
                        </div>
                        <div class="row">
                            <div class="col-5">グラフィック</div>
                            <div class="col-7">{{ $review->graphic }}</div>
                        </div>
                        <div class="row">
                            <div class="col-5">サウンド</div>
                            <div class="col-7">{{ $review->sound }}</div>
                        </div>
                        <div class="row">
                            <div class="col-5">操作性</div>
                            <div class="col-7">{{ $review->controllability }}</div>
                        </div>
                        <div class="row">
                            <div class="col-5">難易度</div>
                            <div class="col-7">{{ $review->difficulty }}</div>
                        </div>
                        <div class="row">
                            <div class="col-5">やりこみ</div>
                            <div class="col-7">{{ $review->crowded }}</div>
                        </div>
                        <div class="row">
                            <div class="col-5">オススメ</div>
                            <div class="col-7">{{ $review->recommend }}</div>
                        </div>

                        <div style="margin-top: 15px;margin-bottom: 15px;">
                            <a href="{{ url('game/review/soft') }}/{{ $game->id }}">レビュー一覧へ</a>
                        </div>
                    @else
                        <p>レビューは投稿されていません。<br>
                            最初のレビューを投稿してみませんか？</p>
                    @endif
                    <div>
                        <a href="{{ url('game/review/input') }}/{{ $game->id }}">レビューの投稿</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    サイト
                </div>
                <div class="card-block">
                    <div class="card-text">工事中</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    お気に入り登録者
                </div>
                <div class="card-block">
                    @if (!empty($favorite))
                        @foreach ($favorite as $fu)
                            <div class="row">
                                <div class="col-1"></div>
                                <div class="col-10">
                                    <a href="{{ url('user/profile') }}/{{ $fu->id }}">{{ $fu->name }}</a>
                                </div>
                            </div>
                            <hr>
                        @endforeach
                            <p>
                                ⇒ <a href="{{ url('game/favorite/') }}/{{ $game->id }}">全ての登録者を見る</a>
                            </p>
                    @else
                        <p>
                            お気に入りに登録しているユーザーはいません。
                            @if ($isUser)
                            <br>お気に入りに登録しませんか？
                            <form action="{{ url('user/favorite_game') }}" method="POST">
                                <input type="hidden" name="_token" value="{{ $csrfToken }}">
                                <input type="hidden" value="{{ $game->id }}" name="game_id">
                                <button class="btn btn-sm btn-info">登録する</button>
                            </form>
                            @endif
                        </p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    同一シリーズの別タイトル
                </div>
                <div class="card-block">
                    @if($series != null)
                        <ul class="list-group">
                            @foreach ($series['list'] as $sl)
                                <li class="list-group-item">
                                    <a href="{{ url('game/soft') }}/{{ $sl->id }}">{{ $sl->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>シリーズの別タイトルはありません。</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

<style>
    section {
        margin-top: 30px;
    }
</style>

@endsection