<span class="align-middle">
<a href="{{ route('プロフィール', ['showId' => $u->show_id]) }}">{{ $u->name }}さん</a>
{{ \Hgs3\Constants\FollowStatus::getIcon($followStatus ?? \Hgs3\Constants\FollowStatus::NONE) }}
</span>