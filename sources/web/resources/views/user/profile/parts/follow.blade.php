
<div class="card">
    <div class="card-body">
@if ($follows->count() == 0)
        <div>フォローはいません。</div>
@endif
        <div class="contacts row">
            @foreach ($follows as $f)
                @isset($users[$f->follow_user_id])
                    @php $u = $users[$f->follow_user_id]; @endphp

            <div class="col-xl-2 col-lg-3 col-sm-6 col-6">
                <div class="contacts__item">
                    <a href="{{ route('プロフィール', ['showId' => $u->show_id]) }}" class="contacts__img">
                        @if ($u->icon_upload_flag == 1)
                            <img src="{{ url('img/user_icon/' . $u->icon_file_name) }}" class="{{ \Hgs3\Constants\IconRoundType::getClass($u->icon_round_type) }}">
                        @else
                            <img src="{{ url('img/user-no-img.svg') }}" class="rounded-0">
                        @endif
                    </a>

                    <div>
                        <p>
                        {{ $u->name }}
                        @isset($mutualFollower[$f->follow_user_id])
                            <span class="mutual-follow-icon ml-2"><small><i class="far fa-handshake"></i></small></span>
                        @endisset
                        </p>
                        <div>
                            <small>{{ format_date($f->follow_timestamp) }}</small>
                        </div>
                    </div>

                    @if ($isMyself)
                        <form method="POST" action="{{ route('フォロー解除') }}" class="mt-3">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <input type="hidden" name="follow_user_id" value="{{ $u->show_id }}">
                            <button class="btn btn-warning btn-sm">フォロー解除</button>
                        </form>
                    @endif
                </div>
            </div>

                @endisset
            @endforeach
        </div>


        @include('common.pager', ['pager' => $follows])
    </div>
</div>