<div class="card">
    <div class="card-body">
        @if (empty($reviews))
        <div>レビューは投稿していません。</div>
        @else
            @if ($isMyself)
                @foreach ($reviews as $review)
                    @include('review.common.writer', ['review' => $review])
                @endforeach
            @else
                @foreach ($reviews as $review)
                    @include('review.common.normal', ['review' => $review])
                @endforeach
            @endif
            @include('common.pager', ['pager' => $reviews])
        @endif
    </div>
</div>