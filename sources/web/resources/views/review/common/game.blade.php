<div class="row" style="margin-bottom: 15px;">
    <div class="col-2">
        @include ('game.common.package_image', ['imageUrl' => $r->small_image_url])
    </div>
    <div class="col-10">
        <div>
            <strong>{{ $r->game_name }}</strong>
        </div>
        <div class="d-flex align-items-stretch">
            <div>
                <div class="review_point_outline">
                    <div class="review_point text-center">
                        {{ $r->point }}
                    </div>
                </div>
            </div>
            <div style="margin-left: 5px;">
                {{ $r->review_num }}件のレビュー<br>
                <a href="{{ url2('/review/soft') }}/{{ $r->game_id }}">このゲームのレビューを見る</a>
            </div>
        </div>

        <div class="row" style="display:none">
            <div class="col-2">
                <div class="review_point_outline">
                    <div class="review_point text-center">
                        {{ $r->point }}
                    </div>
                </div>
            </div>
            <div class="col-10">
                {{ $r->review_num }}件のレビュー<br>
                <a href="{{ url2('/review/soft') }}/{{ $r->game_id }}">このゲームのレビューを見る</a>
            </div>
        </div>
    </div>
</div>
