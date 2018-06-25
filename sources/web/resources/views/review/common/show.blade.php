<div class="row">
    <div class="col-sm-6 col-md-5 col-lg-4">
        <div class="card card-hgn">
            <div class="card-body">
                <div class="d-flex">
                    <div class="review-point mr-2" style="padding-top: 5px;">
                        {{ \Hgs3\Constants\Review\Fear::$face[$review->fear] }}<br>
                        <small>{{ \Hgs3\Constants\Review\Fear::$acronym[$review->fear] }}</small>
                    </div>
                    <div class="review-point" style="line-height: 70px;">
                        {{ $review->calcPoint() }}
                    </div>

                    <table class="review-point-table">
                        <tr>
                            <th>{{ \Hgs3\Constants\Review\Fear::$face[\Hgs3\Constants\Review\Fear::getMaxPoint()] }}怖さ</th>
                            <td class="text-right">{{ $review->fear * \Hgs3\Constants\Review\Fear::POINT_RATE }}pt</td>
                        </tr>
                        <tr>
                            <th><i class="far fa-thumbs-up"></i>良い点</th>
                            <td class="text-right">{{ (count($review->getGoodTags()) + count($review->getVeryGoodTags())) * \Hgs3\Constants\Review\Tag::POINT_RATE }}pt</td>
                        </tr>
                        <tr>
                            <th><i class="far fa-thumbs-down"></i>悪い点</th>
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
    </div>

    <div class="col-sm-6 col-md-7 col-lg-8">
        <div class="card card-hgn">
            <div class="card-body">
                <h5 class="card-title">プレイ状況</h5>

                <div class="row">
                    @foreach ($packages as $pkg)
                        <div class="col-12 col-md-6 col-xl-4 mb-2 review-playing-package">
                            <div class="review-playing-package-image">
                                {!! small_image($pkg) !!}
                            </div>
                            <div class="review-playing-package-title">
                                <small>{{ $pkg->name }}</small>
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
        <p class="mb-0">これより下にはネタバレを含む内容が記載されています。ご注意ください。</p>
    </div>
@endif

    <div class="card card-hgn">
        <div class="card-body">
            <h5 class="card-title">怖さ：{{ Hgs3\Constants\Review\Fear::$data[$review->fear] }}</h5>

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
                <i class="far fa-thumbs-up"></i>良い点：{{ (count($review->getGoodTags()) + count($review->getVeryGoodTags())) * \Hgs3\Constants\Review\Tag::POINT_RATE }}pt
            </h5>

            @empty($review->getGoodTags())
                <p>良い点はありません。</p>
            @else
                <div class="d-flex flex-wrap">
                    @foreach ($review->getGoodTags() as $tagId)
                        <span class="tag simple mr-2 mb-2">
                            {{ \Hgs3\Constants\Review\Tag::getName($tagId) }}
                        @if ($review->isVeryGood($tagId))
                            <i class="far fa-thumbs-up"></i>
                        @endif
                        </span>
                    @endforeach
                </div>
                <div>
                    <small><i class="far fa-thumbs-up"></i>付きタグは特に良い点</small>
                </div>
            @endempty

            <p class="mb-0 review-text mt-4">
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
                <i class="far fa-thumbs-down"></i> 悪い点：-{{ (count($review->getBadTags()) + count($review->getVeryBadTags())) * \Hgs3\Constants\Review\Tag::POINT_RATE }}pt
            </h5>
                @empty($review->getBadTags())
                    <p>悪い点はありません。</p>
                @else
                <div class="d-flex flex-wrap">
                    @foreach ($review->getBadTags() as $tagId)
                    <span class="tag simple mr-2 mb-2">
                        {{ \Hgs3\Constants\Review\Tag::getName($tagId) }}
                        @if ($review->isVeryBad($tagId))
                            <i class="far fa-thumbs-down"></i>
                        @endif
                    </span>
                    @endforeach
                </div>
                <div>
                    <small><i class="far fa-thumbs-down"></i>付きタグは特に悪い点</small>
                </div>
                @endempty

            <p class="mb-0 review-text mt-4">
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

