<div class="d-flex justify-content-between align-items-center">
    <div>
        <div class="mb-1">
            @if($review->is_spoiler == 1)
                <span class="badge badge-pill badge-danger">ネタバレあり！</span>
            @endif
        </div>
        <div class="d-flex">
            <div class="review-point-list mr-2">{{ $review->calcPoint() }}</div>
            <div>
                <div>
                    <div class="package-image-review-list">@include ('game.common.packageImage', ['imageUrl' => small_image_url($review->soft->getImagePackage())])</div>
                    {{ $review->soft->name }}
                </div>
                <div class="d-flex flex-wrap mt-2">
                    <span class="mr-3"><i class="far fa-thumbs-up"></i> {{ number_format($review->good_num) }}</span>
                    <span><i class="far fa-calendar-alt"></i> {{ $review->getOpenDate() }}</span>
                </div>
            </div>
        </div>
    </div>
    <div>
        <a href="{{ route('レビュー', ['review' => $review->id]) }}" class="btn btn-light btn--icon"><i class="fas fa-angle-right"></i></a>
    </div>
</div>
