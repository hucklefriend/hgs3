@if ($favoriteSites->count() == 0)
    お気に入りサイトはありません。
@endif
@foreach ($favoriteSites as $fs)
    @isset($sites[$fs->site_id])
        @php $s = $sites[$fs->site_id]; @endphp
    <div class="mb-5">
    @include('site.common.normal', ['s' => $s, 'u' => $users[$s->user_id]])
    </div>
    @endif
@endforeach

@include('common.pager', ['pager' => $favoriteSites])
