<div class="card">
    <div class="card-body">

@if ($goodSites->count() == 0)
    いいねしたサイトはありません。
@endif
@foreach ($goodSites as $fs)
    @isset($sites[$fs->site_id])
        @php $s = $sites[$fs->site_id]; @endphp
    <div class="mb-5">
    @include('site.common.normal', ['s' => $s, 'u' => $users[$s->user_id]])
    </div>
    @endif
@endforeach

@include('common.pager', ['pager' => $goodSites])
    </div>
</div>