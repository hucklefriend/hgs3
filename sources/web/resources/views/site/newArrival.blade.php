@extends('layouts.app')

@section('title')新着サイト@endsection
@section('global_back_link'){{ \Hgs3\Http\GlobalBack::clearAndRoute('サイトトップ') }}@endsection

@section('content')

    <div class="content__inner">
        <header class="content__title">
            <h1>新着サイト</h1>
        </header>

        @foreach ($newArrivals as $newArrival)
            @php
                $s = $sites[$newArrival->site_id];
                $u = $users[$s->user_id];
            @endphp

            <div style="margin-bottom: 50px;">
                <div>
                    <span class="badge badge-info">{{ format_date($newArrival->registered_timestamp) }}登録！</span>
                </div>
                @include('site.common.normal', ['s' => $s, 'u' => $u])
            </div>
        @endforeach
        @include('common.pager', ['pager' => $newArrivals])

    </div>
@endsection
