@foreach ($timelines as $tl)
    <div>{{ date('Y-m-d H:i:s', $tl['time']) }}</div>
    <p>{!!  $tl['text'] !!}</p>
    <hr>
@endforeach
{{ $pager->links('vendor.pagination.simple-bootstrap-4') }}