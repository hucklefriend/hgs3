@if ($followers->count() == 0)
    <p>フォロワーはいません。</p>
@endif

@foreach ($followers as $follower)
    @isset($users[$follower->user_id])
        @php $u = $users[$follower->user_id]; @endphp
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="p-2 align-self-center">
                @include('user.common.icon', ['u' => $u])
                @include('user.common.user_name', ['u' => $u])
            </div>
            @if ($u->id == Auth::id())
                <div class="p-2 text-right">
                    <form method="POST" action="{{ route('フォロー解除') }}">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <input type="hidden" name="follow_user_id" value="{{ $user->show_id }}">
                        <button class="btn btn-danger btn-sm"><small>フォロー解除</small></button>
                    </form>
                </div>
            @endif
        </div>
    @endisset
@endforeach

{{ $followers->links('vendor.pagination.simple-bootstrap-4') }}