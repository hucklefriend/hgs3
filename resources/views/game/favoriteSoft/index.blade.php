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
                    <p class="mb-0">お気に入りに登録しているユーザーはいません。</p>
                @endif
                <div class="row">
                    @foreach ($favoriteUsers as $favoriteUser)
                        @isset($users[$favoriteUser->user_id])
                            @php $u = $users[$favoriteUser->user_id]; @endphp
                            <div class="col-12 col-md-6 col-xl-5">
                                @include ('friend.common.parts', ['user' => $u, 'attributes' => $u->getUserAttributes(), 'mutual' => []])
                            </div>
                        @endisset
                    @endforeach
                </div>

                @include('common.pager', ['pager' => $favoriteUsers])
            </div>
        </div>
    </div>
@endsection
