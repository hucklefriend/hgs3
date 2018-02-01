<div>
    <div>
        <a href="{{ route('サイト詳細', ['site' => $s->id]) }}" class="site_name">{{ $s->name }}</a>
        <br class="d-sm-none">
            <span class="badge badge-pill badge-success">{{ \Hgs3\Constants\Site\MainContents::getText($s->main_contents_id) }}</span>
            @if ($s->rate > 0)
                <span class="badge badge-pill badge-success">{{ \Hgs3\Constants\Site\Rate::getText($s->rate) }}</span>
            @endif
            @if ($s->gender != \Hgs3\Constants\Site\Gender::NONE)
                <span class="badge badge-pill badge-success">{{ \Hgs3\Constants\Site\Gender::getText($s->gender) }}</span>
            @endif
    </div>
    @if (!empty($s->list_banner_url))
        <div class="list-site-banner-outline">
            <a href="{{ route('サイト詳細', ['site' => $s->id]) }}"><img src="{{ $s->list_banner_url }}" class="img-responsive"></a>
        </div>
    @endif
    <div class="site-presentation"><small>{!! nl2br(e($s->presentation)) !!}</small></div>
    <div><a href="{{ route('サイト遷移', ['site' => $s->id]) }}" target="_blank">{{ $s->url }}</a></div>

    <div class="d-flex align-content-start flex-wrap site-info">
        <span>
            @if (!isset($noUser) || !$noUser)
            <i class="far fa-user"></i>
            <a href="{{ route('プロフィール', ['showId' => $u->show_id]) }}">{{ $u->name }}</a>
        </span>
        <span>
            @endif
            <i class="fas fa-redo-alt"></i>
            {{ date('Y-m-d H:i', $s->updated_timestamp) }}
        </span>
        <span>
            <span class="good-icon2"><i class="far fa-thumbs-up"></i></span>
            {{ number_format($s->good_num) }}
        </span>
        <span>
            <i class="fas fa-paw"></i>
            {{ number_format($s->out_count) }}
        </span>
    </div>
</div>