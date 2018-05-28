<div class="card">
    <div class="card-body">

@if ($sites->count() <= 0)
        <div>サイトはありません。</div>
@endif

@foreach ($sites as $s)
        <div class="mb-5">
        @include('site.common.normal', ['s' => $s, 'noUser' => true, 'showApprovalStatus' => $isMyself])
        </div>
@endforeach

    </div>
</div>
@if ($isMyself && count($sites) < env('MAX_SITES'))
    <div class="text-center">
        <a href="{{ route('サイト登録') }}" class="btn btn-info">サイトを追加する</a>
    </div>
@endif

