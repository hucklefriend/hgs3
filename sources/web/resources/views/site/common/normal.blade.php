<div class="site-normal">
    <div>
        @if (isset($showApprovalStatus) && $showApprovalStatus)
            @if ($s->approval_status == \Hgs3\Constants\Site\ApprovalStatus::OK)
                <span class="badge badge-success">{{ \Hgs3\Constants\Site\ApprovalStatus::getText($s->approval_status) }}</span>
            @elseif ($s->approval_status == \Hgs3\Constants\Site\ApprovalStatus::REJECT)
                <span class="badge badge-danger">{{ \Hgs3\Constants\Site\ApprovalStatus::getText($s->approval_status) }}</span>
            @elseif ($s->approval_status == \Hgs3\Constants\Site\ApprovalStatus::WAIT)
                <span class="badge badge-secondary">{{ \Hgs3\Constants\Site\ApprovalStatus::getText($s->approval_status) }}</span>
            @elseif ($s->approval_status == \Hgs3\Constants\Site\ApprovalStatus::DRAFT)
                <span class="badge badge-secondary">{{ \Hgs3\Constants\Site\ApprovalStatus::getText($s->approval_status) }}</span>
            @endif
        @endif
    </div>
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

    @if (!isset($hidePresentation) || !$hidePresentation)
        <div class="site-presentation mt-2">{{ e(str_limit($s->presentation, 150)) }}</div>
    @endif

    <div class="d-flex flex-wrap site-badge my-3">
        <span class="tag simple">{{ \Hgs3\Constants\Site\MainContents::getText($s->main_contents_id) }}</span>
        @if ($s->rate > 0)
            <span class="tag simple">{{ \Hgs3\Constants\Site\Rate::getText($s->rate) }}</span>
        @endif
        @if ($s->gender != \Hgs3\Constants\Site\Gender::NONE)
            <span class="tag simple">{{ \Hgs3\Constants\Site\Gender::getText($s->gender) }}</span>
        @endif
    </div>

    <div class="d-flex align-content-start flex-wrap site-info">
        @if (!isset($noUser) || !$noUser)
        <span><i class="far fa-user"></i> <a href="{{ route('プロフィール', ['showId' => $u->show_id]) }}">{{ $u->name }}</a></span>
        @endif
        <span><span class="good-icon2"><i class="far fa-thumbs-up"></i></span> {{ number_format($s->good_num) }}</span>
        <span><i class="fas fa-paw"></i> {{ number_format($s->out_count) }}</span>
        @if ($s->updated_timestamp > 0)
            <span><i class="fas fa-redo-alt"></i> {{ format_date($s->updated_timestamp) }}</span>
        @endif
    </div>
    <div class="mt-2"><a href="{{ route('サイト遷移', ['site' => $s->id]) }}" target="_blank"><small>{{ $s->url }}</small></a></div>
</div>