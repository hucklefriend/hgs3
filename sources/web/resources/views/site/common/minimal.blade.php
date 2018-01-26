@php
    if (!isset($noUser)) {
        $noUser = false;
    }
@endphp
<div>
    <div><a href="{{ route('サイト詳細', ['site' => $s->id]) }}" class="site_name">{{ $s->name }}</a></div>
    @if (!empty($s->list_banner_url))
        <div class="list_site_banner_outline">
            <a href="{{ route('サイト詳細', ['site' => $s->id]) }}"><img src="{{ $s->list_banner_url }}" class="img-responsive"></a>
        </div>
    @endif
    @if (!$noUser)
    <div>
        <i class="fa fa-user-o" aria-hidden="true"></i>
        <a href="{{ route('プロフィール', ['showId' => $s->show_id]) }}">{{ $s->user_name }}</a>
    </div>
    @endif
</div>