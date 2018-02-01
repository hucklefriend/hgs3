@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('サイトトップ') }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')
    <h1>新着サイト</h1>

    <div class="d-flex flex-row">
        <div class="d-none d-sm-block">
            <div class="site-side-menu">
                @include('site.common.sideMenu', ['active' => '新着'])
            </div>
        </div>
        <div style="width: 100%;">
            @foreach ($newArrivals as $newArrival)
                @php
                    $s = $sites[$newArrival->site_id];
                    $u = $users[$s->user_id];
                @endphp

                <div class="alert alert-success d-inline-block" role="alert" style="padding:0.5rem;">{{ date('Y/m/d H:i', $newArrival->registered_timestamp) }}登録！</div>
                @include('site.common.normal', ['s' => $s, 'u' => $u])
                @if (!$loop->last) <hr> @endif
            @endforeach
            @include('common.pager', ['pager' => $newArrivals])
        </div>
    </div>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('サイトトップ') }}">サイト</a></li>
            <li class="breadcrumb-item active" aria-current="page">新着サイト</li>
        </ol>
    </nav>
@endsection