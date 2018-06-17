<div class="card">
    <div class="card-body">
        @if ($reviews->isEmpty())
        <div>レビューを投稿していません。</div>
        @else
            @foreach ($reviews as $review)
                @include('review.common.normal', ['review' => $review])
            @endforeach
            @include('common.pager', ['pager' => $reviews])
        @endif
    </div>
</div>