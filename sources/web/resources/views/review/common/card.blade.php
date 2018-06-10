<div class="col-12 col-md-6 col-lx-4">
    <div class="card">
        <div class="card-body">
            <div class="review-list-fear">{{ \Hgs3\Constants\Review\Fear::$data[$review->fear] }}</div>
            <div class="review-list-title"><a href="{{ route('レビュー', ['review' => $review->id]) }}">{{ $review->soft->name }}</a></div>
            <div class="d-flex justify-content-between">
                <div class="d-flex">
                    <div class="review-list-package-image mr-2">@include ('game.common.packageImage', ['imageUrl' => small_image_url($review->soft->getImagePackage())])</div>
                    <div>

                        <div class="d-flex">
                            <div class="review-list-point mr-2">{{ $review->calcPoint() }}</div>

                            <div>
                                @isset($review->user)
                                    <p class="mb-0"><small>{{ $review->user->name }} </small></p>
                                @endif
                                <p class="mb-0"><small>{{ format_date(strtotime($review->post_at)) }} 投稿</small></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="align-self-center">
                </div>
            </div>

            <div class="mt-2 text-right">
                @if($review->is_spoiler == 1)
                    <span class="badge badge-pill badge-danger mr-2">ネタバレ注意！</span>
                @endif
                <a href="{{ route('レビュー', ['review' => $review->id]) }}" class="badge badge-pill and-more">レビューを読む</a>
            </div>
        </div>
    </div>
</div>
