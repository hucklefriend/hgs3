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
    @php $listBannerUrl = list_banner($s); @endphp
    @if (empty($listBannerUrl))
        <div class="no-banner-site-name">
            <a href="{{ route('サイト詳細', ['site' => $s->id]) }}" class="site_name">{{ $s->name }}</a>
        </div>
    @else
        <div>
            <a href="{{ route('サイト詳細', ['site' => $s->id]) }}" class="site_name">{{ $s->name }}</a>
        </div>
        <div class="list-site-banner-outline">
            <a href="{{ route('サイト詳細', ['site' => $s->id]) }}"><img src="{{ $listBannerUrl }}" class="img-responsive"></a>
        </div>
    @endif
    </div>

    @if (!isset($hidePresentation) || !$hidePresentation)
        <div class="site-presentation mt-2">{{ e(str_limit($s->presentation, Hgs3\Constants\Site::LIST_PRESENTATION_LENGTH)) }}</div>
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

    <div class="site-info">
        @if (!isset($noUser) || !$noUser)
        <span class="d-inline-block"><i class="far fa-user"></i> <a href="{{ route('プロフィール', ['showId' => $u->show_id]) }}" class="one-line user-name-link">{{ $u->name }}</a></span>
        @endif
        <span class="d-inline-block"><span class="good-icon2"><i class="far fa-thumbs-up"></i></span> {{ number_format($s->good_num) }}</span>
        <span class="d-inline-block"><i class="fas fa-paw"></i> {{ number_format($s->out_count) }}</span>
        @if ($s->updated_timestamp > 0)
            <span class="d-inline-block"><i class="fas fa-redo-alt"></i> {{ format_date($s->updated_timestamp) }}</span>
        @endif
    </div>
    <div class="mt-3 text-center"><a href="{{ route('サイト遷移', ['site' => $s->id]) }}" class="badge badge-pill badge-secondary" target="_blank">サイトへ行く <i class="fas fa-sign-out-alt"></i></a></div>
</div>