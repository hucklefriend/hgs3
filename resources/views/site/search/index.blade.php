@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-header">新着サイト</div>
                <div class="card-body">
                    @foreach ($newcomer as $site)
                        @include('site.common.normal', ['s' => $site, 'users' => $users])
                    @endforeach
                </div>
            </div>
            <hr>
        </div>
        <div class="col-6">
            <div class="card">
                <div class="card-header">更新サイト</div>
                <div class="card-body">
                    @foreach ($updated as $site)
                        @include('site.common.normal', ['s' => $site, 'users' => $users])
                    @endforeach
                </div>
            </div>
            <hr>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-header">人気サイト</div>
                <div class="card-body">
                    @foreach ($good as $site)
                        @include('site.common.normal', ['s' => $site, 'users' => $users])
                    @endforeach
                </div>
            </div>
            <hr>
        </div>
        <div class="col-6">
            <div class="card">
                <div class="card-header">アクセスランキング</div>
                <div class="card-body">
                    @foreach ($access as $site)
                        @include('site.common.normal', ['s' => $site, 'users' => $users])
                    @endforeach
                </div>
            </div>
            <hr>
        </div>
    </div>
@endsection