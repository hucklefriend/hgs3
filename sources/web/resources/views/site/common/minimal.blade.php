<div>
    <div><a href="{{ route('サイト詳細', ['site' => $s->id]) }}" class="site_name">{{ $s->name }}</a></div>
    @if (!empty($s->list_banner_url))
        <div class="list_site_banner_outline">
            <a href="{{ route('サイト詳細', ['site' => $s->id]) }}"><img src="{{ $s->list_banner_url }}" class="img-responsive"></a>
        </div>
    @endif
    <div>
        <small>
            <i class="fa fa-user-o" aria-hidden="true"></i>
            <a href="{{ route('プロフィール', ['showId' => $u->show_id]) }}">{{ $u->name }}</a>
            <i class="fa fa-refresh" aria-hidden="true"></i>
            {{ date('Y-m-d H:i', $s->updated_timestamp) }}
            <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
            {{ number_format($s->good_num) }}
            <i class="fa fa-paw" aria-hidden="true"></i>
            {{ number_format($s->out_count) }}
        </small>
    </div>
</div>