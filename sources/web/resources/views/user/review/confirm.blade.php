@extends('layouts.app')

@section('title')レビュー投稿@endsection
@section('global_back_link'){{ route('レビュー入力', ['soft' => $soft->id]) }}@endsection

@section('content')

    <div class="content__inner">
        <header class="content__title">
            <h1>{{ $soft->name }}</h1>
            <p class="mb-0">{{ $user->name }}さんのレビュー(公開前の確認用)</p>
        </header>

        <div class="row">
            <div class="col-sm-6 col-md-5 col-lg-4">
                <div class="card card-hgn">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="review-point">
                                {{ $draft->calcPoint() }}
                            </div>

                            <table class="review-point-table">
                                <tr>
                                    <th>怖さ{{ \Hgs3\Constants\Review\Fear::$face[$draft->fear] }}</th>
                                    <td class="text-right">{{ $draft->fear * \Hgs3\Constants\Review\Fear::POINT_RATE }}pt</td>
                                </tr>
                                <tr>
                                    <th>良い点<i class="far fa-thumbs-up"></i></th>
                                    <td class="text-right">{{ (count($draft->getGoodTags()) + count($draft->getVeryGoodTags())) * \Hgs3\Constants\Review\Tag::POINT_RATE }}pt</td>
                                </tr>
                                <tr>
                                    <th>悪い点<i class="far fa-thumbs-down"></i></th>
                                    <td class="text-right">-{{ (count($draft->getBadTags()) + count($draft->getVeryBadTags())) * \Hgs3\Constants\Review\Tag::POINT_RATE }}pt</td>
                                </tr>
                            </table>
                        </div>
                        @if (!empty($draft->url))
                            <div class="mt-4">
                                <div class="mt-3">
                                    <p style="font-size: 0.85rem;">
                                        このゲームのレビューを別のサイトでも書いています。<br>
                                        そちらもご確認ください。<br>
                                        <a href="{{ $draft->url }}" target="_blank">{{ $draft->url }} <i class="fas fa-sign-out-alt"></i></a>
                                    </p>
                                </div>
                                <p class="text-muted mb-0"><small>※外部サイトのURLは管理人がチェックするまで表示されません。</small></p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-7 col-lg-8">
                <div class="card card-hgn">
                    <div class="card-body">
                        <h5 class="card-title">プレイ状況</h5>

                        <div class="row">
                            @foreach ($packages as $pkg)
                                <div class="col-12 col-md-6 col-xl-4 mb-2">
                                    <div class="d-flex mr-2">
                                        <div style="width: 30px;" class="align-self-center text-center mr-2">
                                            @include('game.common.packageImage', ['imageUrl' => small_image_url($pkg)])
                                        </div>
                                        <div class="align-self-center">
                                            <small>{{ $pkg->name }}</small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @if (!empty($draft->progress))
                            <p class="mt-2 review-text">{!! nl2br($draft->progress) !!}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6 col-md-5 col-lg-4">
                <div class="card card-hgn">
                    <div class="card-body">
                        <p>読んだユーザーが受けた印象</p>
                        <div class="d-flex justify-content-between">
                            <div class="align-self-center">
                                <span class="review-tag">🤔 0</span>
                                <span class="review-tag">😒 0</span>
                            </div>
                            <div class="text-right">
                                <button class="btn btn-light btn--icon" data-toggle="modal" data-target="#help"><i class="fas fa-question"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-7 col-lg-8">
                <div class="card card-hgn">
                    <div class="card-body">
                        広告用スペース
                    </div>
                </div>
            </div>
        </div>


        @if ($draft->is_spoiler == 1)
            <div class="alert alert-danger mb-5" role="alert">
                <h4 class="alert-heading">ネタバレ注意！</h4>
                <p class="mb-0">これより下にはネタバレを含む内容が記載されていますので、閲覧にはご注意ください。</p>
            </div>
        @endif

        <div class="card card-hgn">
            <div class="card-body">
                <h5 class="card-title">{{ Hgs3\Constants\Review\Fear::$data[$draft->fear] }}</h5>

                <p class="mb-0 review-text">
                    @empty($draft->fear_comment)
                        怖さに関するコメントはありません。
                    @else
                        {!! nl2br(e($draft->fear_comment)) !!}
                    @endempty
                </p>
            </div>
        </div>

        <div class="card card-hgn">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="far fa-thumbs-up"></i>良い点
                    <span class="card-title-sub"><i class="far fa-thumbs-up"></i>付きタグは特に良い点</span>
                </h5>

                @empty($draft->getGoodTags())
                    <p>良い点はありません。</p>
                @else
                    <div class="d-flex flex-wrap mb-2">
                        @foreach ($draft->getGoodTags() as $tagId)
                            <span class="review-tag">
                                {{ \Hgs3\Constants\Review\Tag::getName($tagId) }}
                                @if ($draft->isVeryGood($tagId))
                                    <i class="far fa-thumbs-up"></i>
                                @endif
                            </span>
                        @endforeach
                    </div>
                @endempty

                <p class="mb-0 review-text">
                    @empty($draft->good_comment)
                        良い点に関するコメントはありません。
                    @else
                        {!! nl2br(e($draft->good_comment)) !!}
                    @endempty
                </p>
            </div>
        </div>

        <div class="card card-hgn">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="far fa-thumbs-down"></i> 悪い点
                    <span class="card-title-sub"><i class="far fa-thumbs-down"></i>付きタグは特に悪い点</span>
                </h5>
                @empty($draft->getBadTags())
                    <p>悪い点はありません。</p>
                @else
                    <div class="d-flex flex-wrap mb-2">
                        @foreach ($draft->getBadTags() as $tagId)
                            <span class="review-tag">
                        {{ \Hgs3\Constants\Review\Tag::getName($tagId) }}
                                @if ($draft->isVeryBad($tagId))
                                    <i class="far fa-thumbs-down"></i>
                                @endif
                    </span>
                        @endforeach
                    </div>
                @endempty

                <p class="mb-0 review-text">
                    @empty($draft->bad_comment)
                        悪い点に関するコメントはありません。
                    @else
                        {!! nl2br(e($draft->bad_comment)) !!}
                    @endempty
                </p>
            </div>
        </div>

        <div class="card card-hgn">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h5 class="card-title">総合評価</h5>
                    <div>
                        <a href="{{ route('レビュー総評入力', ['soft' => $draft->soft_id]) }}" class="badge badge-pill and-more mt-0">編集</a>
                    </div>
                </div>

                <p class="mb-0 review-text">
                    @empty($draft->general_comment)
                        総合評価はありません。
                    @else
                        {!! nl2br(e($draft->general_comment)) !!}
                    @endempty
                </p>
            </div>
        </div>

        <div class="modal fade" id="help" tabindex="-1" role="dialog" aria-labelledby="help" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header mb-0">
                        <h5 class="modal-title" id="fmfm">🤔 ふむふむ</h5>
                    </div>
                    <div class="modal-body py-2">
                        <p>どちらかというと好印象</p>
                        <ul>
                            <li>文章がまとまっていて、読みやすい</li>
                            <li>書いてある意見に同意できる</li>
                            <li>意見には同意できないけど、レビューとしてよく書けている</li>
                        </ul>
                    </div>
                    <div class="modal-header mb-0">
                        <h5 class="modal-title" id="n-">😒 んー…</h5>
                    </div>
                    <div class="modal-body py-2">
                        <p>どちらかというと悪印象</p>
                        <ul>
                            <li>文章が読みにくい</li>
                            <li>書いてある意見に納得いかない</li>
                            <li>レビューになってない</li>
                        </ul>
                    </div>
                    <div class="text-center mb-5">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>

        @if ($draft->is_spoiler == 0)
            <form method="POST" action="{{ route('レビューネタバレなしだった', ['soft' => $soft->id]) }}">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <button class="btn btn-light">読み直したらネタバレはなかったのでネタバレなしにする</button>
            </form>
        @else
            <form method="POST" action="{{ route('レビューネタバレありだった', ['soft' => $soft->id]) }}">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <button class="btn btn-light">読み直したらネタバレがあったのでネタバレありにする</button>
            </form>
        @endif

        <p class="alert alert-warning alert-warning-hgn mt-5 mb-2" role="alert">
            レビュー公開後は、修正することができません。<br>
            削除はできますが、削除後半年は同じゲームのレビューを書くことができません。<br>
            よくよくご確認の上、公開してください。
        </p>

        <div class="row mt-5">
            <div class="col-6 text-center">
                <a href="{{ route('レビュー入力', ['soft' => $soft->id]) }}" class="btn btn-light">修正する</a>
            </div>
            <div class="col-6">
                <form method="POST" action="{{ route('レビュー公開', ['soft' => $soft->id]) }}" autocomplete="off" class="text-center" onsubmit="return confirm('このレビューを公開します。\nよろしいですね？');">
                    <input type="hidden" name="soft_id" value="{{ $soft->id }}">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <button class="btn btn-primary">レビューを公開する</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('プロフィール2', ['showId' => Auth::user()->show_id, 'show' => 'review']) }}">レビュー</a></li>
            <li class="breadcrumb-item active" aria-current="page">レビュー投稿</li>
        </ol>
    </nav>
@endsection
