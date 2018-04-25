
<div class="card">
    <div class="card-body">

@if ($followers->count() == 0)
    <div>フォロワーはいません。</div>
@endif
        <div class="contacts row">

@foreach ($followers as $follower)
    @isset($users[$follower->user_id])
        @php $u = $users[$follower->user_id]; @endphp

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
                            @isset($mutualFollow[$follower->user_id])
                                <span class="mutual-follow-icon ml-2"><small><i class="far fa-handshake"></i></small></span>
                            @endisset
                        </p>
                        <div>
                            <small>{{ format_date($follower->follow_timestamp) }}</small>
                        </div>
                    </div>
                </div>
            </div>
    @endisset
@endforeach
        </div>

@include('common.pager', ['pager' => $followers])
    </div>
</div>