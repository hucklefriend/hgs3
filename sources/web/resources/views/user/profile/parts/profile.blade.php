<div class="card">
    <div class="card-body">
        <h4 class="card-title">自己紹介</h4>

        @if (empty($user->profile))
            <p class="text-muted">自己紹介を書いていません</p>
        @else
            <p>{!! nl2br(e($user->profile)) !!}</p>
        @endif
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h4 class="card-title">外部サイト</h4>

        @if ($snsAccounts->isEmpty())
            <p class="ml-2">公開している外部サイトはありません。</p>
        @else
            <div>
            @foreach ($snsAccounts as $sns)
                <div>
                    <a href="{{ $sns->getUrl() }}" class="btn btn-outline-dark border-0 d-block">
                        <div class="d-flex justify-content-between">
                            <div class="align-self-center">
                                {{ \Hgs3\Constants\SocialSite::getIcon($sns->social_site_id) }}
                                {{ $sns->name }}
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-angle-right"></i>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
            </div>
        @endif
    </div>
</div>
