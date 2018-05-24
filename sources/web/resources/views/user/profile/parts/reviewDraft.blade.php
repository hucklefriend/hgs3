<div class="card">
    <div class="card-body">
        @if (empty($drafts))
        <div>レビューの下書きはありません。</div>
        @else
            @foreach ($drafts as $draft)
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <div class="d-flex">
                        <div class="review-point-list mr-2">{{ $draft->calcPoint() }}</div>
                        <div>
                            <div>
                                <div class="package-image-review-list">@include ('game.common.packageImage', ['imageUrl' => small_image_url($draft->soft->getImagePackage())])</div>
                                {{ $draft->soft->name }}
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <a href="{{ route('レビュー投稿確認', ['soft' => $draft->soft_id]) }}" class="btn btn-light btn--icon"><i class="fas fa-angle-right"></i></a>
                </div>
            </div>
            @endforeach
            @include('common.pager', ['pager' => $drafts])
        @endif
    </div>
</div>