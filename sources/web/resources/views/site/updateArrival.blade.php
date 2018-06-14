@extends('layouts.app')

@section('title')更新サイト@endsection
@section('global_back_link'){{ \Hgs3\Http\GlobalBack::clearAndRoute('サイトトップ') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>更新サイト</h1>
            <p>3ヶ月以内に更新されたサイト</p>
        </header>

        <div class="row">
        @foreach ($updateArrivals as $updateArrival)
            @php
                $s = $sites[$updateArrival->site_id];
                $u = $users[$s->user_id];
            @endphp

            <div class="mb-5 col-12 col-md-6">
                <div>
                    <span class="badge badge-info">{{ format_date($updateArrival->updated_timestamp) }}更新！</span>
                </div>
                @include('site.common.normal', ['s' => $s, 'u' => $u])
            </div>
        @endforeach
        </div>
        @include('common.pager', ['pager' => $updateArrivals])
    </div>
@endsection
