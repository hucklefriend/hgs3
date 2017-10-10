@foreach ($follows as $f)
    @isset($users[$f->follow_user_id])
        @php $u = $users[$f->follow_user_id]; @endphp
        <div class="d-flex justify-content-between align-items-center">
            <div class="p-2 align-self-center">
                <a href="{{ url2('user/profile') }}/{{ $f->follow_user_id }}">
                    @include('user.common.icon', ['u' => $u])
                    @include('user.common.user_name', ['id' => $u->id, 'name' => $u->name])
                </a>
            </div>
            <div class="p-2 text-right">
                <button class="btn btn-danger btn-sm"><small>フォロー解除</small></button>
            </div>
        </div>
        @if (!$loop->last) <hr> @endif
    @endisset
@endforeach
<br>
{{ $follows->links('vendor.pagination.simple-bootstrap-4') }}