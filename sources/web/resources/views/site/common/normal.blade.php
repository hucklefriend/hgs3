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
            <div class="no-banner-site-name"><a href="{{ route('サイト詳細', ['site' => $s->id]) }}">{{ $s->name }}</a></div>
    @else
        <div>{{ $s->name }}</div>
            <div class="list-site-banner-outline"><a href="{{ route('サイト詳細', ['site' => $s->id]) }}"><img data-normal="{{ $listBannerUrl }}" class="img-responsive"></a></div>
    @endif
    </div>

    <div class="d-flex flex-wrap site-badge my-2">
        <span class="tag simple">{{ \Hgs3\Constants\Site\MainContents::getText($s->main_contents_id) }}</span>
        @if ($s->rate > 0)
            <span class="tag simple">{{ \Hgs3\Constants\Site\Rate::getText($s->rate) }}</span>
        @endif
        @if ($s->gender != \Hgs3\Constants\Site\Gender::NONE)
            <span class="tag simple">{{ \Hgs3\Constants\Site\Gender::getText($s->gender) }}</span>
        @endif
    </div>

    @if (!isset($hidePresentation) || !$hidePresentation)
        <div class="site-presentation mt-2">{{ e(str_limit($s->presentation, Hgs3\Constants\Site::LIST_PRESENTATION_LENGTH)) }}</div>
    @endif

    @if ($s->latest_update_history_date != null)
        <div class="my-3 d-flex">
            <div>
                <div class="badge badge-info"><small>{{ format_date2(strtotime($s->latest_update_history_date)) }}更新</small></div>
            </div>
            <p>{{ $s->latest_update_history }}</p>
        </div>
    @endif

    <div class="site-info mt-3">
        @if (!isset($noUser) || !$noUser)
        <span class="d-inline-block mr-2"><i class="far fa-user"></i> <a href="{{ route('プロフィール', ['showId' => $u->show_id]) }}" class="one-line user-name-link">{{ $u->name }}</a></span>
        @endif
        <span class="d-inline-block mr-2"><span class="good-icon2"><i class="fas fa-thumbs-up"></i> {{ number_format($s->good_num) }}</span>
        <span class="d-inline-block mr-2"><i class="fas fa-paw"></i> {{ number_format($s->out_count) }}</span>
        @if ($s->updated_timestamp > 0)
            <span class="d-inline-block"><i class="fas fa-redo-alt"></i> {{ format_date($s->updated_timestamp) }}</span>
        @endif
    </div>

    <div class="mt-3 text-right">
        <a href="{{ route('サイト遷移', ['site' => $s->id]) }}" class="badge badge-pill badge-secondary mb-4" target="_blank">サイトに行く <i class="fas fa-sign-out-alt"></i></a>
        <a href="{{ route('サイト詳細', ['site' => $s->id]) }}" class="and-more ml-4">詳細を見る <i class="fas fa-angle-right"></i></a>
    </div>
</div>