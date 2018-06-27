<div class="card">
    <div class="card-body">
        <h4 class="card-title">属性</h4>

        @if (empty($attributes))
            <p class="text-muted">属性を設定していません。</p>
        @else
            <div>
                @foreach ($attributes as $attr)
                    <div class="user-attribute">{{ \Hgs3\Constants\User\Attribute::$text[$attr] }}</div>
                @endforeach
            </div>
        @endif
    </div>
</div>
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
                    <a href="{{ $sns->getUrl() }}" class="badge badge-pill badge-secondary" target="_blank">
                        {{ \Hgs3\Constants\SocialSite::getIcon($sns->social_site_id) }}
                        {{ $sns->name }}
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                </div>
            @endforeach
            </div>
        @endif
    </div>
</div>
