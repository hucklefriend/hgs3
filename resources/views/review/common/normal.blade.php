<div class="mb-5 review-list-item">
    <div class="review-list-title">{{ $review->soft->name }}</div>
    <div class="d-flex justify-content-between">
        <div class="d-flex">
            <div class="review-list-package-image medium_image mr-2">{!! medium_image($review->soft->getImagePackage()) !!}</div>

            <div class="d-flex flex-wrap">
                <div class="review-list-point mr-1 mb-2 align-self-center">{{ \Hgs3\Constants\Review\Fear::$face[$review->fear] }}{{ \Hgs3\Constants\Review\Fear::$acronym[$review->fear] }}</div>
                <div class="review-list-point mr-2 mb-2 align-self-center">{{ $review->calcPoint() }}</div>
                @if($review->is_spoiler == 1)
                    <div class="align-self-center mb-2">
                        <span class="badge badge-pill badge-danger">ネタバレ</span>
                    </div>
                @endif
            </div>
        </div>
        <div class="align-self-center">
            <a href="{{ route('レビュー', ['review' => $review->id]) }}" class="btn btn-light btn--icon"><i class="fas fa-angle-right"></i></a>
        </div>
    </div>
</div>

