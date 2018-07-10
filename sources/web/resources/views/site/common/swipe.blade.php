<div class="site-swipe">
    <div>
    @php $listBannerUrl = list_banner($s) @endphp
    @if (empty($listBannerUrl))
        <div class="no-banner-site-name"><a href="{{ route('サイト詳細', ['site' => $s->id]) }}">{{ $s->name }}</a></div>
    @else
        <p class="mb-1">{{ $s->name }}</p>
        <div class="list-site-banner-outline"><a href="{{ route('サイト詳細', ['site' => $s->id]) }}"><img data-normal="{{ $listBannerUrl }}" class="img-responsive"></a></div>
    @endif
    </div>


    <div class="d-flex flex-wrap site-badge my-3">
        <span class="tag simple">{{ \Hgs3\Constants\Site\MainContents::getText($s->main_contents_id) }}</span>
        @if ($s->rate > 0)
            <span class="tag simple">{{ \Hgs3\Constants\Site\Rate::getText($s->rate) }}</span>
        @endif
        @if ($s->gender != \Hgs3\Constants\Site\Gender::NONE)
            <span class="tag simple">{{ \Hgs3\Constants\Site\Gender::getText($s->gender) }}</span>
        @endif
    </div>

    @if (strlen($s->presentation) > 0)
    <div class="break-word mt-2"><small>{{ e(str_limit($s->presentation, Hgs3\Constants\Site::LIST_PRESENTATION_LENGTH)) }}</small></div>
    @endif

    <div class="mt-4 text-right">
        <a href="{{ route('サイト遷移', ['site' => $s->id]) }}" target="_blank" class="badge badge-pill badge-secondary"><small>サイトへ行く <i class="fas fa-sign-out-alt"></i></small></a>
        <a href="{{ route('サイト詳細', ['site' => $s->id]) }}" class="and-more ml-4"><small>紹介を見る <i class="fas fa-angle-right"></i></small></a>
    </div>
</div>