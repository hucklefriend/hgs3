@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('サイト管理') }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')
    @if ($isTakeOver)
        <p>
            「{{ $site->name }}」から引き継ぎます。<br>
            変更がある場合は入力内容を修正して、登録してください。<br>
            入力項目のほかに、登録日時、INカウント、OUTカウント、日別アクセス数で引き継ぎます。
        </p>
    @endif

    <form method="POST" action="{{ route('サイト登録処理') }}" enctype="multipart/form-data" autocomplete="off">
        {{ csrf_field() }}
        @include('user.siteManage.common.form')

        <input type="hidden" name="hgs2_site_id" value="{{ $hgs2SiteId ?? 0 }}">

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
    </form>

    @include('user.siteManage.common.handleSoftSelect')

@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('マイページ') }}">ユーザー</a></li>
            <li class="breadcrumb-item"><a href="{{ route('サイト管理') }}">サイト</a></li>
            <li class="breadcrumb-item active" aria-current="page">新規登録</li>
        </ol>
    </nav>
@endsection
