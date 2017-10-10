@foreach ($followers as $f)
    @isset($users[$f->user_id])
        @php $u = $users[$f->user_id]; @endphp
        <div class="d-flex justify-content-between align-items-center">
            <div class="p-2 align-self-center">
                <a href="{{ url2('user/profile') }}/{{ $f->user_id }}">
                    @include('user.common.icon', ['u' => $u])
                    @include('user.common.user_name', ['id' => $u->id, 'name' => $u->name])
                </a>
            </div>
        </div>
        @if (!$loop->last) <hr> @endif
    @endisset
@endforeach
<br>
{{ $followers->links('vendor.pagination.simple-bootstrap-4') }}