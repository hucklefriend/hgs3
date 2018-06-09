@extends('layouts.app')

@section('title')サイト編集@endsection
@section('global_back_link'){{ \Hgs3\Http\GlobalBack::clearAndRoute('サイト詳細', ['site' => $site->id]) }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>サイト編集</h1>
        </header>


        @foreach ($errors->all() as $msg)
            {{ $msg }}<br>
        @endforeach

        <form method="POST" enctype="multipart/form-data" action="{{ route('サイト編集処理', ['site' => $site->id]) }}">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}

            @include('user.siteManage.common.form')

            @include('user.siteManage.common.handleSoftSelect')

            <div class="form-group mt-5">
                @if ($site->approval_status == \Hgs3\Constants\Site\ApprovalStatus::DRAFT)
                    <button class="btn btn-secondary btn-lg">下書き保存</button>
                @else
                    <button class="btn btn-primary btn-lg">保存</button>
                @endif
            </div>
        </form>
    </div>
@endsection

@section('outsideContent')
    @include('user.siteManage.common.handleSoftSelect')
@endsection
