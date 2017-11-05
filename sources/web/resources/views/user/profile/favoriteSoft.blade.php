@extends('layouts.app')

@section('content')
    <div class="d-flex align-items-stretch">
        <div class="p-2 align-self-center" style="min-width: 3em;">
            @include('user.common.icon', ['u' => $user])
        </div>
        <div class="p-10 align-self-center">
            <h5>{{ $user->name }}さんのお気に入りゲーム</h5>
            <div>
                <a href="{{ url2('user/profile') }}/{{ $user->id }}/favorite_soft">プロフィール</a>
            </div>
        </div>
    </div>
    <hr>
    @include('user.profile.parts.favoriteSoft')
@endsection