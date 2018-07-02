@extends('layouts.app')

@section('title')フレンド@endsection
@section('global_back_link'){{ \Hgs3\Http\GlobalBack::clearAndRoute('トップ') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>フレンド</h1>
        </header>

        @if ($users->isEmpty())
            <p>
                プロフィール公開しているユーザーがいません。<br>
                ログインしてください。
            </p>
            <div>
                <a href="{{ route('ログイン') }}" class="and-more">ログイン <i class="fas fa-angle-right"></i></a>
            </div>
        @else
        <div class="row">
            @foreach ($users as $user)
                @php $attributes = $user->getUserAttributes(); @endphp
                <div class="col-12 col-md-6 col-xl-5">
                    @include ('friend.common.parts', ['user' => $user, 'attributes' => $attributes, 'mutual' => []])
                </div>
            @endforeach
        </div>

        @include('common.pager', ['pager' => $users])
        @endif
    </div>
@endsection

