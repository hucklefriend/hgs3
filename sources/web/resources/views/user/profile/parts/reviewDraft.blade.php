<div class="card">
    <div class="card-body">
        @if ($drafts->isEmpty())
        <div>レビューの下書きはありません。</div>
        @else
            @foreach ($drafts as $draft)
                <div class="mb-5">
                    <div class="review-list-title">{{ $draft->soft->name }}</div>
                    <div class="d-flex justify-content-between">
                        <div class="d-flex">
                            <div class="review-list-package-image mr-2">@include ('game.common.packageImage', ['imageUrl' => small_image_url($draft->soft->getImagePackage())])</div>
                            <div>
                                <div class="d-flex">
                                    <div class="review-list-point mr-1">{{ \Hgs3\Constants\Review\Fear::$face[$draft->fear] }}</div>
                                    <div class="review-list-point mr-2">{{ $draft->calcPoint() }}</div>
                                    @if($draft->is_spoiler == 1)
                                        <div>
                                            <span class="badge badge-pill badge-danger">ネタバレ</span>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <p class="mb-0"><small>{{ format_date(strtotime($draft->updated_at)) }} 更新</small></p>
                                </div>
                            </div>
                        </div>
                        <div class="align-self-center">
                            <a href="{{ route('レビュー投稿確認', ['soft' => $draft->soft_id]) }}" class="btn btn-outline-dark border-0 d-block">
                                <button class="btn btn-light btn--icon"><i class="fas fa-angle-right"></i></button>
                            </a>
                        </div>
                    </div>
                </div>

            @endforeach
            @include('common.pager', ['pager' => $drafts])
        @endif
    </div>
</div>