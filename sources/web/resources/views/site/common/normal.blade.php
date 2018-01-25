@php
if (!isset($noUser)) {
    $noUser = false;
}

if (!$noUser) {
    $u = $users[$s->user_id];
}

@endphp
<div>
    <h5><a href="{{ route('サイト詳細', ['site' => $s->id]) }}">{{ $s->name }}</a></h5>
    @if (!empty($s->list_banner_url))
        <div class="list_site_banner_outline">
            <a href="{{ route('サイト詳細', ['site' => $s->id]) }}"><img src="{{ $s->list_banner_url }}" class="img-responsive"></a>
        </div>
    @endif
    <div><a href="{{ route('サイト遷移', ['site' => $s->id]) }}" target="_blank">{{ $s->url }}</a></div>
    <div class="site_presentation"><small>{{ mb_strimwidth($s->presentation, 0, 100, '...') }}</small></div>
    @if (!$noUser)
    <div>
        <i class="fa fa-user-o" aria-hidden="true"></i>
        <a href="{{ route('プロフィール', ['showId' => $u->show_id]) }}">{{ $u->name }}</a>
    </div>
    @endif
</div>