@extends('layouts.app')

@section('title')レビュー投稿@endsection
@section('global_back_link'){{ route('レビュー入力', ['soft' => $soft->id]) }}@endsection

@section('content')

    <div class="content__inner">
        <header class="content__title">
            <h1>レビュー投稿確認</h1>
        </header>

        <div class="row">
            <div class="col-sm-6">
                <div class="card card-hgn">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="package-image-small text-center">
                                <a href="{{ route('ゲーム詳細', ['soft' => $soft->id]) }}">
                                    @include('game.common.packageImage', ['imageUrl' => small_image_url($package)])
                                </a>
                            </div>
                            <div class="w-100">
                                <div class="review-game-title">
                                    <a href="{{ route('ゲーム詳細', ['soft' => $soft->id]) }}">{{ $soft->name }}</a>
                                </div>
                                <div class="mt-1">
                                    レビュー数<br>
                                    平均ポイント
                                </div>
                            </div>
                        </div>

                        <div class="text-right mt-2">
                            他のレビューを見る
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="card card-hgn">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="review-point">
                                {{ $draft->calcPoint() }}
                                <div class="review-point-mother"> / {{ \Hgs3\Constants\Review::MAX_POINT }}</div>
                            </div>

                            <table class="review-point-table">
                                <tr>
                                    <th>怖さ</th>
                                    <td>30点</td>
                                </tr>
                                <tr>
                                    <th>良い所</th>
                                    <td>30点</td>
                                </tr>
                                <tr>
                                    <th>すごく良い所</th>
                                    <td>30点</td>
                                </tr>
                                <tr>
                                    <th>悪い所</th>
                                    <td>30点</td>
                                </tr>
                                <tr>
                                    <th>すごく悪い所</th>
                                    <td>30点</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-6">
            <div class="card card-hgn">
                <div class="card-body">
                    <h5 class="card-title">投稿者</h5>

                    <div>
                        {{ $user->name }}さん
                    </div>
                    <div>
                        レビュー数 5本
                    </div>

                    @if (!empty($draft->url))
                        <div class="mt-3">
                            <p style="font-size: 0.85rem;">
                                このゲームのレビューを別のサイトでも書いています。<br>
                                そちらもご確認ください。<br>
                                <a href="{{ $draft->url }}" target="_blank">{{ $draft->url }} <i class="fas fa-sign-out-alt"></i></a>
                            </p>

                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card card-hgn">
                <div class="card-body">
                    <h5 class="card-title">プレイ状況</h5>

                    <div>遊んだゲーム</div>
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
                        <p class="mt-2">{{ nl2br($draft->progress) }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if ($draft->is_spoiler == 1)
        <div class="alert alert-danger mb-5" role="alert">
            <h4 class="alert-heading">ネタバレ注意！</h4>
            <p class="mb-0">
                このレビューにはネタバレが含まれています。<br>
                これより下にはネタバレを含む内容が記載されていますので、閲覧にはご注意ください。
            </p>
        </div>
    @endif

    <div class="row">
        <div class="col-md-6">
            <div class="card card-hgn">
                <div class="card-body">
                    <h5 class="card-title">良い点</h5>

                    <table>
                        <tr>
                            <td class="text-center"><i class="far fa-thumbs-up"></i></td>
                            <td>
                                @foreach ($draft->getGoodTags() as $tagId)
                                    <span class="review-tag">{{ \Hgs3\Constants\Review\Tag::getName($tagId) }}</span>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center"><i class="far fa-thumbs-up"></i><i class="far fa-thumbs-up"></i></td>
                            <td>
                                @foreach ($draft->getVeryGoodTags() as $tagId)
                                    <span class="review-tag">{{ \Hgs3\Constants\Review\Tag::getName($tagId) }}</span>
                                @endforeach
                            </td>
                        </tr>
                    </table>

                    <p class="mb-0">
                        @empty($draft->good_comment)
                            良い点に関するコメントはありません。
                        @else
                            {!! nl2br(e($draft->good_comment)) !!}
                        @endempty
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-hgn">
                <div class="card-body">
                    <h5 class="card-title">悪い点</h5>
                    <table>
                        <tr>
                            <td class="text-center"><i class="far fa-thumbs-down"></i></td>
                            <td>
                                @foreach ($draft->getBadTags() as $tagId)
                                    <span class="review-tag">{{ \Hgs3\Constants\Review\Tag::getName($tagId) }}</span>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center"><i class="far fa-thumbs-down"></i><i class="far fa-thumbs-down"></i></td>
                            <td>
                                @foreach ($draft->getVeryBadTags() as $tagId)
                                    <span class="review-tag">{{ \Hgs3\Constants\Review\Tag::getName($tagId) }}</span>
                                @endforeach
                            </td>
                        </tr>
                    </table>

                    <p class="mb-0">
                        @empty($draft->bad_comment)
                            悪い点に関するコメントはありません。
                        @else
                            {!! nl2br(e($draft->bad_comment)) !!}
                        @endempty
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-hgn">
        <div class="card-body">
            <h5 class="card-title">総合評価</h5>


            <p class="mb-0">
                @empty($draft->general_comment)
                    総合評価はありません。
                @else
                    {!! nl2br(e($draft->general_comment)) !!}
                @endempty
            </p>
        </div>
    </div>




    <form method="POST" action="{{ route('レビュー公開') }}" autocomplete="off" class="text-center" onsubmit="return confirm('このレビューを公開します。\nよろしいですね？');">
        <input type="hidden" name="soft_id" value="{{ $soft->id }}">
        {{ csrf_field() }}

        <div class="form-group">
            <button class="btn btn-primary">レビューを公開する</button>
            <p class="text-muted">
                <small>
                    レビュー公開後は、編集できなくなります。<br>
                    よくよくご確認の上、公開してください。
                </small>
            </p>
        </div>
    </form>

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
