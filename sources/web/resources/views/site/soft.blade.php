@extends('layouts.app')

@section('title'){{ $soft->name }}を扱っているサイト@endsection
@section('global_back_link'){{ \Hgs3\Http\GlobalBack::siteBySoft($soft) }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>{{ $soft->name }}</h1>
            <p>取扱いサイト</p>
        </header>

        @foreach ($pager as $p)
            <?php $s = $sites[$p->site_id]; ?>
            <div style="margin-top: 10px;margin-bottom: 30px;">
                @include('site.common.normal', ['s' => $s, 'u' => $users[$s->user_id]])
            </div>
        @endforeach
        @include('common.pager', ['pager' => $pager])
    </div>
@endsection

