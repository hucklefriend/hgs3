<div class="site_parts">
    <h5>{{ $s->name }}</h5>
    <div><a href="{{ $s->url }}" target="_blank">{{ $s->url }}</a></div>
    <div class="site_presentation">{{ mb_strimwidth($s->presentation, 0, 100, '...') }}</div>
    <div class="text-right"><a href="{{ url('site/detail') }}/{{ $s->id }}">このサイトの詳しい情報を見る</a></div>
</div>
