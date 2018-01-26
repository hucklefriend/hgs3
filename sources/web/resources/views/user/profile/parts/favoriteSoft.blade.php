@foreach ($favoriteSofts as $fg)
    @isset($softs[$fg->soft_id])
        <a href="{{ url2('game/soft/' . $fg->soft_id) }}">
            {{ hv($softs, $fg->soft_id) }}
        </a>
        @if (!$loop->last) <hr> @endif
    @endisset
@endforeach
<br>
{{ $favoriteSofts->links('vendor.pagination.simple-bootstrap-4') }}