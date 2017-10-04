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
    <i class="fa fa-thumbs-o-up" aria-hidden="true"></i> {{ $r->good_num }}&nbsp;
    <i class="fa fa-user" aria-hidden="true"></i><a href="{{ url2('user/profile') }}/{{ $r->user_id }}">{{ $r->user_name }}</a><br>
    {{ $r->post_date }}
</div>
