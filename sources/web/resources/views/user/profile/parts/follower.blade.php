
<div class="card">
    <div class="card-body">

@if ($followers->count() == 0)
    <div>フォロワーはいません。</div>
@endif

@foreach ($followers as $follower)
    @isset($users[$follower->user_id])
        @php $u = $users[$follower->user_id]; @endphp
        <div class="d-table-row">
            <div class="d-table-cell">
                <div class="mb-5">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="align-self-center user-name-big">
                            @include('user.common.icon', ['u' => $u])
                            @include('user.common.user_name', ['u' => $u])
                        </div>
                    </div>
                    <div>
                        {{ format_date($follower->follow_timestamp) }}
                        @isset($mutualFollow[$follower->user_id])
                            <span class="mutual-follow-icon"><abbr title="相互フォロー"><i class="far fa-handshake"></i></abbr></span>
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    @endisset
@endforeach

@include('common.pager', ['pager' => $followers])
    </div>
</div>