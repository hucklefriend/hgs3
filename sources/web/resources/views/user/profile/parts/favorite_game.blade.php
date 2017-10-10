@foreach ($favGames as $fg)
    @isset($games[$fg->game_id])
        <a href="{{ url2('game/soft') }}/{{ $fg->game_id }}">
            {{ get_hash($games, $fg->game_id) }}
        </a>
        @if (!$loop->last) <hr> @endif
    @endisset
@endforeach
<br>
{{ $favGames->links('vendor.pagination.simple-bootstrap-4') }}