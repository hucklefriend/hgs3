@extends('layouts.app')

@section('content')


    <div class="d-flex align-items-stretch">
        <div class="p-2 align-self-center" style="min-width: 3em;">
            @include('user.common.icon', ['u' => $user])
        </div>
        <div class="p-10 align-self-center">
            <h5>@include('user.common.user_name', ['id' => $user->id, 'name' => $user->name])さんのマイページ</h5>
            <div>
                <a href="{{ url2('user/profile') }}">プロフィール確認</a>
            </div>
        </div>
    </div>

    <hr>

    <section>
        <h5>タイムライン</h5>

        @foreach ($timelines as $tl)
            <div>{{ date('Y-m-d H:i:s', $tl['time']) }}</div>
            <p>{!!  $tl['text'] !!}</p>
            <hr>
        @endforeach
        {{ $pager->links('vendor.pagination.simple-bootstrap-4') }}
    </section>

@endsection