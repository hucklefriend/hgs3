<div class="row" style="margin-bottom: 15px;">
    <div class="col-2">
        <img src="{{ $r->small_image_url }}" class="thumbnail">
    </div>
    <div class="col-10">
        <div class="text-center">
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

        <div>投稿者：<a href="{{ url2('user/profile') }}/{{ $r->user_id }}">{{ $r->user_name }}</a></div>
        <div>投稿日時：{{ $r->post_date }}</div>
    </div>
</div>
