@extends('layouts.app')

@section('content')

    <nav>
        <a href="{{ url('') }}">トップ</a>
    </nav>


    <section>
        <h4>新着</h4>
        @if (empty($newArrival))
            <p>新着レビューはありません。</p>
        @elseif
            <div>
                @foreach ($newArrival as $r)
                    <div class="row">
                        <div class="col-2"></div>
                        <div class="col-10"></div>
                    </div>
                    <div class="row">
                        <div class="col-1"></div>
                        <div>
                            <p>{{ $r->title }}</p>
                            <p>{{ $users[$r->user_id]['name'] }} {{ $r->post_date }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>

    <hr>

    <section>
        <h4>高評価</h4>

    </section>

    <hr>

    <section>
        <h4>いいね(直近1ヶ月)</h4>
    </section>

@endsection