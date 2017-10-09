@foreach ($follows as $f)
    @isset($users[$f->follow_user_id])
        @php $u = $users[$f->follow_user_id]; @endphp
        <div>
            @include('user.common.icon', ['u' => $u])
            <a href="{{ url2('user/profile') }}/{{ $f->follow_user_id }}">@include('user.common.user_name', ['id' => $u->id, 'name' => $u->name])</a>
        </div>
        @if (!$loop->last) <hr> @endif
    @endisset


@endforeach

{{ $follows->links('vendor.pagination.simple-bootstrap-4') }}