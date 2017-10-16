<div class="d-flex align-items-stretch">
    <div class="align-self-top p-2">
        @include ('game.common.package_image', ['imageUrl' => $r->small_image_url])
    </div>
    <div class="align-self-top">
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
                <a href="{{ url2('/review/game') }}/{{ $r->game_id }}">このゲームのレビューを見る</a>
            </div>
        </div>
    </div>
</div>