<div class="row">
    <div class="col-sm-6 col-md-5 col-lg-4">
        <div class="card card-hgn">
            <div class="card-body">
                <div class="d-flex">
                    <div class="review-point">
                        {{ $review->calcPoint() }}
                    </div>

                    <table class="review-point-table">
                        <tr>
                            <th>怖さ{{ \Hgs3\Constants\Review\Fear::$face[$review->fear] }}</th>
                            <td class="text-right">{{ $review->fear * \Hgs3\Constants\Review\Fear::POINT_RATE }}pt</td>
                        </tr>
                        <tr>
                            <th>良い点<i class="far fa-thumbs-up"></i></th>
                            <td class="text-right">{{ (count($review->getGoodTags()) + count($review->getVeryGoodTags())) * \Hgs3\Constants\Review\Tag::POINT_RATE }}pt</td>
                        </tr>
                        <tr>
                            <th>悪い点<i class="far fa-thumbs-down"></i></th>
                            <td class="text-right">-{{ (count($review->getBadTags()) + count($review->getVeryBadTags())) * \Hgs3\Constants\Review\Tag::POINT_RATE }}pt</td>
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

        <div class="card card-hgn mt-5">
            <div class="card-body">
                <p>読んだユーザーが受けた印象</p>
                <div class="d-flex justify-content-between">
                    <div class="align-self-center">
                        <span class="review-tag">🤔 {{ $review->fmfm_num }}</span>
                        <span class="review-tag">😒 {{ $review->n_num }}</span>
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
        <p class="mb-0">これより下にはネタバレを含む内容が記載されていますので、閲覧にはご注意ください。</p>
    </div>
@endif

    <div class="card card-hgn">
        <div class="card-body">
            <h5 class="card-title">{{ Hgs3\Constants\Review\Fear::$data[$review->fear] }}</h5>

            <p class="mb-0 review-text">
                @empty($review->fear_comment)
                    怖さに関するコメントはありません。
                @else
                    {!! nl2br(e($review->fear_comment)) !!}
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

    <div class="card card-hgn">
        <div class="card-body">
            <h5 class="card-title">
                <i class="far fa-thumbs-down"></i> 悪い点
                <span class="card-title-sub"><i class="far fa-thumbs-down"></i>付きタグは特に悪い点</span>
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

