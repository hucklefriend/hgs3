<div class="row">
    <div class="col-sm-6">
        <div class="card card-hgn">
            <div class="card-body">
                <div class="d-flex">
                    <div class="package-image-small text-center">
                        <a href="{{ route('ゲーム詳細', ['soft' => $soft->id]) }}">
                            @include('game.common.packageImage', ['imageUrl' => small_image_url($soft->originalPackage())])
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
                        {{ $review->calcPoint() }}
                        <div class="review-point-mother"> / {{ \Hgs3\Constants\Review::MAX_POINT }}</div>
                    </div>

                    <table class="review-point-table">
                        <tr>
                            <th>基本点</th>
                            <td class="text-right">50点</td>
                        </tr>
                        <tr>
                            <th>怖さ</th>
                            <td class="text-right">{{ $review->fear }}点</td>
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
                    レビュー数 {{ $user->getReviewNum() }}本
                </div>
                <div class="mt-3" style="font-size: 0.9rem;">
                    <i class="far fa-calendar-alt"></i>
                    {{ $review->getOpenDate() }}
                </div>

                @if (!empty($review->url))
                    <div class="mt-3">
                        <p style="font-size: 0.85rem;">
                            このゲームのレビューを別のサイトでも書いています。<br>
                            そちらもご確認ください。<br>
                            <a href="{{ $review->url }}" target="_blank">{{ $review->url }} <i class="fas fa-sign-out-alt"></i></a>
                        </p>

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
                    <p class="mt-2">{{ nl2br($review->progress) }}</p>
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
    <div class="col-md-6">
        <div class="card card-hgn">
            <div class="card-body">
                <h5 class="card-title">良い点</h5>

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
                    @endempty
                    </div>

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