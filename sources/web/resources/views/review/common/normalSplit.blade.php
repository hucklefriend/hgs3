<div class="d-flex align-items-stretch">
    <div class="align-self-top p-2">
        @include ('game.common.package_image', ['imageUrl' => $gamePackage->small_image_url])
    </div>
    <div class="align-self-top">
        <div>
            <strong>{{ $gamePackage->name }}</strong>
        </div>

        <div class="d-flex align-items-stretch">
            <div>
                <div class="review_point_outline">
                    <div class="review_point text-center">
                        {{ $review->point }}
                    </div>
                </div>
            </div>
            <div>
                <div class="review_title" style="margin-left: 10px;">
                    @if($review->is_spoiler == 1)
                        <span class="badge badge-pill badge-danger">ネタバレあり！</span><br>
                    @endif
                    <a href="{{ url('review/detail/') }}/{{ $review->id }}" class="d-none d-sm-block">{{ $review->title }}</a>
                    <a href="{{ url('review/detail/') }}/{{ $review->id }}" class="d-sm-none">{{ str_limit($review->title, 30) }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div>
    <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>&nbsp;{{ $review->good_num }}&nbsp;
    <i class="fa fa-user" aria-hidden="true"></i>&nbsp;<a href="{{ url2('user/profile') }}/{{ $writer->id }}">{{ $writer->name }}</a>
    <i class="fa fa-clock-o" aria-hidden="true"></i> {{ $review->post_date }}
</div>