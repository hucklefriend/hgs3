@extends('layouts.app')

@section('title'){{ $soft->name }}をお気に入り登録しているユーザー@endsection
@section('global_back_link'){{ \Hgs3\Http\GlobalBack::gameFavoriteUserList($soft) }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>{{ $soft->name }}</h1>
            <p>お気に入りに登録しているユーザー</p>
        </header>

        <div class="card">
            <div class="card-body">
                @if ($favoriteUsers->count() == 0)
                    <p class="mb-0">お気に入りに登録しているユーザー</p>
                @endif
                <div class="contacts row">
                    @foreach ($favoriteUsers as $favoriteUser)
                        @isset($users[$favoriteUser->user_id])
                            @php $u = $users[$favoriteUser->user_id]; @endphp

                            <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                <div class="contacts__item">
                                    @if (is_open_profile($u))
                                    <a href="{{ route('プロフィール', ['showId' => $u->show_id]) }}" class="contacts__img">
                                        {{ user_icon($u, true) }}
                                    </a>

                                    <div>
                                        <p>
                                            {{ $u->name }}
                                            <span style="font-size: 1rem;">{{ follow_status_icon($followStatus, $favoriteUser->user_id) }}</span>
                                        </p>
                                    </div>
                                    @else
                                        <span class="contacts__img">
                                            {{ user_icon(null, true) }}
                                        </span>
                                        <div>
                                            <p class="text-muted">(非公開)</p>
                                        </div>
                                    @endif
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
