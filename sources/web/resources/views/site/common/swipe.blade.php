<div class="site-swipe">
    <div>
    @if (empty($s->list_banner_url))
        <div class="no-banner-site-name">
            <a href="{{ route('サイト詳細', ['site' => $s->id]) }}" class="site_name">{{ $s->name }}</a>
        </div>
    @else
        <div>
            <a href="{{ route('サイト詳細', ['site' => $s->id]) }}" class="site_name">{{ $s->name }}</a>
        </div>
        <div class="list-site-banner-outline">
            <a href="{{ route('サイト詳細', ['site' => $s->id]) }}"><img src="{{ $s->list_banner_url }}" class="img-responsive"></a>
        </div>
    @endif
    </div>
    <div class="mt-2 mb-2"><a href="{{ route('サイト遷移', ['site' => $s->id]) }}" target="_blank"><small>{{ $s->url }}</small></a></div>

    @if (strlen($s->presentation) > 0)
    <div class="break-word mt-2"><small>{{ e(str_limit($s->presentation, 150)) }}</small></div>
    @endif
</div>