@extends('layouts.app')

@section('title')フレンド@endsection
@section('global_back_link'){{ \Hgs3\Http\GlobalBack::clearAndRoute('トップ') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>フレンド</h1>
        </header>

        <div class="row">
            @foreach ($users as $user)
            <div class="col-12 col-md-6 col-xl-5">
                <div class="card">
                    <div class="card-body">
                        <div>
                            {{ $user->name }}
                        </div>
                        @if (!empty($user->profile))
                        <p>{!! nl2br(e(str_limit($user->profile, 200))) !!}</p>
                        @endif
                        <div>

                        </div>


                        <div class="text-right">
                            <a href="#" class="and-more">プロフィールを見る<i class="fas fa-angle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @include('common.pager', ['pager' => $users])
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
