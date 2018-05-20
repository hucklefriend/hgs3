@extends('layouts.app')

@section('title')レビュー@endsection
@section('global_back_link'){{ route('トップ') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>レビュー</h1>
        </header>

        <div class="card card-hgn">
            <div class="card-body">
                <h4 class="card-title">新着レビュー</h4>



            </div>
        </div>


        <div class="card card-hgn">
            <div class="card-body">
                <h4 class="card-title">いいねの多いレビュー</h4>
                <p>工事中</p>
            </div>
        </div>

    </div>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item active" aria-current="page">レビュー</li>
        </ol>
    </nav>
@endsection