@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('サイトトップ') }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')
    <h1>更新サイト</h1>

    <div class="d-flex flex-row">
        <div class="d-none d-sm-block">
            <div class="site-side-menu">
                @include('site.common.sideMenu', ['active' => '更新'])
            </div>
        </div>
        <div style="width: 100%;">
            @if ($sites->isEmpty())
                更新サイトはありません。
            @endif
            @foreach ($sites as $s)
                @php
                    $u = $users[$s->user_id];
                @endphp

                <div style="margin-bottom: 50px;">
                    <div>
                        <span class="badge badge-info">{{ date('Y/m/d H:i', $s->updated_timestamp) }}更新！</span>
                    </div>
                    @include('site.common.normal', ['s' => $s, 'u' => $u])
                </div>
            @endforeach
            @include('common.pager', ['pager' => $sites])
        </div>
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