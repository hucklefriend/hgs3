@switch ($shopId)
    @case (\Hgs3\Constants\Game\Shop::AMAZON)
    <a href="{{ $shopUrl }}" target="_blank"><img src="{{ url('img/assocbutt_or_detail._V371070159_.png') }}" style="max-width:100%;"></a>
    @break
@endswitch