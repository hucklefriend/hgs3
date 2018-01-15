<section>
    <div class="d-flex align-items-stretch">
        <div class="p-2 align-self-center">
            <div class="review_point_outline">
                <p class="review_point">{{ $review->point }}</p>
            </div>
        </div>
        <div class="p-12 align-self-center">
            @if($review->is_spoiler == 1) <span class="badge badge-pill badge-danger">ネタバレあり！</span> @endif
            <div class="break_word" style="width: 100%;">
                <h5>
                    <a href="{{ url2('eview/detail') }}/{{ $review->id }}">{{ $review->title }}</a>
                </h5>
            </div>
            <div>
                <i class="fa fa-user" aria-hidden="true"></i>&nbsp;<a href="{{ url2('user/profile') }}/{{ $writer->id }}">{{ $writer->name }}</a>
                {{ $review->post_at }}
            </div>
        </div>
    </div>
</section>