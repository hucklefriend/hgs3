@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('サイト詳細', ['site' => $site->id]) }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')

    @foreach ($errors->all() as $msg)
        {{ $msg }}<br>
    @endforeach

    <form method="POST" enctype="multipart/form-data" action="{{ route('サイト編集処理', ['site' => $site->id]) }}">
        {{ csrf_field() }}
        {{ method_field('PATCH') }}

        @include('user.siteManage.common.form')

        @include('user.siteManage.common.handleSoftSelect')

        @if ($site->approval_status == \Hgs3\Constants\Site\ApprovalStatus::OK || $site->approval_status == \Hgs3\Constants\Site\ApprovalStatus::WAIT)
        <div class="form-group text-center">
            <button class="btn btn-outline-primary" style="width: 100%;" name="draft" value="0">編集</button>
        </div>
        @else
        <div class="form-group">
            <div class="row">
                <div class="col-6 text-center">
                    <button class="btn btn-outline-secondary" style="width: 90%;" name="draft" value="1">下書き保存</button>

                    <p class="text-muted">
                        <small>
                            下書き保存でも、必須項目は入力が必要です。
                        </small>
                    </p>
                </div>
                <div class="col-6 text-center">
                    <button class="btn btn-outline-primary" style="width: 90%;" name="draft" value="0">登録</button>
                </div>
            </div>
        </div>
        @endif
    </form>

@endsection

@section('outsideContent')
    @include('user.siteManage.common.handleSoftSelect')
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('サイトトップ') }}">サイト</a></li>
            <li class="breadcrumb-item"><a href="{{ route('サイト編集', ['site' => $site->id]) }}">編集</a></li>
            <li class="breadcrumb-item active" aria-current="page">編集</li>
        </ol>
    </nav>
@endsection