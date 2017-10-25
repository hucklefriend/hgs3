@extends('layouts.app')

@section('content')
    @verbatim
    <style>
        .card_soft {
            margin: 5px 5px;
            width: 120px;
        }
    </style>
    @endverbatim


    <h4 class="card-title">{{ $site->name }}</h4>
    <div class="d-flex flex-wrap">
        <div class=""><img src="{{ url2('img/banner/test/240x400.jpg') }}" class="img-responsive"></div>
        <div style="padding: 0 15px;min-width: 300px;">
            <h4>
                <span class="badge badge-pill badge-success">{{ \Hgs3\Constants\Site\MainContents::getText($site->main_contents_id) }}</span>
                @if ($site->rate > 0)
                    <span class="badge badge-pill badge-success">{{ \Hgs3\Constants\Site\Rate::getText($site->rate) }}</span>
                @endif
                @if ($site->gender != \Hgs3\Constants\Site\Gender::NONE)
                    <span class="badge badge-pill badge-success">{{ \Hgs3\Constants\Site\Gender::getText($site->gender) }}</span>
                @endif
            </h4>
            <table class="table table-responsive" style="width: 100%">
                <tbody>
                    <tr>
                        <th>URL</th>
                        <td>
                            <a href="{{ url('/site/go/' . $site->id) }}">{{ $site->url }}</a>
                            <small>[<a href="{{ url('/site/go/' . $site->id) }}" target="_blank">別窓</a>]</small>
                        </td>
                    </tr>
                    <tr>
                        <th>管理人</th>
                        <td><a href="{{ url2('user/profile/' . $webMaster->id) }}">{{ $webMaster->name }}さん</a></td>
                    </tr>
                    <tr>
                        <th>お気に入り人数</th>
                        <td>
                            <div class="d-flex">
                                <div class="mr-auto">{{ '0' }}人</div>
                                <div class="text-right">
                                    @if ($isWebMaster)
                                        <small><a href="{{ url2('site/favorite/' . $site->id) }}">登録者一覧</a></small>
                                    @endif
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>いいね数</th>
                        <td>
                            <div class="d-flex">
                                <div class="mr-auto">{{ number_format($site->good_num) }}</div>
                                <div class="text-right">
                                    @if ($isWebMaster)
                                        <small><a href="{{ url2('site/good_history/' . $site->id) }}">履歴</a></small>
                                    @endif
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>アクセス数</th>
                        <td>
                            <div class="d-flex">
                                <div class="mr-auto">{{ number_format($site->out_count) }}</div>
                                <div class="text-right">
                                @if ($isWebMaster)
                                    <small><a href="{{ url2('site/footprint/' . $site->id) }}">足跡</a></small>
                                @endif
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

            @if ($isWebMaster)
                <div class="text-right">
                    <a href="{{ url2('site/edit/' . $site->id) }}">サイト情報を編集</a>
                </div>
            @endif
        </div>
    </div>
    <br>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">紹介</h5>
            <p class="card-text">{!! nl2br(e($site->presentation)) !!}</p>
        </div>
    </div>
    <br>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">このサイトで扱っているゲーム</h5>
        </div>
        <div class="d-flex flex-wrap">
            @foreach ($handleSofts as $soft)
                <div>
                    <div class="card card_soft text-center">
                        <div class="card-body">
                            <a href="{{ url2('game/soft/' . $soft->id) }}">
                                @include('game.common.package_image_small', ['imageUrl' => $soft->small_image_url])
                            </a>
                            <a href="{{ url2('game/soft/' . $soft->id) }}"><small>{{ $soft->name }}</small></a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @if ($isWebMaster)
    @endif

@endsection