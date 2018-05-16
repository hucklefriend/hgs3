<div class="row">
    <div class="col-sm-6">
        <div class="card card-hgn">
            <div class="card-body">
                <div class="d-flex">
                    <div class="review-point">
                        {{ $review->calcPoint() }}
                    </div>

                    <table class="review-point-table">
                        <tr>
                            <th>怖さ</th>
                            <td class="text-right">{{ $review->fear * 5 }}点</td>
                        </tr>
                        <tr>
                            <th>良い所</th>
                            <td class="text-right">{{ count($review->getGoodTags()) }}点</td>
                        </tr>
                        <tr>
                            <th>すごく良い所</th>
                            <td class="text-right">{{ count($review->getVeryGoodTags()) }}点</td>
                        </tr>
                        <tr>
                            <th>悪い所</th>
                            <td class="text-right">-{{ count($review->getBadTags()) }}点</td>
                        </tr>
                        <tr>
                            <th>すごく悪い所</th>
                            <td class="text-right">-{{ count($review->getVeryBadTags()) }}点</td>
                        </tr>
                    </table>
                </div>
                @if (!empty($review->url))
                <div class="mt-4">
                    @if ($review->enable_url == 1)
                        <div class="mt-3">
                            <p style="font-size: 0.85rem;">
                                このゲームのレビューを別のサイトでも書いています。<br>
                                そちらもご確認ください。<br>
                                <a href="{{ $review->url }}" target="_blank">{{ $review->url }} <i class="fas fa-sign-out-alt"></i></a>
                            </p>
                        </div>
                    @else
                        <div class="mt-3">
                            <p style="font-size: 0.85rem;">
                                このゲームのレビューを別のサイトでも書いていますが、管理人がチェックするまで公開されません。
                            </p>
                        </div>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="card card-hgn">
            <div class="card-body">
                <h5 class="card-title">遊んだゲーム</h5>

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
                @if (!empty($review->progress))
                    <p class="mt-2 review-text">{!! nl2br($review->progress) !!}</p>
                @endif
            </div>
        </div>
    </div>
</div>


@if ($review->is_spoiler == 1)
    <div class="alert alert-danger mb-5" role="alert">
        <h4 class="alert-heading">ネタバレ注意！</h4>
        <p class="mb-0">
            このレビューにはネタバレが含まれています。<br>
            これより下にはネタバレを含む内容が記載されていますので、閲覧にはご注意ください。
        </p>
    </div>
@endif

<div class="row">
    <div class="col-lg-6">
        <div class="card card-hgn">
            <div class="card-body">
                <h5 class="card-title">
                    良い所
                    <span class="card-title-sub"><i class="far fa-thumbs-up"></i>は特に良い所</span>
                </h5>

                    @empty($review->getGoodTags())
                    <p>良い点はありません。</p>
                    @else
                    <div class="d-flex flex-wrap mb-2">
                        @foreach ($review->getGoodTags() as $tagId)
                        <span class="review-tag">
                            {{ \Hgs3\Constants\Review\Tag::getName($tagId) }}
                            @if ($review->isVeryGood($tagId))
                            <i class="far fa-thumbs-up"></i>
                            @endif
                        </span>
                        @endforeach
                    </div>
                    @endempty

                <p class="mb-0 review-text">
                    @empty($review->good_comment)
                        良い点に関するコメントはありません。
                    @else
                        {!! nl2br(e($review->good_comment)) !!}
                    @endempty
                </p>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card card-hgn">
            <div class="card-body">
                <h5 class="card-title">
                    悪い所
                    <span class="card-title-sub"><i class="far fa-thumbs-down"></i>は特に悪い所</span>
                </h5>
                    @empty($review->getBadTags())
                        <p>悪い点はありません。</p>
                    @else
                    <div class="d-flex flex-wrap mb-2">
                        @foreach ($review->getBadTags() as $tagId)
                        <span class="review-tag">
                            {{ \Hgs3\Constants\Review\Tag::getName($tagId) }}
                                @if ($review->isVeryBad($tagId))
                            <i class="far fa-thumbs-down"></i>
                                @endif
                        </span>
                        @endforeach
                    </div>
                    @endempty

                <p class="mb-0 review-text">
                    @empty($review->bad_comment)
                        悪い点に関するコメントはありません。
                    @else
                        {!! nl2br(e($review->bad_comment)) !!}
                    @endempty
                </p>
            </div>
        </div>
    </div>
</div>

<div class="card card-hgn">
    <div class="card-body">
        <h5 class="card-title">総合評価</h5>
        <p class="mb-0 review-text">
            @empty($review->general_comment)
                総合評価はありません。
            @else
                {!! nl2br(e($review->general_comment)) !!}
            @endempty
        </p>
    </div>
</div>