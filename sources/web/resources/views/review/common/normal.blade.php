<div>



</div>



<div class="d-flex align-items-stretch">
    <div class="align-self-top p-2">
        @include ('game.common.packageImage', ['imageUrl' => $r->small_image_url])
    </div>
    <div class="align-self-top">
        <div>
            <strong>{{ $r->package_name }}</strong>
        </div>

        <div class="d-flex align-items-stretch">
            <div>
                <div class="review-point-outline">
                    <div class="review-point text-center">
                        {{ $r->point }}
                    </div>
                </div>
            </div>
            <div>
                <div class="review-title" style="margin-left: 10px;">
                    @if($r->is_spoiler == 1)
                        <span class="badge badge-pill badge-danger">ネタバレあり！</span><br>
                    @endif
                    <a href="{{ url('review/detail/') }}/{{ $r->id }}" class="d-none d-sm-block">{{ $r->title }}</a>
                    <a href="{{ url('review/detail/') }}/{{ $r->id }}" class="d-sm-none">{{ str_limit($r->title, 30) }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div>
    @if ($showLastMonthGood)
        <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>&nbsp;{{ $r->latest_good_num }}({{ $r->good_num }})&nbsp;
    @else
        <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>&nbsp;{{ $r->good_num }}&nbsp;
    @endif
    <i class="fa fa-user" aria-hidden="true"></i>&nbsp;<a href="{{ url2('user/profile') }}/{{ $r->user_id }}">{{ $r->user_name }}</a>
        <i class="fa fa-clock-o" aria-hidden="true"></i> {{ $r->post_at }}
</div>