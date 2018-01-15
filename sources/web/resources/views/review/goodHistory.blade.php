@extends('layouts.app')

@section('content')

    @include ('review.common.head', ['writer' => $user])

    <h4 style="margin-top: 20px;">いいねした人たち</h4>

    @foreach ($histories as $history)
        @php $u = $users[$history->user_id] @endphp
        <div class="row">
            <div class="col-1">
                @include('user.common.icon', ['u' => $u])
            </div>
            <div class="col-10">
                @include('user.common.user_name', ['id' => $u->id, 'name' => $u->name])
                <br>
                {{ $history->good_at }}
            </div>
        </div>
        <hr>
    @endforeach

    {{ $histories->links() }}
@endsection
