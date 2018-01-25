@foreach ($sites as $s)
    <div>
    @if ($s->approval_status == \Hgs3\Constants\Site\ApprovalStatus::OK)
        <span class="badge badge-success">{{ \Hgs3\Constants\Site\ApprovalStatus::getText($s->approval_status) }}</span>
    @elseif ($s->approval_status == \Hgs3\Constants\Site\ApprovalStatus::REJECT)
        <span class="badge badge-danger">{{ \Hgs3\Constants\Site\ApprovalStatus::getText($s->approval_status) }}</span>
    @elseif ($s->approval_status == \Hgs3\Constants\Site\ApprovalStatus::WAIT)
        <span class="badge badge-secondary">{{ \Hgs3\Constants\Site\ApprovalStatus::getText($s->approval_status) }}</span>
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
                <a href="{{ route('サイト登録') }}" class="btn btn-outline-info btn-block">サイトを追加する</a>
            </div>
            <div class="col-6">
                <a href="{{ route('サイト引継選択') }}" class="btn btn-outline-info btn-block">H.G.S.から引き継ぎ</a>
            </div>
        </div>
    @else
    <div>
        <button class="btn btn-link btn-block">
            <a href="{{ route('サイト登録') }}" class="btn btn-outline-info btn-block">サイトを追加する</a>
        </button>
    </div>
    @endif
@endif

