<div class="mb-4">
    <h2>自己紹介</h2>
    @if (empty($user->profile))
        <p class="text-muted ml-2"><small>自己紹介を書いていません</small></p>
    @else
    <p class="ml-2">{!! nl2br(e($user->profile)) !!}</p>
    @endif
</div>

<div class="my-4">
    <h2>外部サイト</h2>
    @if ($snsAccounts->isEmpty())
        <p class="ml-2">公開している外部サイトはありません。</p>
    @else
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
    @endif
</div>