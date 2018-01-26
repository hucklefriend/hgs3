@php
if (!isset($noUser)) {
    $noUser = false;
}

if (!$noUser) {
    $u = $users[$s->user_id];
}

@endphp
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
        <div class="list_site_banner_outline">
            <a href="{{ route('サイト詳細', ['site' => $s->id]) }}"><img src="{{ $s->list_banner_url }}" class="img-responsive"></a>
        </div>
    @endif
    <div class="site_presentation"><small>{{ mb_strimwidth($s->presentation, 0, 200, '...') }}</small></div>
    <div><a href="{{ route('サイト遷移', ['site' => $s->id]) }}" target="_blank">{{ $s->url }}</a></div>
    @if (!$noUser)
    <div>
        <small>
            <i class="fa fa-user-o" aria-hidden="true"></i>
            <a href="{{ route('プロフィール', ['showId' => $u->show_id]) }}">{{ $u->name }}</a>
            <i class="fa fa-refresh" aria-hidden="true"></i>
            {{ date('Y-m-d H:i', $s->updated_timestamp) }}
            <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
            {{ number_format($s->good_num) }}
            <i class="fa fa-sign-out" aria-hidden="true"></i>
            {{ number_format($s->out_count) }}
            <i class="fa fa-sign-in" aria-hidden="true"></i>
            {{ number_format($s->in_count) }}
        </small>
    </div>
    @endif
</div>