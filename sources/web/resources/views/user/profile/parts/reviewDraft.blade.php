<div class="card">
    <div class="card-body">
        @if ($drafts->isEmpty())
        <div>レビューの下書きはありません。</div>
        @else
            <div class="row">
            @foreach ($drafts as $draft)
                <div class="col-12 col-lg-6">
                    <div class="mb-5 review-list-item">
                        <div class="review-list-title">{{ $draft->soft->name }}</div>
                        <div class="d-flex justify-content-between">
                            <div class="d-flex">
                                <div class="review-list-package-image medium_image mr-2">{!! medium_image($draft->soft->getImagePackage()) !!}</div>

                                <div class="d-flex flex-wrap">
                                    <div class="review-list-point mr-1 mb-2 align-self-center">{{ \Hgs3\Constants\Review\Fear::$face[$draft->fear] }}{{ \Hgs3\Constants\Review\Fear::$acronym[$draft->fear] }}</div>
                                    <div class="review-list-point mr-2 mb-2 align-self-center">{{ $draft->calcPoint() }}</div>
                                </div>
                            </div>
                            <div class="align-self-center">
                                <a href="{{ route('レビュー投稿確認', ['soft' => $draft->soft_id]) }}" class="btn btn-outline-dark border-0 d-block">
                                    <button class="btn btn-light btn--icon"><i class="fas fa-pencil-alt"></i></button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
            @include('common.pager', ['pager' => $drafts])
        @endif
    </div>
</div>