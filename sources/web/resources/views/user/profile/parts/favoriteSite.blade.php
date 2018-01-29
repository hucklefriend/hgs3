@if ($favoriteSites->count() == 0)
    お気に入りサイトはありません。
@endif
@foreach ($favoriteSites as $fs)
    @isset($sites[$fs->site_id])
        @php $s = $sites[$fs->site_id]; @endphp
    @include('site.common.normal', ['s' => $s, 'u' => $users[$s->user_id]])
    @endif
    @if (!$loop->last) <hr> @endif
@endforeach

{{ $favoriteSites->links('vendor.pagination.simple-bootstrap-4') }}
