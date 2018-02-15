@switch ($shopId)
    @case (\Hgs3\Constants\Game\Shop::AMAZON)
    <a href="{{ $shopUrl }}" target="_blank"><img src="{{ url('img/assocbutt_or_detail._V371070159_.png') }}" style="max-width:100%;"></a>
    @break
    @default
    {!! \Hgs3\Constants\Game\Shop::getMark($shopId) !!}<a href="{{ $shopUrl }}" target="_blank">{{ \Hgs3\Constants\Game\Shop::getName($shopId) }}</a>
    @break
@endswitch