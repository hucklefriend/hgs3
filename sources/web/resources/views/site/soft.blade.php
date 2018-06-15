@extends('layouts.app')

@section('title'){{ $soft->name }}を扱っているサイト@endsection
@section('global_back_link'){{ \Hgs3\Http\GlobalBack::siteBySoft($soft) }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>{{ $soft->name }}</h1>
            <p>を取り扱っているサイト</p>
        </header>

        <div class="row">
        @foreach ($pager as $p)
            <?php $s = $sites[$p->site_id]; ?>
                <div class="mb-5 col-12 col-md-6">
                @include('site.common.normal', ['s' => $s, 'u' => $users[$s->user_id]])
            </div>
        @endforeach
        </div>
        @include('common.pager', ['pager' => $pager])
    </div>
@endsection

