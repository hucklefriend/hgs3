    <div>
        <h5>{{ $s->name }}</h5>
        <div><a href="{{ $s->url }}" target="_blank">{{ $s->url }}</a></div>
        <div><pre>{{ mb_strimwidth($s->presentation, 0, 100, '...') }}</pre></div>
        <div>→ <a href="{{ url('site/detail') }}/{{ $s->id }}">サイトの詳細情報</a></div>
        <div>管理人：<a href="{{ url('user/profile') }}/{{ $s->user_id }}">{{ un($users, $s->user_id) }}</a></div>
    </div>
