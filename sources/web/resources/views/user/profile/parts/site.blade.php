@if ($sites->count() <= 0)
<p>サイトはありません。</p>
@endif

@foreach ($sites as $s)
    <div class="mb-5">
    @include('site.common.normal', ['s' => $s, 'noUser' => true, 'showApprovalStatus' => $isMyself])
    </div>
@endforeach

@if ($isMyself && count($sites) < env('MAX_SITES'))
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

