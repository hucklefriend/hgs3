@extends('layouts.app')

@section('content')

    <form>
        <div>



        </div>
    </form>

    @foreach ($pager as $p)
        <?php $s = $sites[$p->site_id]; ?>
        <div>
            <a href="{{ url('site/detail') }}/{{ $s->id }}">{{ $s->name }}</a>
        </div>
    @endforeach
@endsection