@extends('layouts.app')

@section('content')

    <div class="d-flex align-items-stretch">
        <div class="p-2 align-self-center" style="min-width: 3em;">
            @include('user.common.icon', ['u' => $user])
        </div>
        <div class="p-10 align-self-center">
            <h5>@include('user.common.user_name', ['id' => $user->id, 'name' => $user->name])さんがフォローしているユーザー</h5>
            <div>
                <a href="{{ url2('user/profile') }}">プロフィール</a>
            </div>
        </div>
    </div>

    <hr>

    @foreach ($follows as $f)
        @isset($users[$f->follow_user_id])
            @php $u = $users[$f->follow_user_id]; @endphp
            <div>
                @include('user.common.icon', ['u' => $u])
                <a href="{{ url2('user/profile') }}/{{ $f->follow_user_id }}">@include('user.common.user_name', ['id' => $u->id, 'name' => $u->name])</a>
                <button class="btn btn-danger btn-sm">フォロー解除</button>
            </div>
            @if (!$loop->last) <hr> @endif
        @endisset
    @endforeach
    <br>
    {{ $follows->links('vendor.pagination.simple-bootstrap-4') }}

@endsection