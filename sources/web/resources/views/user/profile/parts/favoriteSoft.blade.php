@if ($favoriteSofts->count() <= 0)
    お気に入りゲームはありません。
@endif
@foreach ($favoriteSofts as $fg)
    @isset($softs[$fg->soft_id])
        <a href="{{ route('ゲーム詳細', ['soft' => $fg->soft_id]) }}">
            {{ $softs[$fg->soft_id]->name }}
        </a>
        @if (!$loop->last) <hr> @endif
    @endisset
@endforeach
{{ $favoriteSofts->links('vendor.pagination.simple-bootstrap-4') }}