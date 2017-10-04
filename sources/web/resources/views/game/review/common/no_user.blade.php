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
                {{ $r->review_num }}件のレビュー<br>
                <a href="{{ url2('/game/review/soft') }}/{{ $r->game_id }}">このゲームのレビューを見る</a>
            </div>
        </div>
    </div>
</div>
