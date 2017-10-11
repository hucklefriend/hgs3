@php
if (!isset($noUser))
    $noUser = false;
@endphp
<div>
    <h5><a href="{{ url('site/detail') }}/{{ $s->id }}">{{ $s->name }}</a></h5>
    <div class="d-sm-none">
        <img src="{{ url2('img/banner/test/200x40.gif') }}">
    </div>
    <div class="d-none d-sm-block">
        <img src="{{ url2('img/banner/test/300x100.png') }}" style="width: 100%;max-width:300px;">
    </div>
    <div><a href="{{ $s->url }}" target="_blank">{{ $s->url }}</a></div>
    <div class="site_presentation"><small>{{ mb_strimwidth($s->presentation, 0, 100, '...') }}</small></div>
    @if (!$noUser)
    <div>
        <i class="fa fa-user-o" aria-hidden="true"></i>
        <a href="{{ url('user/profile') }}/{{ $s->user_id }}">{{ un($users, $s->user_id) }}</a>
    </div>
    @endif
</div>