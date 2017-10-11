<div class="row" style="margin-bottom: 15px;">
    <div class="col-2 text-center">
        <img src="{{ $r->small_image_url }}" class="thumbnail">
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
                    <a href="{{ url('review/detail/') }}/{{ $r->id }}">{{ $r->title }}</a>
                </div>
            </div>
        </div>

        <div>
            <i class="fa fa-thumbs-o-up" aria-hidden="true"></i> {{ $r->good_num }}&nbsp;
            {{ $r->post_date }}
        </div>
    </div>
</div>
