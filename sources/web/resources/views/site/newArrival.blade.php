@extends('layouts.app')

@section('title')新着サイト@endsection
@section('global_back_link'){{ \Hgs3\Http\GlobalBack::clearAndRoute('サイトトップ') }}@endsection

@section('content')

    <div class="content__inner">
        <header class="content__title">
            <h1>新着サイト</h1>
            <p>3ヶ月以内に登録されたサイト</p>
        </header>

        <div class="row">
        @foreach ($newArrivals as $newArrival)
            @php
                $s = $sites[$newArrival->site_id];
                $u = $users[$s->user_id];
            @endphp

            <div class="mb-5 col-12 col-md-6">
                <div>
                    <span class="badge badge-info">{{ format_date($newArrival->registered_timestamp) }}登録！</span>
                </div>
                @include('site.common.normal', ['s' => $s, 'u' => $u])
            </div>
        @endforeach
        </div>
        @include('common.pager', ['pager' => $newArrivals])
    </div>
@endsection
