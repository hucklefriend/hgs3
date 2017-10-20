@foreach ($timelines as $tl)
    <div>{{ date('Y-m-d H:i:s', intval($tl['time'])) }}</div>
    <p>{!!  $tl['text'] !!}</p>
    <hr>
@endforeach

@if ($hasNext)
    <div>続きを読み込むようにしたい</div>
@endif