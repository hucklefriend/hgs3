
<div class="card">
    <div class="card-body">
@if ($follows->count() == 0)
        <div>フォローはいません。</div>
@endif
        <div class="row">
            @foreach ($follows as $f)
                @isset($users[$f->follow_user_id])
                    @php $u = $users[$f->follow_user_id]; @endphp

                    <div class="col-xl-4 col-lg-6 col-12">
                        @if ($isMyself)
                        <div class="site-list-prepend">
                            <div class="align-self-center"><small>{{ format_date($f->follow_timestamp) }} フォロー</small></div>
                            <div class="align-self-center">
                                <form method="POST" action="{{ route('フォロー解除') }}" class="mt-3" onsubmit="return confirm('{{ $u->name }}さんのフォローを解除します。')">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <input type="hidden" name="follow_user_id" value="{{ $u->show_id }}">
                                    <button class="btn btn-outline-danger btn-sm">解除</button>
                                </form>
                            </div>
                        </div>
                        @endif

                        @include ('friend.common.parts', ['user' => $u, 'attributes' => $u->getUserAttributes(), 'mutual' => $mutualFollower])
                    </div>

                @endisset
            @endforeach
        </div>

        @include('common.pager', ['pager' => $follows])
    </div>
</div>