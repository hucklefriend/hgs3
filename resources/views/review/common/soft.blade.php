<div class="d-flex align-items-stretch">
    <div class="align-self-top p-2">
        @include ('game.common.packageImage', ['imageUrl' => $r->small_image_url])
    </div>
    <div class="align-self-top">
        <div>
            <strong>{{ $r->soft_name }}</strong>
        </div>

        <div class="d-flex align-items-stretch">
            <div>
                <div class="review-point-outline">
                    <div class="review-point text-center">
                        {{ $r->point }}
                    </div>
                </div>
            </div>
            <div style="margin-left: 5px;">
                {{ $r->review_num }}件のレビュー<br>
                <a href="{{ url2('/review/soft') }}/{{ $r->soft_id }}">このゲームのレビューを見る</a>
            </div>
        </div>
    </div>
</div>