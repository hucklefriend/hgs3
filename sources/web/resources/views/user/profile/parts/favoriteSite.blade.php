@foreach ($favSites as $fs)
    @isset($sites[$fs->site_id])
    @include('site.common.normal', ['s' => $sites[$fs->site_id], 'noUser' => false])
    @endif
    @if (!$loop->last) <hr> @endif
@endforeach

<hr>
{{ $favSites->links('vendor.pagination.simple-bootstrap-4') }}
