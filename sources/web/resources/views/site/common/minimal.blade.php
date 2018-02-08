<div>
    <div><a href="{{ route('サイト詳細', ['site' => $s->id]) }}" class="site_name">{{ $s->name }}</a></div>
    @if (!empty($s->list_banner_url))
    <div class="list-site-banner-outline">
        <a href="{{ route('サイト詳細', ['site' => $s->id]) }}"><img src="{{ $s->list_banner_url }}" class="img-responsive"></a>
    </div>
    @endif
</div>