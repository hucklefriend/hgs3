@php
    if (!isset($noUser))
        $noUser = false;
@endphp
<div>
    <h5><a href="{{ url('site/detail') }}/{{ $s->id }}">{{ $s->name }}</a></h5>
    @if (!empty($s->list_banner_url))
        <div class="list_site_banner_outline">
            <a href="{{ url('site/detail') }}/{{ $s->id }}"><img src="{{ $s->list_banner_url }}" class="img-responsive"></a>
        </div>
    @endif
    @if (!$noUser)
    <div>
        <i class="fa fa-user-o" aria-hidden="true"></i>
        <a href="{{ url('user/profile') }}/{{ $s->user_id }}">{{ un($users, $s->user_id) }}</a>
    </div>
    @endif
</div>