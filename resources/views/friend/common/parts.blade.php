<div class="card user-card">
    <div class="card-body">
        <div class="mb-3 d-flex">
            <img src="{{ user_icon_url($user, true) }}">
            <p class="d-inline-block lead">
                {{ $user->name }}
                @isset($mutual[$user->id])
                    <span class="mutual-follow-icon ml-2"><small><i class="far fa-handshake"></i></small></span>
                @endisset
            </p>
        </div>
        @if (!empty($attributes))
            <div class="my-2">
                @foreach ($attributes as $attr)
                    <div class="user-attribute">{{ \Hgs3\Constants\User\Attribute::$text[$attr] }}</div>
                @endforeach
            </div>
        @endif
        @if (!empty($user->profile))
            <p><small>{!! nl2br(e(str_limit($user->profile, 200))) !!}</small></p>
        @endif
        @if ($sns->isNotEmpty())
            <div class="my-2">
                @foreach ($sns as $socialSite)
                    <a href="{{ $socialSite->getUrl() }}" class="mr-2 mb-2">{{ \Hgs3\Constants\SocialSite::getIconAndName($socialSite->social_site_id) }} <i class="fas fa-sign-out-alt"></i></a>
                @endforeach
            </div>
        @endif

        <div class="text-right">
            <a href="{{ route('プロフィール', ['showId' => $user->show_id]) }}" class="and-more">プロフィールを見る <i class="fas fa-angle-right"></i></a>
        </div>
    </div>
</div>
