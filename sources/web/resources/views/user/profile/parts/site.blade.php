@foreach ($sites as $s)
    <div>
    @if ($s->approval_status == \Hgs3\Constants\Site\ApprovalStatus::OK)
        <span class="badge badge-success">公開中</span>
    @elseif ($s->approval_status == \Hgs3\Constants\Site\ApprovalStatus::REJECT)
        <span class="badge badge-danger">登録NG</span>
    @elseif ($s->approval_status == \Hgs3\Constants\Site\ApprovalStatus::WAIT)
        <span class="badge badge-secondary">承認待ち</span>
    @endif
    </div>
    @include('site.common.normal', ['s' => $s, 'noUser' => true])
    @if (!$loop->last) <hr> @endif
@endforeach

@if ($isMyself && count($sites) < env('MAX_SITES'))
    @if (count($sites) > 0) <hr> @endif
    @if ($hasHgs2Site)
        <div class="row">
            <div class="col-6">
                <button class="btn btn-link btn-block">
                    <a href="{{ url2('user/site_manage/add') }}">サイトを追加する</a>
                </button>
            </div>
            <div class="col-6">
                <button class="btn btn-link btn-block">
                    <a href="{{ url2('user/site_manage/takeover') }}">H.G.S.から引き継ぎ</a>
                </button>
            </div>
        </div>
    @else
    <div>
        <button class="btn btn-link btn-block">
            <a href="{{ url2('user/site_manage/add') }}">サイトを追加する</a>
        </button>
    </div>
    @endif
@endif

