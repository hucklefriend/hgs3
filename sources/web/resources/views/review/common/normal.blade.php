<div class="mb-5">
    @if($review->is_spoiler == 1)
    <div><span class="badge badge-pill badge-danger">ネタバレ</span></div>
    @endif
    <div class="review-list-title"><a href="{{ route('レビュー', ['review' => $review->id]) }}">{{ $review->soft->name }}</a></div>
    <div class="d-flex justify-content-between">
        <div class="d-flex">
            <div class="review-list-package-image mr-2">@include ('game.common.packageImage', ['imageUrl' => small_image_url($review->soft->getImagePackage())])</div>
            <div>
                <div class="review-list-fear">{{ \Hgs3\Constants\Review\Fear::$data[$review->fear] }}</div>
                <div class="d-flex">
                    <div class="review-list-point mr-2">{{ $review->calcPoint() }}</div>

                    <div>
                    @isset($review->user)
                        <p class="mb-0 mr-2"><small><i class="fas fa-user"></i>&nbsp;{{ $review->user->name }}</small></p>
                    @endif
                        <p class="mb-0"><small><i class="fas fa-calendar-alt"></i>&nbsp;{{ format_date(strtotime($review->post_at)) }}</small></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="align-self-center">
            <a href="{{ route('レビュー', ['review' => $review->id]) }}" class="btn btn-outline-dark border-0 d-block">
                <button class="btn btn-light btn--icon"><i class="fas fa-angle-right"></i></button>
            </a>
        </div>
    </div>
</div>

