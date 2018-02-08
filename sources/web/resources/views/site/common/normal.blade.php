<div>
    <div class="d-flex flex-wrap-reverse">
        <div style="margin-right: 20px;">
            <a href="{{ route('サイト詳細', ['site' => $s->id]) }}" class="site_name">{{ $s->name }}</a>
        </div>
        <div>
            <span class="badge badge-pill badge-secondary">{{ \Hgs3\Constants\Site\MainContents::getText($s->main_contents_id) }}</span>
        @if ($s->rate > 0)
            <span class="badge badge-pill badge-secondary">{{ \Hgs3\Constants\Site\Rate::getText($s->rate) }}</span>
        @endif
        @if ($s->gender != \Hgs3\Constants\Site\Gender::NONE)
            <span class="badge badge-pill badge-secondary">{{ \Hgs3\Constants\Site\Gender::getText($s->gender) }}</span>
        @endif
        </div>
    </div>
    @if (!empty($s->list_banner_url))
        <div class="list-site-banner-outline">
            <a href="{{ route('サイト詳細', ['site' => $s->id]) }}"><img src="{{ $s->list_banner_url }}" class="img-responsive"></a>
        </div>
    @endif
    <div class="site-presentation">{!! nl2br(e($s->presentation)) !!}</div>
    <div><a href="{{ route('サイト遷移', ['site' => $s->id]) }}" target="_blank"><small>{{ $s->url }}</small></a></div>

    <div class="d-flex align-content-start flex-wrap site-info">
        <span>
            @if (!isset($noUser) || !$noUser)
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
            @endif
            <i class="fas fa-redo-alt"></i>
            {{ date('Y-m-d H:i', $s->updated_timestamp) }}
        </span>
    </div>
</div>