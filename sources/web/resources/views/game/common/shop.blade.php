@switch ($shopId)
    @case (\Hgs3\Constants\Game\Shop::AMAZON)
    <a href="{{ $itemUrl }}" target="_blank"><img src="{{ url('img/assocbutt_or_detail._V371070159_.png') }}"></a>
    @break
@endswitch