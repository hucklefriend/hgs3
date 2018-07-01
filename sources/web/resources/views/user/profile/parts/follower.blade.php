
<div class="card">
    <div class="card-body">

@if ($followers->count() == 0)
    <div>フォロワーはいません。</div>
@endif
        <div class="row">

@foreach ($followers as $follower)
    @isset($users[$follower->user_id])
        @php $u = $users[$follower->user_id]; @endphp
            <div class="col-xl-4 col-lg-6 col-12">
                @include ('friend.common.parts', ['user' => $u, 'attributes' => $u->getAttributes(), 'mutual' => $mutualFollow])
            </div>
    @endisset
@endforeach
        </div>

@include('common.pager', ['pager' => $followers])
    </div>
</div>