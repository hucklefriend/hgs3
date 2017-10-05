@extends('layouts.app')

@section('content')

    <style>
        .card {
            margin-bottom: 10px;
        }
    </style>


    <section>
        <h5>{{ $user->name }}さんのプロフィール</h5>
    </section>

    @if ($isMyself)
    <p><a href="{{ url2('user/profile/edit') }}">プロフィール編集</a></p>
    @else
    <div>
        <div>
            <a href="{{ url2('user/follow') }}/{{ $user->id }}">フォロー数: {{ $followNum }}</a>
        </div>
        <div>
            <a href="{{ url2('user/follower') }}/{{ $user->id }}">フォロワー数: {{ $followerNum }}</a>
        </div>


        @if ($isFollow)
            フォロー中
            <form action="{{ url2('user/follow') }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <input type="hidden" name="follow_user_id" value="{{ $user->id }}">
                <button class="btn btn-danger">解除</button>
            </form>
        @else
            <form action="{{ url2('user/follow') }}" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="follow_user_id" value="{{ $user->id }}">
                <button class="btn btn-danger">フォローする</button>
            </form>
        @endif
    </div>
    @endif

    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    お気に入りゲーム
                </div>
                <div class="card-body">
                    @foreach ($favoriteGames as $fg)
                        <div><a href="{{ url2('game/soft') }}/{{ $fg->game_id }}">{{ $games[$fg->game_id] }}</a></div>
                    @endforeach
                    → <a href="{{ url2('/user/favorite_game') }}/{{ $user->id }}">もっと見る</a>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    遊んだゲーム
                </div>
                <div class="card-body">
                    @foreach ($playedGames as $pg)
                        <div><a href="{{ url2('game/soft') }}/{{ $pg->game_id }}">{{ $games[$pg->game_id] }}</a></div>
                    @endforeach
                    → <a href="{{ url2('/user/played_game') }}/{{ $user->id }}">もっと見る</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    サイト
                </div>
                <div class="card-body">
                    @foreach ($sites as $site)
                        <div>{{ $site->name }}</div>
                        <div><a href="{{ $site->url }}">{{ $site->url }}</a></div>
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    お気に入りサイト
                </div>
                <div class="card-body">
                    @foreach ($favoriteSites['order'] as $siteId)
                        <div><a href="{{ url2('site/detail') }}/{{ $siteId }}">{{ $favoriteSites['sites'][$siteId]->name }}</a></div>
                        <div><a href="{{ $favoriteSites['sites'][$siteId]->url }}">{{ $favoriteSites['sites'][$siteId]->url }}</a></div>
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    レビュー
                </div>
                <div class="card-body">
                    @foreach ($reviews as $r)
                        <p style="word-wrap: break-word;"><a href="{{ url2('/game/review/detail') }}/{{ $r->id }}">{{ $r->title }}</a></p>
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    いいねしたレビュー
                </div>
                <div class="card-body">
                    @foreach ($goodReviews['order'] as $gr)
                        <p style="word-wrap: break-word;">
                            <a href="{{ url2('/game/review/detail') }}/{{ $gr->review_id }}">{{ $goodReviews['reviews'][$gr->review_id]->title }}</a>
                        </p>
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    攻略日記
                </div>
                <div class="card-body">
                    <p class="card-text">工事中</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    参加コミュニティ
                </div>
                <div class="card-body">
                    @foreach ($communities as $c)
                        <div><a href="{{ url2('community/g') }}/{{ $c }}">{{ $games[$c] ?? '---' }}</a></div>
                    @endforeach

                    <div><a href="{{ url2('user/communities') }}/{{ $user->id }}">⇒もっと見る</a></div>
                </div>
            </div>
        </div>
    </div>

@endsection