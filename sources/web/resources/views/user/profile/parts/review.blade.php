<div class="card">
    <div class="card-body">
        @if ($reviews->isEmpty())
        <div>レビューを投稿していません。</div>
        @else
            <div class="row">
            @foreach ($reviews as $review)
                <div class="col-12 col-lg-6">
                    @include('review.common.normal', ['review' => $review])
                </div>
            @endforeach
            </div>

            @include('common.pager', ['pager' => $reviews])
        @endif
    </div>
</div>