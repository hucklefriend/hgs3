@extends('layouts.app')

@section('title')更新サイト@endsection
@section('global_back_link'){{ route('サイトトップ') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>更新サイト</h1>
        </header>

        @foreach ($updateArrivals as $updateArrival)
            @php
                $s = $sites[$updateArrival->site_id];
                $u = $users[$s->user_id];
            @endphp

            <div class="mb-5">
                <div>
                    <span class="badge badge-info">{{ format_date($updateArrival->updated_timestamp) }}更新！</span>
                </div>
                @include('site.common.normal', ['s' => $s, 'u' => $u])
            </div>
        @endforeach
        @include('common.pager', ['pager' => $updateArrivals])
    </div>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('サイトトップ') }}">サイト</a></li>
            <li class="breadcrumb-item active" aria-current="page">更新サイト</li>
        </ol>
    </nav>
@endsection