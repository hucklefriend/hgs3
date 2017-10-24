@extends('layouts.app')

@section('content')

    <section>
        <a href="{{ url('game/soft') }}/{{ $soft->id }}">詳細</a>
    </section>

    <h3>{{ $soft->name }}</h3>
    @foreach ($pager as $p)
        <?php $s = $sites[$p->site_id]; ?>
        <div>
            @include('site.common.normal', ['s' => $s])
        </div>
        <hr>
    @endforeach
@endsection