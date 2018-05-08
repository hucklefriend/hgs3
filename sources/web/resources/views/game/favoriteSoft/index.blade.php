@extends('layouts.app')

@section('title')お気に入りゲーム@endsection
@section('global_back_link'){{ route('ゲーム詳細', ['soft' => $soft->id]) }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>{{ $soft->name }}</h1>
            <p>お気に入り登録ユーザー</p>
        </header>

        <div class="card">
            <div class="card-body">
                @if ($favoriteUsers->count() == 0)
                    <div>お気に入り登録ユーザーはいません。</div>
                @endif
                <div class="contacts row">
                    @foreach ($favoriteUsers as $favoriteUser)
                        @isset($users[$favoriteUser->user_id])
                            @php $u = $users[$favoriteUser->user_id]; @endphp

                            <div class="col-lg-2 col-md-3 col-sm-4 col-6">
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
                                            <span style="font-size: 1rem;">{{ follow_status_icon($followStatus, $favoriteUser->user_id) }}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                        @endisset
                    @endforeach
                </div>

                @include('common.pager', ['pager' => $favoriteUsers])
            </div>
        </div>
    </div>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('ゲーム一覧') }}">ゲーム一覧</a></li>
            <li class="breadcrumb-item"><a href="{{ route('ゲーム詳細', ['soft' => $soft->id]) }}">詳細</a></li>
            <li class="breadcrumb-item active" aria-current="page">お気に入り登録ユーザー</li>
        </ol>
    </nav>
@endsection
