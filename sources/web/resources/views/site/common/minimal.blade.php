@php
    if (!isset($noUser))
        $noUser = false;
@endphp
<div>
    <h5><a href="{{ url('site/detail') }}/{{ $s->id }}">{{ $s->name }}</a></h5>
    <img src="{{ url2('img/banner/test/200x40.gif') }}">
    @if (!$noUser)
    <div>
        <i class="fa fa-user-o" aria-hidden="true"></i>
        <a href="{{ url('user/profile') }}/{{ $s->user_id }}">{{ un($users, $s->user_id) }}</a>
    </div>
    @endif
</div>