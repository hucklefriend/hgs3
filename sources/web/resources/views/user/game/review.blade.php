@extends('layouts.app')

@section('content')

    <section>
        @foreach ($reviews as $r)
            <div class="row">
                <div class="col-1">
                    <img src="{{ $packages[$r->package_id]->small_image_url }}" class="thumbnail"><br>
                    {{ $packages[$r->package_id]->name }}
                </div>
                <div class="col-1">{{ $r->point }}</div>
                <div class="col-10">
                    <p><a href="{{ url('game/review/detail/') }}/{{ $r->id }}">{{ $r->title }}</a></p>
                    <p>{{ $r->post_date }}</p>
                </div>
            </div>
        @endforeach
    </section>

@endsection