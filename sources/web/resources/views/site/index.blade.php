@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-sm-6">
            <div class="card card-hgn">
                <div class="card-header">新着サイト</div>
                <div class="card-body">
                    @foreach ($newArrivals as $site)
                        @include('site.common.normal', ['s' => $site, 'users' => $users])
                        @if (!$loop->last) <hr> @endif
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card card-hgn">
                <div class="card-header">更新サイト</div>
                <div class="card-body">
                    @foreach ($updated as $site)
                        @include('site.common.normal', ['s' => $site, 'users' => $users])
                        @if (!$loop->last) <hr> @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="card card-hgn">
                <div class="card-header">人気サイト</div>
                <div class="card-body">
                    @foreach ($good as $site)
                        @include('site.common.normal', ['s' => $site, 'users' => $users])
                        @if (!$loop->last) <hr> @endif
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card card-hgn">
                <div class="card-header">アクセスランキング</div>
                <div class="card-body">
                    @foreach ($access as $site)
                        @include('site.common.normal', ['s' => $site, 'users' => $users])
                        @if (!$loop->last) <hr> @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection