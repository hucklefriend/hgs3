@extends('layouts.app')

@section('content')
    @verbatim
    <style>
        @media (min-width: 576px) {
            .card-columns {
                column-count: 2;
            }
        }

        @media (min-width: 768px) {
            .card-columns {
                column-count: 3;
            }
        }

        @media (min-width: 992px) {
            .card-columns {
                column-count: 4;
            }
        }

        @media (min-width: 1200px) {
            .card-columns {
                column-count: 5;
            }
        }
    </style>
    @endverbatim

    <div>
        <h4>{{ $site->name }}</h4>


        <div class="d-sm-none">
            <img src="{{ url2('img/banner/test/200x40.gif') }}">
        </div>
        <div class="d-md-none d-none d-sm-block">
            <img src="{{ url2('img/banner/test/300x100.png') }}" style="width: 100%;max-width:300px;">
        </div>
        <div class="d-none d-md-block">
            <img src="{{ url2('img/banner/test/728x90.gif') }}">
        </div>
    </div>
    <br>
    <div class="card-columns">
        <div class="card card_site">
            <div class="card-body">
                <h6 class="card-title">管理人</h6>
                <p class="card-text">
                    {{ $admin->name }}さん
                </p>
            </div>
        </div>
        <div class="card card_site">
            <div class="card-body">
                <h5 class="card-title">メインコンテンツ</h5>
                <p class="card-text">
                    {{ \Hgs3\Constants\Site\MainContents::getText($site->main_contents_id) }}
                </p>
            </div>
        </div>
        <div class="card card_site">
            <div class="card-body">
                <h5 class="card-title">取扱いゲーム</h5>
                <p class="card-text">
                    {{ $handleGames }}
                </p>
            </div>
        </div>
        <div class="card card_site">
            <div class="card-body">
                <h5 class="card-title">紹介文</h5>
                <p class="card-text">{{ $site->presentation }}</p>
            </div>
        </div>
        <div class="card card_site">
            <div class="card-body">
                <h5 class="card-title">対象年齢</h5>
                <p class="card-text">{{ \Hgs3\Constants\Site\Rate::getText($site->rate) }}</p>
            </div>
        </div>
        <div class="card card_site">
            <div class="card-body">
                <h5 class="card-title">性別傾向</h5>
                <p class="card-text">{{ \Hgs3\Constants\Site\Gender::getText($site->rate) }}</p>
            </div>
        </div>
        <div class="card card_site">
            <div class="card-body">
                <h5 class="card-title">アクセス</h5>
                <p class="card-text">
                    <a href="{{ url('/site/go') }}/{{ $site->id }}">{{ $site->url }}</a>
                    <small>[<a href="{{ url('/site/go') }}/{{ $site->id }}" target="_blank">別窓</a>]</small>
                </p>
            </div>
        </div>
        <div class="card card_site">
            <div class="card-body">
                <h5 class="card-title">アクセス数</h5>
                <p class="card-text">
                    {{ number_format($site->out_count) }}
                </p>
            </div>
        </div>
        @if (Auth::check() && !$isWebMaster)
            <div class="card card_site">
                <div class="card-body">
                    <h5 class="card-title">お気に入り</h5>
                    <p class="card-text">
                        @if ($isFavorite)
                        <form method="POST" action="{{ url('user/favorite_site') }}">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <input type="hidden" name="site_id" value="{{ $site->id }}">
                            <button class="btn btn-warning btn-sm">解除する</button>
                        </form>
                        @else
                        <form method="POST" action="{{ url('user/favorite_site') }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="site_id" value="{{ $site->id }}">
                            <button class="btn btn-info btn-sm">登録する</button>
                        </form>
                        @endif
                    </p>
                </div>
            </div>
        @endif
    </div>

    @if ($isWebMaster)
    <p class="text-muted">※これより下はサイト登録をしたユーザー本人のみ確認できます。</p>
    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h5>お気に入り登録者</h5>
                    @foreach ($favoriteUsers as $fu)
                        @include('user.common.icon', ['u' => $fu])
                        @include('user.common.user_name', ['id' => $fu->id, 'name' => $fu->name])
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h5>足跡</h5>
                    @foreach ($footprint as $fp)
                        <div class="row">
                            <div class="col-4">{{ $fp->user_id }}</div>
                            <div class="col-8"></div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif

@endsection