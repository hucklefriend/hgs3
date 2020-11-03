@extends('layouts.app')

@section('content')

    <div class="card">
        <div class="card-header"></div>
        <div class="card-block">
            @foreach ($newcomer as $site)

            @endforeach
        </div>
    </div>

    @foreach ($pager as $p)
        <?php $s = $sites[$p->site_id]; ?>
        <div>
            <a href="{{ url('site/detail') }}/{{ $s->id }}">{{ $s->name }}</a>
        </div>
    @endforeach
@endsection