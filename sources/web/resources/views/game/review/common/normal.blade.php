<div class="row" style="margin-bottom: 15px;">
    <div class="col-2 text-center">
        @include ('game.common.package_image', ['imageUrl' => $r->small_image_url])
    </div>
    <div class="col-10">
        <div>
            <strong>{{ $r->game_name }}</strong>
        </div>

        <div class="row">
            <div class="col-2">
                <div class="review_point text-center">
                    {{ $r->point }}
                </div>
            </div>
            <div class="col-10">
                <div class="review_title">
                    <a href="{{ url('game/review/detail/') }}/{{ $r->id }}">{{ $r->title }}</a>
                </div>
            </div>
        </div>

        <div>
            @if ($showLastMonthGood)
                <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>&nbsp;{{ $r->latest_good_num }}({{ $r->good_num }})&nbsp;
            @else
                <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>&nbsp;{{ $r->good_num }}&nbsp;
            @endif
            <i class="fa fa-user" aria-hidden="true"></i>&nbsp;<a href="{{ url2('user/profile') }}/{{ $r->user_id }}">{{ $r->user_name }}</a><br>
            {{ $r->post_date }}
        </div>
    </div>
</div>
