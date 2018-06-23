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
                @php $attributes = $user->getAttributes(); @endphp
            <div class="col-12 col-md-6 col-xl-5">
                <div class="card user-card">
                    <div class="card-body">
                        <div class="mb-3 d-flex">
                            <img src="{{ user_icon_url($user, true) }}">
                            <p class="d-inline-block lead">{{ $user->name }}</p>
                        </div>
                        @if (!empty($attributes))
                        <div class="my-2">
                            @foreach ($attributes as $attr)
                                <div class="user-attribute">{{ \Hgs3\Constants\User\Attribute::$text[$attr] }}</div>
                            @endforeach
                        </div>
                        @endif
                        @if (!empty($user->profile))
                        <p><small>{!! nl2br(e(str_limit($user->profile, 200))) !!}</small></p>
                        @endif

                        <div class="text-right">
                            <a href="{{ route('プロフィール', ['showId' => $user->show_id]) }}" class="and-more">プロフィールを見る<i class="fas fa-angle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @include('common.pager', ['pager' => $users])
        @endif
    </div>
@endsection

