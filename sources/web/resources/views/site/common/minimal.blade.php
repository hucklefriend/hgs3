<div>
    <div><a href="{{ route('サイト詳細', ['site' => $s->id]) }}" class="site_name">{{ $s->name }}</a></div>
    @if (!empty($s->list_banner_url))
    <div class="list-site-banner-outline">
        <a href="{{ route('サイト詳細', ['site' => $s->id]) }}"><img src="{{ $s->list_banner_url }}" class="img-responsive"></a>
    </div>
    @endif
    <div class="d-flex align-content-start flex-wrap site-info">
        <span>
            <i class="far fa-user"></i>
            <a href="{{ route('プロフィール', ['showId' => $u->show_id]) }}">{{ $u->name }}</a>
        </span>
        <span>
            <span class="good-icon2"><i class="far fa-thumbs-up"></i></span>
            {{ number_format($s->good_num) }}
        </span>
        <span>
            <i class="fas fa-paw"></i>
            {{ number_format($s->out_count) }}
        </span>
        <span>
            <i class="fas fa-redo-alt"></i>
            {{ date('Y-m-d H:i', $s->updated_timestamp) }}
        </span>
    </div>
</div>